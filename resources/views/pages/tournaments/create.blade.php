@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Turnamen Baru</h4>
            <p class="card-description">
                Masukkan detail turnamen baru untuk Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('tournaments.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Turnamen</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Klik Billiard Open 2025" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Upload Poster Turnamen</label><br>
                    <button type="button" id="upload_widget" class="btn btn-primary mb-2">Upload Gambar ke Cloudinary</button>
                    <input type="hidden" name="poster_image_url" id="poster_image_url" value="{{ old('poster_image_url') }}">
                    <small class="form-text text-muted mt-2">Ukuran rekomendasi: 1920x1080 pixel.</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location_id">Lokasi Turnamen</label>
                    <select class="form-control" id="location_id" name="location_id">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="6" placeholder="Jelaskan tentang turnamen, format, hadiah, dll.">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status Turnamen</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Akan Datang" {{ old('status') == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="Sedang Berlangsung" {{ old('status') == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="winner_id">Pemenang</label>
                    <select class="form-control" id="winner_id" name="winner_id">
                        <option value="">-- Pilih Pemenang (Jika sudah selesai) --</option>
                        @foreach ($players as $player)
                        <option value="{{ $player->id }}" {{ old('winner_id') == $player->id ? 'selected' : '' }}>{{ $player->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('tournaments.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
<script type="text/javascript">
    const uploadWidget = cloudinary.createUploadWidget({
        cloudName: 'dvlrqchqs', // Ganti dengan cloud_name kamu
        uploadPreset: 'default_preset', // Ganti juga ini kalau kamu buat preset baru
        folder: 'klikbilliard/tournaments',
        sources: ['local', 'url', 'camera'],
        multiple: false,
        maxFileSize: 10485760 // 10 MB
    }, (error, result) => {
        if (!error && result && result.event === "success") {
            const imageUrl = result.info.secure_url;
            document.getElementById('poster_image_url').value = imageUrl;
            document.getElementById('image_preview_tag').src = imageUrl;
            document.getElementById('preview_image').style.display = 'block';
        }
    });

    document.getElementById("upload_widget").addEventListener("click", function() {
        uploadWidget.open();
    }, false);
</script>
@endpush