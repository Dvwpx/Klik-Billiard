<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 artikel terbaru yang sudah di-publish
        $latestArticles = Article::where('status', 'published')->latest()->take(3)->get();

        return view('public.home', [
            'latestArticles' => $latestArticles,
        ]);
    }

    public function about()
    {
        return view('public.about');
    }
}
