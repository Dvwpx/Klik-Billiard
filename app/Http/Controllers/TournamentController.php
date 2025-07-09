<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Location;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

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
            'status' => 'required|in:Akan Datang,Sedang Berlangsung,Selesai',
            'location_id' => 'nullable|exists:locations,id',
            'winner_id' => 'nullable|exists:players,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('poster_image')) {
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
                    $request->file('poster_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/tournaments'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['poster_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
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
            'status' => 'required|in:Akan Datang,Sedang Berlangsung,Selesai',
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
                    $request->file('poster_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/tournaments'
                    ]
                );

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($tournament->poster_image) {
                    $this->deleteFromCloudinary($tournament->poster_image);
                }

                $tournament->poster_image = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['poster_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        $tournament->save();

        return redirect()->route('tournaments.index')->with('success', 'Data turnamen berhasil diperbarui.');
    }

    public function destroy(Tournament $tournament)
    {
        try {
            // Hapus gambar dari Cloudinary
            if ($tournament->poster_image) {
                $this->deleteFromCloudinary($tournament->poster_image);
            }

            $tournament->delete();

            return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus turnamen: ' . $e->getMessage()]);
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
            Log::error('Error deleting from Cloudinary: ' . $e->getMessage());
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
