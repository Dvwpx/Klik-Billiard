<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Cloudinary as CloudinaryApi;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('pages.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('pages.promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image_url' => 'required|url',
            'link_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

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
                $request->file('banner_image')->getRealPath(),
                [
                    'folder' => 'klikbilliard/promos'
                ]
            );

            $uploadedImageUrl = $request->banner_image_url;

            Promo::create([
                'title' => $request->title,
                'description' => $request->description,
                'banner_image' => $uploadedImageUrl,
                'link_url' => $request->link_url,
                'status' => $request->status,
            ]);

            return redirect()->route('promos.index')->with('success', 'Promo berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload error: ' . $e->getMessage());
            return back()->withErrors(['banner_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
        }
    }

    public function edit(Promo $promo)
    {
        return view('pages.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'link_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $promo->banner_image;

        if ($request->hasFile('banner_image')) {
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
                    $request->file('banner_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/promos'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($promo->banner_image) {
                    $this->deleteFromCloudinary($promo->banner_image);
                }
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['banner_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $promo->update([
            'title' => $request->title,
            'description' => $request->description,
            'banner_image' => $imagePath,
            'link_url' => $request->link_url,
            'status' => $request->status,
        ]);

        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($promo->banner_image) {
                $this->deleteFromCloudinary($promo->banner_image);
            }

            $promo->delete();

            return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus promo: ' . $e->getMessage()]);
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
