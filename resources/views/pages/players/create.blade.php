@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Pemain Baru</h4>
            <p class="card-description">
                Masukkan profil pemain baru untuk ditampilkan di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('players.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama lengkap pemain" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Julukan / Nickname</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Contoh: The Magician" value="{{ old('nickname') }}">
                </div>

                <div class="form-group">
                    <label>Foto Profil</label>
                    <input type="file" name="profile_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Biografi</label>
                    <textarea class="form-control" id="bio" name="bio" rows="6" placeholder="Ceritakan kisah perjalanan, gaya bermain, dll.">{{ old('bio') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="achievements">Prestasi</label>
                    <textarea class="form-control" id="achievements" name="achievements" rows="6" placeholder="Buat daftar prestasi, contoh: - Juara 1 POBSI Cup 2024">{{ old('achievements') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Pensiun</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('players.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection