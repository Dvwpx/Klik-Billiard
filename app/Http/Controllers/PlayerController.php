<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            'profile_image' => 'nullable|url',
            'bio' => 'nullable|string',
            'achievements' => 'nullable|string',
            'status' => 'required|in:active,inactive,retired',
        ]);

        Player::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'nickname' => $request->nickname,
            'profile_image' => $request->profile_image, // sudah berupa URL dari Cloudinary
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
            'profile_image' => 'nullable|url',
            'bio' => 'nullable|string',
            'achievements' => 'nullable|string',
            'status' => 'required|in:active,inactive,retired',
        ]);

        // Cek jika URL baru diinput, dan berbeda dari yang lama
        if ($request->profile_image && $request->profile_image !== $player->profile_image) {
            // Hapus gambar lama
            if ($player->profile_image) {
                $this->deleteFromCloudinary($player->profile_image);
            }

            $player->profile_image = $request->profile_image;
        }

        $player->name = $request->name;
        $player->slug = Str::slug($request->name);
        $player->nickname = $request->nickname;
        $player->bio = $request->bio;
        $player->achievements = $request->achievements;
        $player->status = $request->status;
        $player->save();

        return redirect()->route('players.index')->with('success', 'Profil pemain berhasil diperbarui.');
    }

    public function destroy(Player $player)
    {
        try {
            if ($player->profile_image) {
                $this->deleteFromCloudinary($player->profile_image);
            }

            $player->delete();

            return redirect()->route('players.index')->with('success', 'Profil pemain berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus profil pemain: ' . $e->getMessage()]);
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
        return isset($matches[1]) ? $matches[1] : null;
    }
}
