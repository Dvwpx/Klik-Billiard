@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Pemain Baru</h4>
            <p class="card-description">
                Masukkan profil pemain baru untuk ditampilkan di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('players.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama lengkap pemain" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Julukan / Nickname</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Contoh: The Magician" value="{{ old('nickname') }}">
                </div>

                <div class="form-group">
                    <label>Upload Foto Profil</label><br>
                    <button type="button" id="upload_widget" class="btn btn-primary mb-2">Upload Gambar</button>
                    <input type="hidden" name="profile_image" id="profile_image" value="{{ old('profile_image') }}">
                    <div id="preview_image" style="display: none;">
                        <img src="" id="image_preview_tag" style="max-width: 150px; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Biografi</label>
                    <textarea class="form-control" id="bio" name="bio" rows="6" placeholder="Ceritakan kisah perjalanan, gaya bermain, dll.">{{ old('bio') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="achievements">Prestasi</label>
                    <textarea class="form-control" id="achievements" name="achievements" rows="6" placeholder="Buat daftar prestasi, contoh: - Juara 1 POBSI Cup 2024">{{ old('achievements') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Pensiun</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('players.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Cloudinary Upload Widget untuk Players --}}
<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        const uploadWidget = cloudinary.createUploadWidget({
            cloudName: '{{ config('cloudinary.cloud_name') }}',
            uploadPreset: '{{ config('cloudinary.upload_preset') }}', // dari config
            folder: 'klikbilliard/players',
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 5242880 // 5MB
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                const imageUrl = result.info.secure_url;
                document.getElementById('profile_image').value = imageUrl;
                document.getElementById('image_preview_tag').src = imageUrl;
                document.getElementById('preview_image').style.display = 'block';
            }
        });

        const btn = document.getElementById("upload_widget");
        if (btn) {
            btn.addEventListener("click", function () {
                uploadWidget.open();
            });
        } else {
            console.warn("Tombol upload_widget tidak ditemukan");
        }
    });
</script>
