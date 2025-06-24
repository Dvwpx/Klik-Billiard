@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Artikel</h4>
            <p class="card-description">
                Ubah detail artikel di bawah ini.
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

            <form class="forms-sample" method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Judul Artikel</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Judul Artikel" value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="form-group">
                    <label>Gambar Utama (Featured Image)</label>
                    <input type="file" name="featured_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image Baru (Opsional)">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @if($article->featured_image)
                    <div class="mt-2">
                        <p>Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" style="max-width: 200px;">
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="content">Isi Konten</label>
                    <textarea class="form-control" id="content" name="content" rows="15" placeholder="Tulis isi artikel di sini...">{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('articles.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection