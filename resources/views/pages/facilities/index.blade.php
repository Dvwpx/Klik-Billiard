@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Fasilitas & Peralatan</h4>
            <p class="card-description">
                Daftar semua fasilitas & peralatan yang terdaftar di sistem Klik Billiard.
            </p>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('facilities.create') }}" class="btn btn-primary mb-3">Tambah Fasilitas Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Fasilitas</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($facilities as $facility)
                        <tr>
                            <td class="py-1">
                                @if($facility->image)
                                <img src="{{$facility->image }}" alt="image" />
                                @else
                                <img src="https://via.placeholder.com/150x150.png?text=No+Image" alt="image" />
                                @endif
                            </td>
                            <td>{{ $facility->name }}</td>
                            <td>{{ $facility->category }}</td>
                            <td>
                                <a href="{{ route('facilities.edit', $facility->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="d-inline">
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
                            <td colspan="4" class="text-center">Belum ada data fasilitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection