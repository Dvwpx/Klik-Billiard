<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary as CloudinaryApi;

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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:draft,published',
        ]);

        // 2. Proses Upload Gambar (jika ada)
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
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
                    $request->file('featured_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/articles'
                    ]
                );

                $imagePath = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['featured_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
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
                    $request->file('featured_image')->getRealPath(),
                    [
                        'folder' => 'klikbilliard/articles'
                    ]
                );

                // Hapus gambar lama dari Cloudinary (opsional)
                if ($article->featured_image) {
                    $this->deleteFromCloudinary($article->featured_image);
                }

                $updateData['featured_image'] = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                Log::error('Cloudinary upload error: ' . $e->getMessage());
                return back()->withErrors(['featured_image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
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
        try {
            // Hapus gambar dari Cloudinary
            if ($article->featured_image) {
                $this->deleteFromCloudinary($article->featured_image);
            }

            // Hapus data artikel dari database
            $article->delete();

            return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus artikel: ' . $e->getMessage()]);
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
