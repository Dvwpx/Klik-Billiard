@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Edit Artikel</h4>
      <p class="card-description">Ubah detail artikel di bawah ini.</p>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('articles.update', $article->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="title">Judul Artikel</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="form-group">
          <label>Gambar Utama</label><br>
          {{-- Tombol untuk memicu Cloudinary Widget --}}
          <button type="button" id="upload-button" class="btn btn-primary mb-2">Upload Gambar</button>

          {{-- Input tersembunyi untuk menyimpan URL gambar dari Cloudinary --}}
          <input type="hidden" name="featured_image" id="image-url" value="{{ old('featured_image', $article->featured_image) }}">

          {{-- Wadah untuk menampilkan pratinjau gambar --}}
          <div id="image-preview-container" class="mt-2">
            @if(old('featured_image', $article->featured_image))
            <img src="{{ old('featured_image', $article->featured_image) }}" style="max-width: 200px; height: auto;">
            @else
            <p>Tidak ada gambar.</p>
            @endif
          </div>
        </div>

        <div class="form-group">
          <label for="content">Isi Konten</label>
          <textarea class="form-control" id="content" name="content" rows="15">{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" name="status" id="status">
            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('articles.index') }}" class="btn btn-light">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- Script untuk Cloudinary Upload Widget (Sama persis dengan di create.blade.php) --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const uploadButton = document.getElementById('upload-button');
    const imageUrlInput = document.getElementById('image-url');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    const myWidget = cloudinary.createUploadWidget({
      cloudName: '{{ config('
      cloudinary.cloud_name ') }}',
      uploadPreset: '{{ config('
      cloudinary.upload_preset ') }}',
      folder: 'klikbilliard/articles',
      sources: ['local', 'url', 'camera'],
      multiple: false,
      maxFileSize: 10485760 // 10MB
    }, (error, result) => {
      if (!error && result && result.event === "success") {
        console.log('Upload sukses: ', result.info);
        const imageUrl = result.info.secure_url;

        // 1. Set nilai input hidden dengan URL gambar baru
        imageUrlInput.value = imageUrl;

        // 2. Perbarui pratinjau gambar
        imagePreviewContainer.innerHTML = `<img src="${imageUrl}" style="max-width: 200px; height: auto;">`;
      }
    });

    if (uploadButton) {
      uploadButton.addEventListener("click", function(e) {
        e.preventDefault();
        myWidget.open();
      }, false);
    } else {
      console.error("Tombol dengan ID 'upload-button' tidak ditemukan!");
    }
  });
</script>
@endsection