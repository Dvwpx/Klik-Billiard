<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/players'), $imageName);
            $imagePath = 'players/' . $imageName;
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
            if ($player->profile_image) {
                Storage::delete('public/' . $player->profile_image);
            }
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/players'), $imageName);
            $player->profile_image = 'players/' . $imageName;
        }

        $player->save();

        return redirect()->route('players.index')->with('success', 'Profil pemain berhasil diperbarui.');
    }

    public function destroy(Player $player)
    {
        if ($player->profile_image) {
            Storage::delete('public/' . $player->profile_image);
        }
        $player->delete();
        return redirect()->route('players.index')->with('success', 'Profil pemain berhasil dihapus.');
    }
}
