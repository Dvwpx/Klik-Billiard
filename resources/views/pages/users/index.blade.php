@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <h4 class="card-title">Tabel Pengguna</h4>
            <p class="card-description">
                Daftar semua pengguna yang terdaftar di sistem
            </p>

            <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    {{-- ... sisa kode tabel tidak berubah ... --}}
                    <thead>
                        <tr>
                            <th>
                                Nama
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Tanggal Dibuat
                            </th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                {{-- Form untuk Tombol Hapus --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection