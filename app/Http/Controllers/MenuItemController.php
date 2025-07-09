<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Cloudinary as CloudinaryApi;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::latest()->get();
        return view('pages.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        return view('pages.menu-items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Tersedia,Habis',
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

                $uploadResult = $cloudinary->uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/menu-items'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        MenuItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function edit(MenuItem $menuItem)
    {
        return view('pages.menu-items.edit', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Tersedia,Habis',
        ]);

        $imagePath = $menuItem->image; // Simpan path gambar lama

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
                        'folder' => 'klikbilliard/menu-items'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($menuItem->image) {
                    $this->deleteFromCloudinary($menuItem->image);
                }
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $menuItem->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Data menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($menuItem->image) {
                $this->deleteFromCloudinary($menuItem->image);
            }

            $menuItem->delete();

            return redirect()->route('menu-items.index')->with('success', 'Menu berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus menu: ' . $e->getMessage()]);
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
