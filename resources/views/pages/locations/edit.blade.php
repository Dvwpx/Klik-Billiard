@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Edit Lokasi</h4>
      <p class="card-description">Ubah detail lokasi billiard untuk Klik Billiard.</p>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form class="forms-sample" method="POST" action="{{ route('locations.update', $location->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="name">Nama Lokasi</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $location->name) }}" required>
        </div>

        <div class="form-group">
          <label for="address">Alamat Lengkap</label>
          <textarea class="form-control" id="address" name="address" rows="4">{{ old('address', $location->address) }}</textarea>
        </div>

        <div class="form-group">
          <label for="city">Kota</label>
          <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $location->city) }}" required>
        </div>

        <div class="form-group">
          <label>Gambar Utama</label>
          <input type="hidden" id="featured_image" name="featured_image" value="{{ old('featured_image', $location->featured_image) }}">
          <div class="mb-2">
            <button type="button" class="btn btn-primary" id="upload_widget">Upload Gambar Baru</button>
          </div>
          <div id="preview_container" style="{{ $location->featured_image ? '' : 'display:none;' }}">
            <p>Preview:</p>
            <img id="preview_image" src="{{ old('featured_image', $location->featured_image) }}" alt="Preview" style="max-width: 200px;">
          </div>
        </div>

        <div class="form-group">
          <label for="description">Deskripsi</label>
          <textarea class="form-control" id="description" name="description" rows="8">{{ old('description', $location->description) }}</textarea>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="latitude">Latitude</label>
              <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="longitude">Longitude</label>
              <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="phone_number">Nomor Telepon</label>
          <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $location->phone_number) }}">
        </div>

        <div class="form-group">
          <label for="map_url">Link Google Maps (Navigasi Lokasi)</label>
          <input type="url" class="form-control" id="map_url" name="map_url" value="{{ old('map_url', $location->map_url) }}">
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value="open" {{ old('status', $location->status) == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ old('status', $location->status) == 'closed' ? 'selected' : '' }}>Closed</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary mr-2">Update</button>
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
