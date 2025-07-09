<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data artikel, diurutkan dari yang terbaru
        $articles = Article::with('user')->latest()->get();
        return view('pages.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (featured_image sekarang divalidasi sebagai string URL)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:articles,title',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|url', // FIX: Validasi sebagai URL
            'status' => 'required|in:draft,published',
        ]);

        // 2. Langsung gunakan URL dari Cloudinary Widget
        Article::create([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'content' => $validatedData['content'],
            'featured_image' => $validatedData['featured_image'] ?? null, // FIX: Ambil URL langsung
            'status' => $validatedData['status'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Menampilkan detail satu artikel
        return view('pages.articles.show', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('pages.articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:articles,title,' . $article->id,
            'content' => 'required|string',
            'featured_image' => 'nullable|string|url', // FIX: Validasi sebagai URL
            'status' => 'required|in:draft,published',
        ]);

        // 2. Siapkan data untuk diupdate
        $updateData = [
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
        ];

        // 3. Cek jika ada URL gambar baru dari Cloudinary
        $newImageUrl = $request->input('featured_image');
        if ($newImageUrl && $newImageUrl !== $article->featured_image) {
            // Hapus gambar lama dari Cloudinary jika ada
            if ($article->featured_image) {
                $this->deleteFromCloudinary($article->featured_image);
            }
            // Tetapkan URL gambar baru
            $updateData['featured_image'] = $newImageUrl; // FIX: Gunakan URL baru
        }

        // 4. Update data di database
        $article->update($updateData);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            // Hapus gambar dari Cloudinary jika ada
            if ($article->featured_image) {
                $this->deleteFromCloudinary($article->featured_image);
            }
            $article->delete();
            return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Article deletion error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus artikel.');
        }
    }

    // --- Helper Methods untuk Cloudinary ---

    private function deleteFromCloudinary($imageUrl)
    {
        // Fungsi ini sudah benar, tidak perlu diubah
        try {
            $cloudinary = new CloudinaryApi(config('cloudinary.url'));
            $publicId = $this->extractPublicIdFromUrl($imageUrl);

            if ($publicId) {
                $cloudinary->uploadApi()->destroy($publicId);
            }
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
        }
    }

    private function extractPublicIdFromUrl($url)
    {
        // Fungsi ini sudah benar, tidak perlu diubah
        $pattern = '/\/v\d+\/(.+)\.[a-zA-Z0-9]+$/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
}