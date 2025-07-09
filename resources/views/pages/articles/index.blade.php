@extends('layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Artikel</h4>
            <p class="card-description">
                Daftar semua artikel yang ada di sistem
            </p>

            <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Tulis Artikel Baru</a>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th>Tanggal Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                @if ($article->status == 'published')
                                <span class="badge badge-success">Published</span>
                                @else
                                <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                {{-- Form untuk Tombol Hapus --}}
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada artikel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection