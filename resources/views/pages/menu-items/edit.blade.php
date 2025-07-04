@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Menu</h4>
            <p class="card-description">
                Ubah detail item menu di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('menu-items.update', $menuItem->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Menu</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menuItem->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan" {{ old('category', $menu->category ?? '') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ old('category', $menu->category ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rupiah)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $menuItem->price) }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar Menu</label>
                    <input type="file" name="image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Gambar Baru (Opsional)">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @if($menuItem->image)
                    <div class="mt-2">
                        <p>Gambar saat ini:</p><img src="{{ asset('storage/' . $menuItem->image) }}" alt="Image" style="max-width: 200px;">
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $menuItem->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Tersedia" {{ old('status', $menuItem->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Habis" {{ old('status', $menuItem->status) == 'Habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('menu-items.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection