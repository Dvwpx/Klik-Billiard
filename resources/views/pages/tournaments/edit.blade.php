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

            <form class="forms-sample" method="POST" action="{{ route('tournaments.update', $tournament->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Turnamen</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $tournament->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Poster Turnamen</label>
                    <input type="file" name="poster_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Poster Baru (Opsional)">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @if($tournament->poster_image)
                    <div class="mt-2">
                        <p>Poster saat ini:</p><img src="{{ asset('storage/' . $tournament->poster_image) }}" alt="Poster" style="max-width: 200px;">
                    </div>
                    @endif
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