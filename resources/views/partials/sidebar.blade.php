<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('users.index') }}">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Manajemen User</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('articles.index') }}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Manajemen Artikel</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('locations.index') }}">
        <i class="icon-map menu-icon"></i>
        <span class="menu-title">Manajemen Lokasi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('tournaments.index') }}">
        <i class="mdi mdi-chess-queen menu-icon"></i>
        <span class="menu-title">Manajemen Turnamen</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('players.index') }}">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Manajemen Pemain</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('facilities.index') }}">
        <i class="icon-briefcase menu-icon"></i>
        <span class="menu-title">Manajemen Fasilitas</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('promos.index') }}">
        <i class="ti-announcement menu-icon"></i>
        <span class="menu-title">Manajemen Promo</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('menu-items.index') }}">
        <i class="mdi mdi-silverware-fork-knife menu-icon"></i>
        <span class="menu-title">Menu F&B</span>
      </a>
    </li>
  </ul>
</nav>

<style>
  .sidebar .nav .nav-item .nav-link .menu-title {
    line-height: 2;
  }
</style>