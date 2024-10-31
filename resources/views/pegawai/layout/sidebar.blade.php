    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="javascript:void(0)" class="app-brand-link">
              <img src="{{ asset('/assets/img/logo/smkn1cmi_logo.png') }}" alt="logo" class="app-brand-logo demo me-2" width="40px">
              <span class="app-brand-text">
                <h3 class="demo text-body fw-bolder align-middle my-auto">EduStaff</h3>
                <small class="text-muted">SMK Negeri 1 Cimahi</small>
              </span>
            </a>

            <a href="javascript:void(0)" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1 mt-3">
            <!-- Dashboard -->
            <li class="menu-item {{(request()->routeIs('pegawai.dashboard') ? 'active' : '')}}">
              <a href="{{route('pegawai.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">MENU UTAMA</span>
            </li>

            <li class="menu-item {{(request()->routeIs('pegawai.pengajuan') ? 'active' : '')}}">
              <a href="{{route('pegawai.pengajuan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Pensiun/Keluar</div>
              </a>
            </li>
            <li class="menu-item {{(request()->routeIs('pegawai.perubahan') ? 'active' : '')}}">
              <a href="{{route('pegawai.perubahan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-edit"></i>
                <div data-i18n="Analytics">Perubahan Data Diri</div>
              </a>
            </li>
            <li class="menu-item {{(request()->routeIs('pegawai.prestasi') ? 'active' : '')}}">
              <a href="{{route('pegawai.prestasi')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-medal"></i>
                <div data-i18n="Analytics">Prestasi Pegawai</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">MENU LAINNYA</span>
            </li>
            <li class="menu-item {{(request()->routeIs('pegawai.bantuan') ? 'active' : '')}}">
              <a href="{{route('pegawai.bantuan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div data-i18n="Bantuan">Bantuan</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->
