<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Location;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with(['location', 'winner'])->latest()->get();
        return view('pages.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $players = Player::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('pages.tournaments.create', compact('players', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Akan Datang,Sedang Berlangsung,Selesai', // <-- PERBAIKAN
            'location_id' => 'nullable|exists:locations,id',
            'winner_id' => 'nullable|exists:players,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('poster_image')) {
            $image = $request->file('poster_image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/tournaments'), $imageName);
            $imagePath = 'tournaments/' . $imageName;
        }

        Tournament::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'poster_image' => $imagePath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'location_id' => $request->location_id,
            'winner_id' => $request->winner_id,
        ]);

        return redirect()->route('tournaments.index')->with('success', 'Turnamen baru berhasil ditambahkan.');
    }

    public function edit(Tournament $tournament)
    {
        $players = Player::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('pages.tournaments.edit', compact('tournament', 'players', 'locations'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Akan Datang,Sedang Berlangsung,Selesai', // <-- PERBAIKAN
            'location_id' => 'nullable|exists:locations,id',
            'winner_id' => 'nullable|exists:players,id',
        ]);

        $tournament->name = $request->name;
        $tournament->slug = Str::slug($request->name);
        $tournament->description = $request->description;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->status = $request->status;
        $tournament->location_id = $request->location_id;
        $tournament->winner_id = $request->winner_id;

        if ($request->hasFile('poster_image')) {
            if ($tournament->poster_image) {
                Storage::delete('public/' . $tournament->poster_image);
            }
            $image = $request->file('poster_image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/tournaments'), $imageName);
            $tournament->poster_image = 'tournaments/' . $imageName;
        }

        $tournament->save();

        return redirect()->route('tournaments.index')->with('success', 'Data turnamen berhasil diperbarui.');
    }

    public function destroy(Tournament $tournament)
    {
        if ($tournament->poster_image) {
            Storage::delete('public/' . $tournament->poster_image);
        }
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil dihapus.');
    }
}
