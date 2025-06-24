@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Profil Pemain</h4>
            <p class="card-description">
                Ubah profil pemain di Klik Billiard.
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

            <form class="forms-sample" method="POST" action="{{ route('players.update', $player->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $player->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Julukan / Nickname</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname', $player->nickname) }}">
                </div>

                <div class="form-group">
                    <label>Foto Profil</label>
                    <input type="file" name="profile_image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto Baru (Opsional)">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @if($player->profile_image)
                    <div class="mt-2">
                        <p>Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $player->profile_image) }}" alt="Profile Image" style="max-width: 150px; border-radius: 10px;">
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="bio">Biografi</label>
                    <textarea class="form-control" id="bio" name="bio" rows="6">{{ old('bio', $player->bio) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="achievements">Prestasi</label>
                    <textarea class="form-control" id="achievements" name="achievements" rows="6">{{ old('achievements', $player->achievements) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status', $player->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $player->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="retired" {{ old('status', $player->status) == 'retired' ? 'selected' : '' }}>Pensiun</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('players.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection