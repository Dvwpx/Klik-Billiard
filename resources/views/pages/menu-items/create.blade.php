@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Menu Baru</h4>
            <p class="card-description">Masukkan detail item menu baru untuk Klik Billiard.</p>

            {{-- Menampilkan Pesan Error Validasi --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="forms-sample" method="POST" action="{{ route('menu-items.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Menu</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Nasi Goreng Gila" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ old('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rupiah)</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Contoh: 25000" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label for="image">Gambar Menu</label><br>
                    {{-- ID tombol disamakan dengan yang ada di JavaScript --}}
                    <button type="button" class="btn btn-primary mb-2" id="upload-widget">Upload Gambar via Cloudinary</button>
                    <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                    
                    {{-- Menambahkan elemen untuk pratinjau gambar --}}
                    <div id="image-preview" class="mt-2">
                        @if(old('image'))
                            <img src="{{ old('image') }}" alt="Image Preview" style="max-width: 200px; height: auto; display: block;">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Jelaskan detail atau komposisi menu">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Habis" {{ old('status') == 'Habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('menu-items.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

{{-- Cloudinary Upload Widget untuk Menu Items --}}
<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const uploadWidget = cloudinary.createUploadWidget({
            cloudName: '{{ config('cloudinary.cloud_name') }}',
            uploadPreset: '{{ config('cloudinary.upload_preset') }}',
            folder: 'klikbilliard/menu-items',
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 10485760 // 10MB
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                const imageUrl = result.info.secure_url;
                // Mengisi input hidden dengan URL gambar
                document.getElementById('image').value = imageUrl;

                // Menampilkan pratinjau gambar
                const imagePreviewContainer = document.getElementById('image-preview');
                imagePreviewContainer.innerHTML = `<img src="${imageUrl}" alt="Image Preview" style="max-width: 200px; height: auto; display: block;">`;
            }
        });

        // ID disamakan dengan yang ada di HTML
        const btn = document.getElementById("upload-widget");
        if (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault(); // Mencegah perilaku default jika ada
                uploadWidget.open();
            });
        } else {
            console.error("Tombol dengan ID 'upload-widget' tidak ditemukan.");
        }
    });
</script>
@endsection