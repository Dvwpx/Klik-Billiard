<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'featured_image' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:open,closed',
            'map_url' => 'nullable|url|max:255',
        ]);

        Location::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'city' => $request->city,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'featured_image' => $request->featured_image, // langsung dari URL Cloudinary
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'featured_image' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:open,closed',
            'map_url' => 'nullable|url|max:255',
        ]);

        // Cek jika featured_image diganti
        if ($request->featured_image && $request->featured_image !== $location->featured_image) {
            if ($location->featured_image) {
                $this->deleteFromCloudinary($location->featured_image);
            }
            $location->featured_image = $request->featured_image;
        }

        $location->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'city' => $request->city,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
            'map_url' => $request->map_url,
        ]);

        return redirect()->route('locations.index')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        try {
            if ($location->featured_image) {
                $this->deleteFromCloudinary($location->featured_image);
            }

            $location->delete();

            return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus lokasi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus lokasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus gambar dari Cloudinary berdasarkan URL
     */
    private function deleteFromCloudinary($imageUrl)
    {
        try {
            $cloudinary = new CloudinaryApi([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ]
            ]);

            $publicId = $this->extractPublicIdFromUrl($imageUrl);

            if ($publicId) {
                $cloudinary->uploadApi()->destroy($publicId);
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus gambar dari Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Ambil public_id dari URL Cloudinary
     */
    private function extractPublicIdFromUrl($url)
    {
        // Contoh URL: https://res.cloudinary.com/xxx/image/upload/v1234567890/klikbilliard/locations/image-name.jpg
        // Output: klikbilliard/locations/image-name
        $pattern = '/\/v\d+\/([^\.]+)\./';
        preg_match($pattern, $url, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }
}
