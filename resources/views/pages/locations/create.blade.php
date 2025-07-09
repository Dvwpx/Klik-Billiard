@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Lokasi Baru</h4>
            <p class="card-description">
                Masukkan detail lokasi billiard baru untuk Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('locations.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lokasi</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: The Breeze Pool & Lounge" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="address">Alamat Lengkap</label>
                    <textarea class="form-control" id="address" name="address" rows="4" placeholder="Jl. Pahlawan No. 123, Jakarta Selatan">{{ old('address') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="city">Kota</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Contoh: Jakarta Selatan" value="{{ old('city') }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar Utama</label>
                    <input type="file" name="featured_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Gambar">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="8" placeholder="Jelaskan tentang fasilitas, jumlah meja, suasana, dll.">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Contoh: -6.261490" value="{{ old('latitude') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Contoh: 106.782130" value="{{ old('longitude') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Contoh: 08123456789" value="{{ old('phone_number') }}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="map_url">Link Google Maps (Navigasi)</label>
                    <input type="url" class="form-control" id="map_url" name="map_url" placeholder="https://maps.app.goo.gl/..." value="{{ old('map_url') }}">
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('locations.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection