    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{route('admin.dashboard')}}" class="app-brand-link">
              <img src="{{ asset('/assets/img/logo/smkn1cmi_logo.png') }}" alt="logo" class="app-brand-logo demo me-2" width="40px">
              <span class="app-brand-text">
                <h3 class="demo text-body fw-bolder align-middle my-auto">EduStaff</h3>
                <small class="text-muted">SMK Negeri 1 Cimahi</small>
              </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1 mt-3">
            <!-- Dashboard -->
            <li class="menu-item {{ (request()->routeIs('admin.dashboard') ? 'active' : '') }}">
              <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">KELOLA PENGGUNA</span>
            </li>

            <!-- Kelola Pengguna -->
            <li class="menu-item {{ request()->routeIs(['admin.operator*', 'admin.user*', 'admin.pegawai*']) ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Data Pengguna">Data Pengguna</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs(['admin.operator*', 'admin.operator.create', 'admin.operator.edit']) ? 'active open' : '' }}">
                  <a href="{{route('admin.operator')}}" class="menu-link">
                    <div data-i18n="Data Operator">Data Operator</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.pegawai*') ? 'active open' : '' }}">
                  <a href="{{route('admin.pegawai')}}" class="menu-link">
                    <div data-i18n="Data Pegawai">Data Pegawai</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.user') ? 'active open' : '' }}">
                  <a href="{{route('admin.user')}}" class="menu-link">
                    <div data-i18n="Data User">Data User</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">KELOLA DATA MASTER</span>
            </li>
            <!-- Kelola Data Master -->
            <li class="menu-item {{ request()->routeIs(['admin.jabatan', 'admin.jurusan', 'admin.mapel', 'admin.kelas']) ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Data Master">Data Master</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.jabatan') ? 'active open' : '' }}">
                  <a href="{{route('admin.jabatan')}}" class="menu-link">
                    <div data-i18n="Data Jabatan">Data Jabatan</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.mapel') ? 'active open' : '' }}">
                  <a href="{{route('admin.mapel')}}" class="menu-link">
                    <div data-i18n="Data Mata Pelajaran">Data Mata Pelajaran</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.jurusan') ? 'active open' : '' }}">
                  <a href="{{route('admin.jurusan')}}" class="menu-link">
                    <div data-i18n="Data Kelas">Data Jurusan</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.kelas') ? 'active open' : '' }}">
                  <a href="{{route('admin.kelas')}}" class="menu-link">
                    <div data-i18n="Data Kelas">Data Kelas</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">KELOLA LAPORAN</span>
            </li>
            <li class="menu-item {{ request()->routeIs('laporan.*') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Data Laporan">Data Laporan</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('laporan.pegawai') ? 'active open' : '' }}">
                  <a href="{{route('laporan.pegawai')}}" class="menu-link">
                    <div data-i18n="Laporan Pegawai">Laporan Pegawai</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link">
                    <div data-i18n="Laporan Riwayat Jabatan">Laporan Riwayat Jabatan</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link">
                    <div data-i18n="Laporan Tugas Tambahan">Laporan Tugas Tambahan</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link">
                    <div data-i18n="Laporan Pensiun/Keluar ">Laporan Pensiun/Keluar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link">
                    <div data-i18n="Laporan Prestasi Pegawai">Laporan Prestasi Pegawai</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">MENU LAINNYA</span>
            </li>
            <li class="menu-item {{ request()->is('admin/deleted*') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-trash"></i>
                <div data-i18n="Sampah">Sampah</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/deleted/kelas*') ? 'active open' : '' }}">
                  <a href="{{ route('admin.deleted', ['modelType' => 'kelas']) }}" class="menu-link">
                    <div data-i18n="Sampah Kelas">Kelas</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->is('admin/deleted/mapel*') ? 'active open' : '' }}">
                  <a href="{{ route('admin.deleted', ['modelType' => 'mapel']) }}" class="menu-link">
                    <div data-i18n="Sampah Mapel">Mapel</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->is('admin/deleted/jurusan*') ? 'active open' : '' }}">
                  <a href="{{ route('admin.deleted', ['modelType' => 'jurusan']) }}" class="menu-link">
                    <div data-i18n="Sampah Jurusan">Jurusan</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->is('admin/deleted/jabatan*') ? 'active open' : '' }}">
                  <a href="{{ route('admin.deleted', ['modelType' => 'jabatan']) }}" class="menu-link">
                    <div data-i18n="Sampah Jabatan">Jabatan</div>
                  </a>
                </li>
              </ul>
            </li>   
            <li class="menu-item ">
              <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Pengaturan Aplikasi">Pengaturan Aplikasi</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div data-i18n="Bantuan">Bantuan</div>
              </a>
            </li>         
          </ul>
        </aside>
        <!-- / Menu -->