<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @yield('content')
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
      <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
          <span>&copy; {{ date('Y') }} <a href="{{ url('/') }}" target="_blank" class="footer-link fw-bolder">EduStaff</a>. All rights reserved.</span>
        </div>
        <div>
          <a href="#" class="footer-link me-4" target="_blank">License</a>
          <a href="#" target="_blank" class="footer-link me-4">Contact</a>
          <a href="#" target="_blank" class="footer-link me-4">Support</a>
          <a href="#" target="_blank" class="footer-link me-4">Terms</a>
        </div>
      </div>
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->