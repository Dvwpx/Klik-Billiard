@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Promo Baru</h4>
            <p class="card-description">
                Masukkan detail untuk banner promo baru.
            </p>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="forms-sample" method="POST" action="{{ route('promos.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title">Judul Promo</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Promo Happy Hour" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Jelaskan penawaran promo secara singkat">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Upload Banner Promo</label><br>
                    <button type="button" id="upload_widget" class="btn btn-primary mb-2">Upload Gambar ke Cloudinary</button>
                    <input type="hidden" name="banner_image_url" id="banner_image_url" value="{{ old('banner_image_url') }}">
                    <div id="preview_image" style="display: none;">
                        <img src="" id="image_preview_tag" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                    </div>
                    <small class="form-text text-muted mt-2">Gambar akan menjadi background seksi promo. Ukuran rekomendasi: 1920x1080 pixel.</small>
                </div>

                <div class="form-group">
                    <label for="link_url">URL Tujuan (Opsional)</label>
                    <input type="url" class="form-control" id="link_url" name="link_url" placeholder="Contoh: https://wa.me/628123..." value="{{ old('link_url') }}">
                    <small class="form-text text-muted">Link tujuan saat tombol promo di-klik. Bisa link WhatsApp, Instagram, dll.</small>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif (Tampilkan di Website)</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif (Simpan sebagai Draft)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('promos.index') }}" class="btn btn-light">Batal</a>
            </form>

        </div>
    </div>
</div>
@endsection

<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const uploadWidget = cloudinary.createUploadWidget({
            cloudName: 'dvlrqchqs',
            uploadPreset: 'default_preset',
            folder: 'klikbilliard/promos',
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 10485760 // 10MB
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                const imageUrl = result.info.secure_url;
                document.getElementById('banner_image_url').value = imageUrl;
                document.getElementById('image_preview_tag').src = imageUrl;
                document.getElementById('preview_image').style.display = 'block';
            }
        });

        const btn = document.getElementById("upload_widget");
        if (btn) {
            btn.addEventListener("click", function() {
                uploadWidget.open();
            });
        } else {
            console.warn("Tombol upload_widget tidak ditemukan");
        }
    });
</script>