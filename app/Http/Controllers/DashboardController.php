<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Location;
use App\Models\Tournament;
use App\Models\MenuItem;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data dari setiap model
        $articleCount = Article::count();
        $locationCount = Location::count();
        $tournamentCount = Tournament::count();
        $menuItemCount = MenuItem::count();

        // Mengambil 5 artikel terbaru untuk ditampilkan di tabel aktivitas
        $recentArticles = Article::latest()->take(5)->get();

        // Mengirim semua data ke view
        return view('dashboard.index', compact(
            'articleCount',
            'locationCount',
            'tournamentCount',
            'menuItemCount',
            'recentArticles'
        ));
    }
}
