@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Promo</h4>
            <p class="card-description">
                Ubah detail banner promo.
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

            <form class="forms-sample" method="POST" action="{{ route('promos.update', $promo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Judul Promo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $promo->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $promo->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Upload Banner Promo Baru (Opsional)</label>
                    <input type="file" name="banner_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar Banner Baru">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti banner yang sudah ada.</small>
                    @if($promo->banner_image)
                    <div class="mt-2">
                        <p>Banner saat ini:</p>
                        <img src="{{$promo->banner_image}}" alt="Banner Promo" style="max-width: 300px; border-radius: 5px;">
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="link_url">URL Tujuan (Opsional)</label>
                    <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $promo->link_url) }}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status', $promo->status) == 'active' ? 'selected' : '' }}>Aktif (Tampilkan di Website)</option>
                        <option value="inactive" {{ old('status', $promo->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif (Simpan sebagai Draft)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('promos.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection