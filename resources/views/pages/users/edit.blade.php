@extends('layouts.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Pengguna</h4>
            <p class="card-description">
                Ubah detail pengguna di bawah ini.
            </p>
            <form class="forms-sample" method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection