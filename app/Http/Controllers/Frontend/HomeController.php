<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Article;
use App\Models\Location;
use App\Models\Tournament;
use App\Models\Facility;
use App\Models\Promo;

class HomeController extends Controller
{
    public function index()
    {
        // Data Lokasi Tunggal
        $featuredLocation = Location::where('status', 'open')->with('facilities')->latest()->first();

        // Data Fasilitas Umum (Statis)
        $amenities = [
            ['icon' => 'fas fa-parking', 'name' => 'Parkir Luas & Aman'],
            ['icon' => 'fas fa-wifi', 'name' => 'Koneksi WiFi Cepat'],
            ['icon' => 'fas fa-mug-hot', 'name' => 'Cafe & Resto'],
            ['icon' => 'fas fa-smoking', 'name' => 'Smoking Area'],
            ['icon' => 'fas fa-restroom', 'name' => 'Toilet Bersih'],
            ['icon' => 'fas fa-solid fa-ban-smoking', 'name' => 'Area Ramah Anak'],
        ];

        // Ambil data peralatan dari DB
        $showcaseFacilities = Facility::latest()->take(4)->get();

        // AMBIL PROMO AKTIF TERBARU
        $activePromos = Promo::where('status', 'active')->latest()->take(3)->get();

        // Ambil data Makanan (termasuk cemilan)
        $foodItems = MenuItem::whereIn('category', ['Makanan', 'Makanan Berat', 'Cemilan', 'Snack'])
            ->where('status', 'Tersedia')
            ->orderBy('name', 'asc')
            ->get();

        // Ambil data Minuman (termasuk kopi)
        $drinkItems = MenuItem::whereIn('category', ['Minuman', 'Minuman Dingin', 'Kopi'])
            ->where('status', 'Tersedia')
            ->orderBy('name', 'asc')
            ->get();

        // Data lain
        $recentTournaments = Tournament::with(['winner'])->latest('start_date')->take(2)->get();
        $latestArticles = Article::where('status', 'published')->latest()->take(3)->get();

        return view('public.home', compact(
            'featuredLocation',
            'amenities',
            'showcaseFacilities',
            'foodItems',
            'drinkItems',
            'recentTournaments',
            'latestArticles',
            'activePromos'
        ));
    }

    public function about()
    {
        return view('public.about');
    }
}
