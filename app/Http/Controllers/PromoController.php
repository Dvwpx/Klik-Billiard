<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'link_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $request->file('banner_image')->store('promos', 'public');

        Promo::create([
            'title' => $request->title,
            'description' => $request->description,
            'banner_image' => $imagePath,
            'link_url' => $request->link_url,
            'status' => $request->status,
        ]);

        return redirect()->route('promos.index')->with('success', 'Promo baru berhasil ditambahkan.');
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
            if ($promo->banner_image) {
                Storage::disk('public')->delete($promo->banner_image);
            }
            $imagePath = $request->file('banner_image')->store('promos', 'public');
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
        if ($promo->banner_image) {
            Storage::disk('public')->delete($promo->banner_image);
        }
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}
