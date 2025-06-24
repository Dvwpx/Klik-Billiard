<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function index()
    {
        // Ambil semua turnamen, urutkan dari tanggal mulai yang paling baru
        $tournaments = Tournament::with(['location', 'winner'])
            ->latest('start_date')
            ->paginate(10);

        return view('public.tournaments.index', compact('tournaments'));
    }

    public function show($slug)
    {
        // Cari turnamen berdasarkan slug
        $tournament = Tournament::where('slug', $slug)
            ->with(['location', 'winner'])
            ->firstOrFail();

        return view('public.tournaments.show', compact('tournament'));
    }
}
