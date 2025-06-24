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
                    <label>Poster Turnamen</label>
                    <input type="file" name="poster_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Poster">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
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