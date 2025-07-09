<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\MenuItem;
use Illuminate\Http\Request;
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
            'image' => 'nullable|url',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Tersedia,Habis',
        ]);

        MenuItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image, // URL langsung dari Cloudinary
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
            'image' => 'nullable|url',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Tersedia,Habis',
        ]);

        // Jika ada image baru dan beda dari sebelumnya
        if ($request->image && $request->image !== $menuItem->image) {
            // Hapus gambar lama
            if ($menuItem->image) {
                $this->deleteFromCloudinary($menuItem->image);
            }

            $menuItem->image = $request->image;
        }

        $menuItem->name = $request->name;
        $menuItem->description = $request->description;
        $menuItem->price = $request->price;
        $menuItem->category = $request->category;
        $menuItem->status = $request->status;

        $menuItem->save();

        return redirect()->route('menu-items.index')->with('success', 'Data menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem)
    {
        try {
            if ($menuItem->image) {
                $this->deleteFromCloudinary($menuItem->image);
            }

            $menuItem->delete();

            return redirect()->route('menu-items.index')->with('success', 'Menu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus menu: ' . $e->getMessage()]);
        }
    }

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
            Log::error('Error deleting from Cloudinary: ' . $e->getMessage());
        }
    }

    private function extractPublicIdFromUrl($url)
    {
        $pattern = '/\/v\d+\/(.+)\./';
        preg_match($pattern, $url, $matches);

        return $matches[1] ?? null;
    }
}
