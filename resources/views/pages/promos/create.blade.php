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

            <form class="forms-sample" method="POST" action="{{ route('promos.store') }}" enctype="multipart/form-data">
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
                    <label>Upload Banner Promo</label>
                    <input type="file" name="banner_image" class="file-upload-default" required>
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar Banner">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <small class="form-text text-muted">Gambar akan menjadi background seksi promo. Ukuran rekomendasi: 1920x1080 pixel.</small>
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