@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Turnamen</h4>
            <p class="card-description">
                Daftar semua turnamen di Klik Billiard.
            </p>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('tournaments.create') }}" class="btn btn-primary mb-3">Tambah Turnamen Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Nama Turnamen</th>
                            <th>Lokasi</th>
                            <th>Tanggal Mulai</th>
                            <th>Pemenang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tournaments as $tournament)
                        <tr>
                            <td class="py-1">
                                @if($tournament->poster_image)
                                <img src="{{$tournament->poster_image }}" alt="image" />
                                @else
                                <img src="https://via.placeholder.com/150x150.png?text=No+Poster" alt="image" />
                                @endif
                            </td>
                            <td>{{ $tournament->name }}</td>
                            <td>{{ $tournament->location->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}</td>
                            <td>{{ $tournament->winner->name ?? 'Belum Ada' }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $tournament->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus turnamen ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data turnamen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection