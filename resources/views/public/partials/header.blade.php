<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    {{-- Gunakan container-fluid untuk lebar penuh --}}
    <div class="container-fluid px-sm-5">

        {{-- Logo di Kiri --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            KLIK<span>BILLIARD</span>
        </a>

        {{-- Tombol Toggler untuk Mobile --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Navigasi di Kanan --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> {{-- Class ml-auto tetap penting --}}
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="nav-item {{ request()->routeIs('locations.public.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('locations.public.index') }}">Lokasi</a>
                </li>
                <li class="nav-item {{ request()->routeIs('tournaments.public.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tournaments.public.index') }}">Turnamen</a>
                </li>
                <li class="nav-item {{ request()->routeIs('facilities.public.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('facilities.public.index') }}">Fasilitas</a>
                </li>
                <li class="nav-item {{ request()->routeIs('menu.public.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('menu.public.index') }}">Menu F&B</a>
                </li>
                <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('about') }}">Tentang Kami</a>
                </li>
            </ul>
        </div>

    </div>
</nav>