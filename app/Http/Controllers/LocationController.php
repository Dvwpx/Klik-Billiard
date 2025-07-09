<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

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
            'map_url' => 'nullable|url|max:255',

        ]);

        // Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            try {
                // Inisialisasi Cloudinary langsung
                $cloudinary = new CloudinaryApi([
                    'cloud' => [
                        'cloud_name' => config('cloudinary.cloud_name'),
                        'api_key' => config('cloudinary.api_key'),
                        'api_secret' => config('cloudinary.api_secret'),
                    ]
                ]);

                $uploadResult = $cloudinary->uploadApi()->upload(
                    $request->file('featured_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/locations'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['featured_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
            'map_url' => $request->map_url,
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
            'map_url' => 'nullable|url|max:255',
        ]);

        // Siapkan data untuk update
        $location->name = $request->name;
        $location->slug = Str::slug($request->name);
        $location->address = $request->address;
        $location->city = $request->city;
        $location->description = $request->description;
        $location->phone_number = $request->phone_number;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->status = $request->status;
        $location->map_url = $request->map_url;

        // Proses gambar jika ada yang baru
        if ($request->hasFile('featured_image')) {
            try {
                // Inisialisasi Cloudinary langsung
                $cloudinary = new CloudinaryApi([
                    'cloud' => [
                        'cloud_name' => config('cloudinary.cloud_name'),
                        'api_key' => config('cloudinary.api_key'),
                        'api_secret' => config('cloudinary.api_secret'),
                    ]
                ]);

                // Upload gambar baru ke Cloudinary
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $request->file('featured_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/locations'
                    ]
                );

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($location->featured_image) {
                    $this->deleteFromCloudinary($location->featured_image);
                }

                $location->featured_image = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['featured_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $location->save(); // Simpan perubahan

        return redirect()->route('locations.index')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($location->featured_image) {
                $this->deleteFromCloudinary($location->featured_image);
            }

            $location->delete();

            return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus lokasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Helper method untuk menghapus gambar dari Cloudinary
     */
    private function deleteFromCloudinary($imageUrl)
    {
        try {
            // Inisialisasi Cloudinary
            $cloudinary = new CloudinaryApi([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ]
            ]);

            // Extract public_id dari URL
            $publicId = $this->extractPublicIdFromUrl($imageUrl);

            if ($publicId) {
                $cloudinary->uploadApi()->destroy($publicId);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting from Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk extract public_id dari Cloudinary URL
     */
    private function extractPublicIdFromUrl($url)
    {
        // URL format: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/folder/filename.jpg
        // Public ID: folder/filename (tanpa ekstensi)

        $pattern = '/\/v\d+\/(.+)\./';
        preg_match($pattern, $url, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }
}
