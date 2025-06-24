@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Lokasi Billiard</h4>
            <p class="card-description">
                Daftar semua lokasi billiard yang terdaftar di sistem Klik Billiard.
            </p>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Tambah Lokasi Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($locations as $location)
                        <tr>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->city }}</td>
                            <td>
                                @if ($location->status == 'open')
                                <span class="badge badge-success">Open</span>
                                @else
                                <span class="badge badge-danger">Closed</span>
                                @endif
                            </td>
                            <td>{{ $location->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data lokasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection