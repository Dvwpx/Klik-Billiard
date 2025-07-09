@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Pemain</h4>
            <p class="card-description">
                Daftar semua pemain yang terdaftar di sistem Klik Billiard.
            </p>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('players.create') }}" class="btn btn-primary mb-3">Tambah Pemain Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Pemain</th>
                            <th>Julukan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($players as $player)
                        <tr>
                            <td class="py-1">
                                @if($player->profile_image)
                                <img src="{{$player->profile_image }}" alt="image" />
                                @else
                                <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="image" />
                                @endif
                            </td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->nickname }}</td>
                            <td>
                                <span class="badge badge-info">{{ ucfirst($player->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pemain ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data pemain.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection