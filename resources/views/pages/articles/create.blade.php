@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Tulis Artikel Baru</h4>
      <p class="card-description">Tulis dan publikasikan artikel biliar baru.</p>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('articles.store') }}">
        @csrf
        <div class="form-group">
          <label for="title">Judul Artikel</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul artikel...">
        </div>

        <div class="form-group">
          <label>Gambar Utama</label><br>
          {{-- Tombol untuk memicu Cloudinary Widget --}}
          <button type="button" id="upload-button" class="btn btn-primary mb-2">Upload Gambar</button>
          
          {{-- Input tersembunyi untuk menyimpan URL gambar dari Cloudinary --}}
          <input type="hidden" name="featured_image" id="image-url" value="{{ old('featured_image') }}">
          
          {{-- Wadah untuk menampilkan pratinjau gambar --}}
          <div id="image-preview-container" class="mt-2">
            @if(old('featured_image'))
              <img src="{{ old('featured_image') }}" style="max-width: 200px; height: auto;">
            @endif
          </div>
        </div>

        <div class="form-group">
          <label for="content">Isi Konten</label>
          <textarea class="form-control" id="content" name="content" rows="15" placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" name="status" id="status">
            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('articles.index') }}" class="btn btn-light">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
{{-- Script untuk Cloudinary Upload Widget --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const uploadButton = document.getElementById('upload-button');
        const imageUrlInput = document.getElementById('image-url');
        const imagePreviewContainer = document.getElementById('image-preview-container');

        const myWidget = cloudinary.createUploadWidget({
            cloudName: '{{ config('cloudinary.cloud_name') }}',
            uploadPreset: '{{ config('cloudinary.upload_preset') }}',
            folder: 'klikbilliard/articles', // Folder di Cloudinary
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 10485760 // 10MB
        }, (error, result) => { 
            if (!error && result && result.event === "success") {
                console.log('Upload sukses: ', result.info);
                const imageUrl = result.info.secure_url;
                
                // 1. Set nilai input hidden dengan URL gambar
                imageUrlInput.value = imageUrl;
                
                // 2. Tampilkan pratinjau gambar
                imagePreviewContainer.innerHTML = `<img src="${imageUrl}" style="max-width: 200px; height: auto;">`;
            }
        });

        // Tambahkan event listener ke tombol
        if (uploadButton) {
            uploadButton.addEventListener("click", function (e) {
                e.preventDefault(); // Mencegah form tersubmit jika tombol ada di dalam form
                myWidget.open();
            }, false);
        } else {
            console.error("Tombol dengan ID 'upload-button' tidak ditemukan!");
        }
    });
</script>