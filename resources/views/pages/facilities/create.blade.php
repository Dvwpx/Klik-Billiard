@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Fasilitas Baru</h4>
            <p class="card-description">
                Masukkan detail fasilitas atau peralatan baru untuk Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('facilities.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Fasilitas / Peralatan</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Meja Brunswick Gold Crown" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" class="form-control" id="category" name="category" placeholder="Contoh: Meja, Stick, Bola, Lain-lain" value="{{ old('category') }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Gambar">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="6" placeholder="Jelaskan detail atau spesifikasi">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('facilities.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection