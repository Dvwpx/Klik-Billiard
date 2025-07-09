@extends('layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Promo</h4>
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <a href="{{ route('promos.create') }}" class="btn btn-primary mb-3">Tambah Promo Baru</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Banner</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($promos as $promo)
                        <tr>
                            <td class="py-1"><img src="{{$promo->banner_image }}" alt="image" /></td>
                            <td>{{ $promo->title }}</td>
                            <td><span class="badge {{ $promo->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($promo->status) }}</span></td>
                            <td>
                                <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data promo.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection