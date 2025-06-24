@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Menu Baru</h4>
            <p class="card-description">
                Masukkan detail item menu baru untuk Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('menu-items.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Menu</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Nasi Goreng Gila" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <input type="text" class="form-control" id="category" name="category" placeholder="Contoh: Makanan Berat, Cemilan, Kopi" value="{{ old('category') }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rupiah)</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Contoh: 25000" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar Menu</label>
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
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Jelaskan detail atau komposisi menu">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Habis" {{ old('status') == 'Habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('menu-items.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection