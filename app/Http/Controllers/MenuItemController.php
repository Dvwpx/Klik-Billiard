<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use Illuminate\Support\Str;

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
            // !! PERUBAHAN DI SINI !!
            // Simpan gambar ke storage/app/public/menu-items
            $imagePath = $request->file('image')->store('menu-items', 'public');
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
            // Hapus gambar lama jika ada
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('menu-items', 'public');
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
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu berhasil dihapus.');
    }
}
