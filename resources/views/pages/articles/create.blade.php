@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tulis Artikel Baru</h4>
            <p class="card-description">
                Tulis dan publikasikan artikel biliar baru.
            </p>

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="forms-sample" method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Judul Artikel</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Judul Artikel" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar Utama (Featured Image)</label>
                    <input type="file" name="featured_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Isi Konten</label>
                    <textarea class="form-control" id="content" name="content" rows="15" placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('articles.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Kita akan tambahkan script untuk text editor dan upload di sini nanti --}}