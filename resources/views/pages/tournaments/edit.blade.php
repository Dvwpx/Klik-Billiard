@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Turnamen</h4>
            <p class="card-description">
                Ubah detail turnamen di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('tournaments.update', $tournament->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Turnamen</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $tournament->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Upload Poster Turnamen</label><br>
                    <button type="button" id="upload_widget" class="btn btn-primary mb-2">Upload Gambar ke Cloudinary</button>
                    <input type="hidden" name="poster_image_url" id="poster_image_url" value="{{ old('poster_image_url', $tournament->poster_image) }}">


                    {{-- Poster lama --}}
                    @if($tournament->poster_image)
                    <div class="mt-2">
                        <p>Poster saat ini:</p>
                        <img src="{{ $tournament->poster_image }}" alt="Poster Lama" style="max-width: 200px;">
                    </div>
                    @endif

                    <small class="form-text text-muted mt-2">Gambar baru akan menggantikan yang lama jika diunggah.</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $tournament->start_date) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $tournament->end_date) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location_id">Lokasi Turnamen</label>
                    <select class="form-control" id="location_id" name="location_id">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id', $tournament->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $tournament->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status Turnamen</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Akan Datang" {{ old('status', $tournament->status) == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="Sedang Berlangsung" {{ old('status', $tournament->status) == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="Selesai" {{ old('status', $tournament->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="winner_id">Pemenang</label>
                    <select class="form-control" id="winner_id" name="winner_id">
                        <option value="">-- Pilih Pemenang (Jika sudah selesai) --</option>
                        @foreach ($players as $player)
                        <option value="{{ $player->id }}" {{ old('winner_id', $tournament->winner_id) == $player->id ? 'selected' : '' }}>{{ $player->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
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
        cloudName: 'dvlrqchqs', // Ganti sesuai cloud_name kamu
        uploadPreset: 'default_preset', // Sesuaikan juga jika berbeda
        folder: 'klikbilliard/tournaments',
        sources: ['local', 'url', 'camera'],
        multiple: false,
        maxFileSize: 10485760 // 10 MB
    }, (error, result) => {
        if (!error && result && result.event === "success") {
            const imageUrl = result.info.secure_url;
            document.getElementById('poster_image_url').value = imageUrl;
            document.getElementById('image_preview_tag').src = imageUrl;
        }
    });

    document.getElementById("upload_widget").addEventListener("click", function() {
        uploadWidget.open();
    }, false);
</script>
@endpush