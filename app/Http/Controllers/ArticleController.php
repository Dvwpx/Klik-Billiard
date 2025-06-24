<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        // 1. Validasi Input Form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Boleh kosong, harus gambar, max 2MB
            'status' => 'required|in:draft,published',
        ]);

        // 2. Proses Upload Gambar (jika ada)
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            // Buat nama file yang unik
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Pindahkan file ke public/storage/articles
            $image->move(public_path('storage/articles'), $imageName);
            $imagePath = 'articles/' . $imageName;
        }

        // 3. Membuat Slug dan Simpan ke Database
        Article::create([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']), // Membuat slug dari judul
            'content' => $validatedData['content'],
            'featured_image' => $imagePath,
            'status' => $validatedData['status'],
            'user_id' => Auth::id(), // Mengambil ID user yang sedang login
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('articles.index')->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        // 1. Validasi Input Form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // 2. Siapkan data untuk diupdate
        $updateData = [
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
        ];

        // 3. Proses Upload Gambar Baru (jika ada)
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($article->featured_image) {
                Storage::delete('public/' . $article->featured_image);
            }

            // Upload gambar baru
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/articles'), $imageName);
            $updateData['featured_image'] = 'articles/' . $imageName;
        }

        // 4. Update data di database
        $article->update($updateData);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Hapus gambar dari storage jika ada
        if ($article->featured_image) {
            Storage::delete('public/' . $article->featured_image);
        }

        // Hapus data artikel dari database
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
