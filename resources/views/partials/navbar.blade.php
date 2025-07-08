<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="/dashboard">
      <img src="http://127.0.0.1:8000/assets/images/logoklik.png" style="height: 60px;" alt="logo">
    </a>
    <a class="navbar-brand brand-logo-mini" href="/dashboard">
      <img src="{{ asset('assets/images/logoklik.png') }}" alt="logo-mini" />
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>

    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group">
          <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
            <span class="input-group-text" id="search"><i class="icon-search"></i></span>
          </div>
          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
        </div>
      </li>
    </ul>

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown d-flex align-items-center">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="notificationDropdown">
          <i class="icon-bell mx-0"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success"><i class="ti-info-alt mx-0"></i></div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Application Error</h6>
              <p class="font-weight-light small-text mb-0 text-muted">Just now</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning"><i class="ti-settings mx-0"></i></div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Settings</h6>
              <p class="font-weight-light small-text mb-0 text-muted">Private message</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info"><i class="ti-user mx-0"></i></div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">New user registration</h6>
              <p class="font-weight-light small-text mb-0 text-muted">2 days ago</p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item nav-profile d-flex align-items-center">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{ asset('assets/images/profilklik.png') }}" alt="profile" />
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="{{ route('users.index') }}"><i class="ti-settings text-primary"></i> Settings</a>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off text-primary"></i> Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
      </li>
      <button id="sidebarToggle" class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button">
        <span class="icon-menu"></span>
      </button>
    </ul>

    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
  </div>
</nav>

<style>
  /* Style untuk ukuran logo */
  .navbar .navbar-brand-wrapper .brand-logo-mini img {
    width: calc(100px - 30px);
    max-width: 100%;
    margin: auto;
  }

  .navbar .navbar-brand-wrapper .navbar-brand img {
    max-width: 100%;
    height: 49px;
    margin: auto;
    vertical-align: middle;
  }

  /* Perbaikan untuk tampilan mobile */
  @media (max-width: 991.98px) {
    .navbar-menu-wrapper .navbar-nav-right {
      /* Mengatur item menu agar lebih rapi saat di mobile */
      width: 100%;
      flex-direction: row;
      justify-content: flex-end;
      /* Posisikan ikon notif & profil di kanan */
    }

    .navbar .navbar-menu-wrapper {
      padding: 0 15px;
      /* Memberi padding yang konsisten */
    }

    .collapse.show {
      /* Memberi sedikit ruang di atas menu yang terbuka */
      margin-top: 10px;
    }

    /* Memastikan ikon di dropdown profil & notif tetap terlihat */
    .navbar-nav-right .dropdown-toggle::after {
      display: none;
    }
  }

  .navbar-nav-right .nav-profile .dropdown-menu {
    position: absolute;
    left: auto !important;
    right: 0 !important;
    top: 50px;
    /* Anda bisa sesuaikan jarak vertikal ini */
  }
</style>