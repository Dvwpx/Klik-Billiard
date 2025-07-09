@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Menu Makanan & Minuman</h4>
            <p class="card-description">
                Daftar semua menu yang tersedia di Klik Billiard.
            </p>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('menu-items.create') }}" class="btn btn-primary mb-3">Tambah Menu Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menuItems as $item)
                        <tr>
                            <td class="py-1">
                                @if($item->image)
                                <img src="{{ $item->image }}" alt="image" />
                                @else
                                <img src="https://via.placeholder.com/150x150.png?text=No+Image" alt="image" />
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->status == 'Tersedia')
                                <span class="badge badge-success">Tersedia</span>
                                @else
                                <span class="badge badge-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('menu-items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data menu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection