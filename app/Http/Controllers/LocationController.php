<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->get();
        return view('pages.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('pages.locations.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:open,closed',
        ]);

        // Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/locations'), $imageName);
            $imagePath = 'locations/' . $imageName;
        }

        // Buat data baru
        Location::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'city' => $request->city,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'featured_image' => $imagePath,
            'latitude' => $request->latitude, // Perbaikan di sini
            'longitude' => $request->longitude, // Perbaikan di sini
            'status' => $request->status,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('pages.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:open,closed',
        ]);

        // Siapkan data untuk update
        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->address = $request->address;
        $location->city = $request->city;
        $location->description = $request->description;
        $location->phone_number = $request->phone_number;
        $location->latitude = $request->latitude; // Perbaikan di sini
        $location->longitude = $request->longitude; // Perbaikan di sini
        $location->status = $request->status;

        // Proses gambar jika ada yang baru
        if ($request->hasFile('featured_image')) {
            if ($location->featured_image) {
                Storage::delete('public/' . $location->featured_image);
            }
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/locations'), $imageName);
            $location->featured_image = 'locations/' . $imageName;
        }

        $location->save(); // Simpan perubahan

        return redirect()->route('locations.index')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        if ($location->featured_image) {
            Storage::delete('public/' . $location->featured_image);
        }
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
