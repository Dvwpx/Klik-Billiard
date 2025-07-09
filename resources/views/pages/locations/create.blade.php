@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Tambah Lokasi Baru</h4>
      <p class="card-description">Masukkan detail lokasi billiard baru untuk Klik Billiard.</p>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form class="forms-sample" method="POST" action="{{ route('locations.store') }}">
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
          <input type="hidden" id="featured_image" name="featured_image" value="{{ old('featured_image') }}">
          <div class="mb-2">
            <button type="button" class="btn btn-primary" id="upload_widget">Upload Gambar</button>
          </div>
          <div id="preview_container" style="display:none;">
            <p>Preview:</p>
            <img id="preview_image" src="" alt="Preview" style="max-width: 200px;">
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
          <label for="map_url">Link Google Maps (Navigasi)</label>
          <input type="url" class="form-control" id="map_url" name="map_url" placeholder="https://maps.app.goo.gl/..." value="{{ old('map_url') }}">
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
        <a href="{{ route('locations.index') }}" class="btn btn-light">Batal</a>
      </form>
    </div>
  </div>
</div>

{{-- Cloudinary Upload Widget --}}
<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        const uploadWidget = cloudinary.createUploadWidget({
            cloudName: '{{ config('cloudinary.cloud_name') }}',
            uploadPreset: '{{ config('cloudinary.upload_preset') }}',
            folder: 'klikbilliard/locations',
            sources: ['local', 'url', 'camera'],
            multiple: false,
            maxFileSize: 10485760 // 10MB
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                const imageUrl = result.info.secure_url;
                document.getElementById('featured_image').value = imageUrl;
                document.getElementById('preview_image').src = imageUrl;
                document.getElementById('preview_container').style.display = 'block';
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

@endsection
