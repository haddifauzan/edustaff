    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{route('operator.dashboard')}}" class="app-brand-link">
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
            <li class="menu-item {{(request()->routeIs('operator.dashboard') ? 'active' : '')}}">
              <a href="{{route('operator.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">KELOLA DATA PEGAWAI</span>
            </li>

            <!-- Kelola Pegawai -->
            <li class="menu-item {{ (request()->routeIs(['operator.pegawai*']) ? 'active' : '') }}">
              <a href="{{route('operator.pegawai')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Data Pegawai</div>
              </a>
            </li>
            <li class="menu-item {{ (request()->routeIs(['operator.jabatan.pegawai*', 'operator.tugas.pegawai*', 'operator.guru_mapel.pegawai*', 'operator.walikelas.pegawai*', 'operator.kepala_jurusan.pegawai*']) ? 'active open' : '') }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Data Pengguna">Kelola Pegawai</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{ (request()->routeIs('operator.jabatan.pegawai') ? 'active open' : '')}}">
                  <a href="{{route('operator.jabatan.pegawai')}}" class="menu-link">
                    <div data-i18n="Data Pegawai">Jabatan Pegawai</div>
                  </a>
                </li>
                <li class="menu-item {{ (request()->routeIs('operator.tugas.pegawai') ? 'active open' : '')}}">
                  <a href="{{route('operator.tugas.pegawai')}}" class="menu-link">
                    <div data-i18n="Tugas Tambahan">Tugas Tambahan</div>
                  </a>
                </li>
                <li class="menu-item {{ (request()->routeIs('operator.guru_mapel.pegawai') ? 'active open' : '')}}">
                  <a href="{{route('operator.guru_mapel.pegawai')}}" class="menu-link">
                    <div data-i18n="Guru Mata Pelajaran">Guru Mata Pelajaran</div>
                  </a>
                </li>
                <li class="menu-item {{ (request()->routeIs('operator.walikelas.pegawai') ? 'active open' : '')}}">
                  <a href="{{route('operator.walikelas.pegawai')}}" class="menu-link">
                    <div data-i18n="Wali Kelas">Wali Kelas</div>
                  </a>
                </li>
                <li class="menu-item {{ (request()->routeIs('operator.kepala_jurusan.pegawai') ? 'active open' : '')}}">
                  <a href="{{route('operator.kepala_jurusan.pegawai')}}" class="menu-link">
                    <div data-i18n="Kepala Jurusan">Kepala Jurusan</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">KELOLA DATA KONFIRMASI</span>
            </li>
            <!-- Kelola Data Master -->
            <li class="menu-item {{(request()->routeIs('operator.perubahan*', 'operator.prestasi*', 'operator.pengajuan*') ? 'active open' : '')}}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-plus"></i>
                <div data-i18n="Data Tambahan">Data Konfirmasi</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{(request()->routeIs('operator.perubahan') ? 'active open' : '')}}">
                  <a href="{{route('operator.perubahan')}}" class="menu-link">
                    <div data-i18n="Data Jabatan">Perubahan Data Pegawai</div>
                  </a>
                </li>
                <li class="menu-item {{(request()->routeIs('operator.prestasi') ? 'active open' : '')}}">
                  <a href="{{route('operator.prestasi')}}" class="menu-link">
                    <div data-i18n="Data Prestasi">Prestasi Pegawai</div>
                  </a>
                </li>
                <li class="menu-item {{(request()->routeIs('operator.pengajuan') ? 'active open' : '')}}">
                  <a href="{{route('operator.pengajuan')}}" class="menu-link">
                    <div data-i18n="Data Pengajuan">Pengajuan Pensiun/Keluar</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">MENU LAINNYA</span>
            </li>
            <li class="menu-item {{(request()->routeIs('operator.bantuan') ? 'active' : '')}}">
              <a href="{{route('operator.bantuan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div data-i18n="Bantuan">Bantuan</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('operator/deleted*') ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-trash"></i>
                <div data-i18n="Sampah">Sampah</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ request()->is('operator/deleted/pegawai*') ? 'active open' : '' }}">
                  <a href="{{ route('operator.deleted', ['modelType' => 'pegawai']) }}" class="menu-link">
                    <div data-i18n="Sampah Pegawai">Data Pegawai</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->is('operator/deleted/prestasi*') ? 'active open' : '' }}">
                  <a href="{{ route('operator.deleted', ['modelType' => 'prestasi']) }}" class="menu-link">
                    <div data-i18n="Sampah Prestasi">Prestasi Pegawai</div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->