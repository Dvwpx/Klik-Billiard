<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Menampilkan halaman daftar artikel (indeks blog).
     */
    public function index()
    {
        // Ambil semua artikel yang statusnya 'published', urutkan dari terbaru, dan gunakan pagination.
        $articles = Article::where('status', 'published')->latest()->paginate(9);

        // Kirim data artikel ke view
        return view('public.blog.index', ['articles' => $articles]);
    }

    /**
     * Menampilkan halaman detail satu artikel.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->firstOrFail();

        // Ambil 3 artikel lain secara acak sebagai "Artikel Terkait"
        // Pastikan tidak mengambil artikel yang sedang dibaca
        $relatedArticles = Article::where('status', 'published')
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Kirim data artikel dan artikel terkait ke view
        return view('public.blog.show', compact('article'  , 'relatedArticles'));
    }
}
