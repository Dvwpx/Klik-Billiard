@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Fasilitas</h4>
            <p class="card-description">
                Ubah detail fasilitas atau peralatan di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('facilities.update', $facility->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Fasilitas / Peralatan</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $facility->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $facility->category) }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Gambar Baru (Opsional)">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @if($facility->image)
                    <div class="mt-2">
                        <p>Gambar saat ini:</p><img src="{{ asset('storage/' . $facility->image) }}" alt="Image" style="max-width: 200px;">
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $facility->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('facilities.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection