<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::latest()->get();
        return view('pages.players.index', compact('players'));
    }

    public function create()
    {
        return view('pages.players.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6096',
            'bio' => 'nullable|string',
            'achievements' => 'nullable|string',
            'status' => 'required|in:active,inactive,retired',
        ]);

        $imagePath = null;

        if ($request->hasFile('profile_image')) {
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
                    $request->file('profile_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/players',
                        'public_id' => Str::slug($request->name) . '-' . time()
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['profile_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        Player::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'nickname' => $request->nickname,
            'profile_image' => $imagePath,
            'bio' => $request->bio,
            'achievements' => $request->achievements,
            'status' => $request->status,
        ]);

        return redirect()->route('players.index')->with('success', 'Profil pemain baru berhasil ditambahkan.');
    }

    public function edit(Player $player)
    {
        return view('pages.players.edit', compact('player'));
    }

    public function update(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6096',
            'bio' => 'nullable|string',
            'achievements' => 'nullable|string',
            'status' => 'required|in:active,inactive,retired',
        ]);

        $player->name = $request->name;
        $player->slug = Str::slug($request->name);
        $player->nickname = $request->nickname;
        $player->bio = $request->bio;
        $player->achievements = $request->achievements;
        $player->status = $request->status;

        if ($request->hasFile('profile_image')) {
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
                    $request->file('profile_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/players',
                        'public_id' => Str::slug($request->name) . '-' . time()
                    ]
                );

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($player->profile_image) {
                    $this->deleteFromCloudinary($player->profile_image);
                }

                $player->profile_image = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['profile_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $player->save();

        return redirect()->route('players.index')->with('success', 'Profil pemain berhasil diperbarui.');
    }

    public function destroy(Player $player)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($player->profile_image) {
                $this->deleteFromCloudinary($player->profile_image);
            }

            $player->delete();

            return redirect()->route('players.index')->with('success', 'Profil pemain berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus profil pemain: ' . $e->getMessage()]);
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
