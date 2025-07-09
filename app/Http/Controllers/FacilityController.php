<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

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
            try {
                // Inisialisasi Cloudinary langsung
                $cloudinary = new CloudinaryApi([
                    'cloud' => [
                        'cloud_name' => config('cloudinary.cloud_name'),
                        'api_key' => config('cloudinary.api_key'),
                        'api_secret' => config('cloudinary.api_secret'),
                    ]
                ]);

                // Upload gambar ke Cloudinary
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/facilities',
                        'public_id' => Str::slug($request->name) . '-' . time()
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
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
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/facilities',
                        'public_id' => Str::slug($request->name) . '-' . time()
                    ]
                );

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($facility->image) {
                    $this->deleteFromCloudinary($facility->image);
                }

                $facility->image = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $facility->save();

        return redirect()->route('facilities.index')->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($facility->image) {
                $this->deleteFromCloudinary($facility->image);
            }

            $facility->delete();

            return redirect()->route('facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus fasilitas: ' . $e->getMessage()]);
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
            \Log::error('Error deleting from Cloudinary: ' . $e->getMessage());
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
