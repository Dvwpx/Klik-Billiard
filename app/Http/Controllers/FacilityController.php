<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->get();
        $amenities = [
            ['icon' => 'fas fa-parking', 'name' => 'Parkir Luas & Aman'],
            ['icon' => 'fas fa-wifi', 'name' => 'Koneksi WiFi Cepat'],
            ['icon' => 'fas fa-mug-hot', 'name' => 'Cafe & Resto'],
            ['icon' => 'fas fa-smoking', 'name' => 'Smoking Area'],
            ['icon' => 'fas fa-restroom', 'name' => 'Toilet Bersih'],
            ['icon' => 'fas fa-baby-carriage', 'name' => 'Area Ramah Anak'],
        ];

        return view('pages.facilities.index', compact('facilities', 'amenities'));
    }

    public function create()
    {
        return view('pages.facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/facilities'), $imageName);
            $imagePath = 'facilities/' . $imageName;
        }

        Facility::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('facilities.index')->with('success', 'Fasilitas baru berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('pages.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'nullable|string',
        ]);

        $facility->name = $request->name;
        $facility->slug = Str::slug($request->name);
        $facility->category = $request->category;
        $facility->description = $request->description;

        if ($request->hasFile('image')) {
            if ($facility->image) {
                Storage::delete('public/' . $facility->image);
            }
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/facilities'), $imageName);
            $facility->image = 'facilities/' . $imageName;
        }

        $facility->save();

        return redirect()->route('facilities.index')->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->image) {
            Storage::delete('public/' . $facility->image);
        }
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
