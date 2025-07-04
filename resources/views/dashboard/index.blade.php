@extends('layouts.main')

@section('content')
<div class="content-wrapper">
  {{-- Baris Judul & Sambutan --}}
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="row">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
          <h6 class="font-weight-normal mb-0">Admin Dashboard Website Klik Billiard.</h6>
        </div>
      </div>
    </div>
  </div>

  {{-- Baris Kartu Statistik --}}
  <div class="row">
    <div class="col-md-12 grid-margin transparent">
      <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <p class="mb-4">Total Artikel</p>
              <p class="fs-30 mb-2">{{ $articleCount }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <p class="mb-4">Total Lokasi</p>
              <p class="fs-30 mb-2">{{ $locationCount }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-light-blue">
            <div class="card-body">
              <p class="mb-4">Total Turnamen</p>
              <p class="fs-30 mb-2">{{ $tournamentCount }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <p class="mb-4">Total Item Menu</p>
              <p class="fs-30 mb-2">{{ $menuItemCount }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Baris Shortcut & Aktivitas Terbaru --}}
  <div class="row">
    {{-- Kolom Shortcut Cepat --}}
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Aksi Cepat</h4>
          <p class="card-description">
            Pintasan untuk menambah konten baru.
          </p>
          <div class="d-grid gap-2">
            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-lg btn-block mb-2">Tulis Artikel Baru</a>
            <a href="{{ route('tournaments.create') }}" class="btn btn-info btn-lg btn-block mb-2">Tambah Turnamen</a>
            <a href="{{ route('menu-items.create') }}" class="btn btn-success btn-lg btn-block">Tambah Menu F&B</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Aktivitas Terbaru --}}
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Artikel Terbaru</h4>
          <p class="card-description">
            Berikut adalah 5 artikel yang baru saja Anda publikasikan.
          </p>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Judul Artikel</th>
                  <th>Status</th>
                  <th>Tanggal Publikasi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($recentArticles as $article)
                <tr>
                  <td>{{ Str::limit($article->title, 35) }}</td>
                  <td>
                    @if ($article->status == 'published')
                    <div class="badge badge-success">Published</div>
                    @else
                    <div class="badge badge-warning">Draft</div>
                    @endif
                  </td>
                  <td>{{ $article->created_at->format('d M, Y') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center">Belum ada artikel.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection