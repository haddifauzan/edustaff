<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav
      class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
      id="layout-navbar"
    >
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input
              type="text"
              class="form-control border-0 shadow-none"
              placeholder="Search..."
              aria-label="Search..."
            />
          </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Place this tag where you want the button to render. -->
          <li class="nav-item lh-1 me-3 position-relative">
            <!-- Notification Bell with Badge -->
            <a class="nav-link py-0 position-relative" href="javascript:void(0)" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bx bx-bell bx-sm"></i>
              <span class="badge bg-danger rounded-pill badge-notifications badge-xxs position-absolute top-0 start-100 translate-middle">{{ $notifications->count() }}</span>
            </a>
            
            <!-- Dropdown Menu for Notifications -->
              <ul class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="notificationDropdown" style="min-width: 330px; max-width: 100%; position: absolute; right: 0; left: auto;">
                <!-- Header -->
                <div class="dropdown-header d-flex align-items-center justify-content-between">
                    <h6 class="dropdown-header-title text-truncate me-2">Notifications</h6>
                    <a href="javascript:void(0)" class="btn btn-link fw-bold p-0 m-0" id="confirmMarkAllBtn">Mark all as read</a>
                </div>
                
                <!-- Scrollable Content -->
                <div class="dropdown-scroll" style="max-height: 300px;">
                    @forelse($notifications as $notification)
                    <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center py-2" data-bs-toggle="modal" data-bs-target="#detailNotifikasi_{{ $notification->id_notifikasi }}">
                        <div class="avatar me-3">
                            @if (isset($notification->id_sender))
                                <img src="{{ asset('foto_profil/' . \App\Models\User::find($notification->id_sender)->foto_profil) }}" alt="Avatar" class="w-px-40 h-auto rounded-circle" />
                            @else
                                <img src="{{ asset('images/foto_profil/default.png') }}" alt="Avatar" class="w-px-40 h-auto rounded-circle" />
                            @endif
                        </div>
                        <div class="notification-content">
                            <h6 class="notification-title mb-1">{{ Str::limit($notification->judul, 20) }}</h6>
                            <p class="notification-message mb-0">{{ Str::limit($notification->pesan, 30) }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                    @empty
                    <p class="text-center text-muted">No unread notifications</p>
                    @endforelse
                </div>

                <!-- Footer -->
                <div class="dropdown-footer d-flex align-items-center justify-content-center">
                    <a href="{{ route('notifikasi.admin', auth()->user()->id_user) }}" class="fw-bold my-2">View all notifications</a>
                </div>
            </ul>
          </li>          
          

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{asset('foto_profil/'. auth()->user()->foto_profil)}}" alt class="w-px-40 h-auto rounded-circle" />
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="#">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{asset('foto_profil/'. auth()->user()->foto_profil)}}" alt class="w-px-40 h-auto rounded-circle" />
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">{{ auth()->user()->nama_user }}</span>
                      <small class="text-muted">{{ auth()->user()->role }}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasProfile">
                  <i class="bx bx-user me-2"></i>
                  <span class="align-middle">Profil Saya</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="bx bx-cog me-2"></i>
                  <span class="align-middle">Pengaturan</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal" href="#">
                  <i class="bx bx-power-off me-2"></i>
                  <span class="align-middle">Log Out</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>
    </nav>

    <!-- / Navbar -->

    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin keluar?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Offcanvas Profil-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasProfile" aria-labelledby="offcanvasProfileLabel" style="width: 500px;">
      <div class="offcanvas-header">
          <h5 id="offcanvasProfileLabel">Profil Saya</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
          <!-- Profile Form -->
          <form id="profileForm" action="{{route('profile.update.admin')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                  <label for="profilePhoto" id="profilePhotoLabel" class="form-label text-center" style="display: none;">Foto Profil</label>
                  <div class="d-flex align-items-center justify-content-center">
                      <img src="{{ asset('foto_profil/' . auth()->user()->foto_profil) }}" width="100" height="100" class="rounded-circle me-3" id="profilePhotoPreview">
                      <input type="file" class="form-control" id="profilePhoto" name="foto_profil" accept="image/*" style="display: none;">
                  </div>
              </div>

              <div class="mb-3">
                  <label for="profileName" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="profileName" name="nama_user" value="{{ auth()->user()->nama_user }}" readonly style="background-color: white;">
              </div>
              <div class="mb-3">
                  <label for="profileEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="profileEmail" name="email" value="{{ auth()->user()->email }}" readonly style="background-color: white;">
              </div>
              <div class="mb-3">
                  <label for="profilePhone" class="form-label">Nomor Telepon</label>
                  <input type="number" class="form-control" id="profilePhone" name="no_hp" value="{{ auth()->user()->no_hp }}" readonly style="background-color: white;">
              </div>

              <div class="mb-3">
                  <label for="profileRole" class="form-label">Role</label>
                  <input type="text" class="form-control" id="profileRole" value="{{ auth()->user()->role }}" readonly>
              </div>

              <hr>
              <div class="mb-3" style="display: none;" id="currentPasswordForm">
                  <label for="currentPassword" class="form-label">Password Saat Ini <small class="text-danger ms-2">*harus diisi sebelum mengganti password</small></label>
                  <div class="input-group input-group-merge">
                      <input type="password" id="currentPassword" class="form-control" name="current_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                      <span class="input-group-text cursor-pointer" onclick="togglePassword('currentPassword')"><i class="bx bx-hide" id="currentPasswordEye"></i></span>
                  </div>
              </div>

              <div class="mb-3" style="display: none;" id="newPasswordForm">
                  <label for="newPassword" class="form-label">Password Baru <small class="text-danger ms-2">*password minimal 6 karakter</small></label>
                  <div class="input-group input-group-merge">
                      <input type="password" id="newPassword" class="form-control" name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                      <span class="input-group-text cursor-pointer" onclick="togglePassword('newPassword')"><i class="bx bx-hide" id="newPasswordEye"></i></span>
                  </div>
              </div>
              <div class="mb-3" style="display: none;" id="changePasswordForm">
                  <label for="newPasswordConfirmation" class="form-label">Konfirmasi Password Baru</label>
                  <div class="input-group input-group-merge">
                      <input type="password" id="newPasswordConfirmation" class="form-control" name="new_password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                      <span class="input-group-text cursor-pointer" onclick="togglePassword('newPasswordConfirmation')"><i class="bx bx-hide" id="newPasswordConfirmationEye"></i></span>
                  </div>
              </div>

              <!-- Edit and Close buttons -->
              <div class="d-flex justify-content-between mt-3">
                  <button type="button" class="btn btn-primary" id="editProfileBtn">Edit Profil</button>
                  <button type="submit" class="btn btn-primary" id="saveProfileBtn" style="display: none;">Simpan </button>
                  <button type="button" class="btn btn-danger" id="cancelEditBtn" style="display: none;">Batalkan Edit</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Tutup</button>
              </div>
          </form>
      </div>
    </div>

        <!-- Modal untuk Detail Notifikasi -->
        @foreach($notifications as $notification)
        <div class="modal fade" id="detailNotifikasi_{{ $notification->id_notifikasi }}" tabindex="-1" aria-labelledby="detailNotifikasi_{{ $notification->id_notifikasi }}" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalLabel{{ $notification->id_notifikasi }}">{{ $notification->judul }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <p>{{ $notification->pesan }}</p>
                      <small class="text-muted">Dari: {{ $notification->sender ? $notification->sender->nama_user : 'Sistem' }}</small><br>
                      <small class="text-muted">Waktu: {{ $notification->created_at }}</small><br>
                      <span class="badge {{ is_null($notification->read_at) ? 'bg-warning' : 'bg-success' }}">{{ is_null($notification->read_at) ? 'Belum dibaca' : 'Sudah dibaca' }}</span>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      @if(is_null($notification->read_at))
                      <button type="button" class="btn btn-primary" onclick="readNotifikasi({{ $notification->id_notifikasi }})">Tandai Dibaca</button>
                      @endif
                      @if(!is_null($notification->data))
                          <a href="{{ $notification->data }}" class="btn btn-success">Lihat Data</a>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      @endforeach

    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const editProfileBtn = document.getElementById('editProfileBtn');
          const saveProfileBtn = document.getElementById('saveProfileBtn');
          const cancelEditBtn = document.getElementById('cancelEditBtn');
          const profileName = document.getElementById('profileName');
          const profileEmail = document.getElementById('profileEmail');
          const profilePhone = document.getElementById('profilePhone');
          const profilePhotoInput = document.getElementById('profilePhoto');
          const profilePhotoLabel = document.getElementById('profilePhotoLabel');
          const changePasswordForm = document.getElementById('changePasswordForm');
          const newPasswordForm = document.getElementById('newPasswordForm');
          const currentPassword = document.getElementById('currentPasswordForm');

          let isEditing = false;

          // Event listener untuk tombol "Edit Profile"
          editProfileBtn.addEventListener('click', function() {
              if (!isEditing) {
                  // Aktifkan mode edit
                  profileName.removeAttribute('readonly');
                  profileEmail.removeAttribute('readonly');
                  profilePhone.removeAttribute('readonly');
                  profilePhotoInput.style.display = 'block';
                  profilePhotoLabel.style.display = 'block';
                   // Tampilkan input foto

                  // Ganti teks tombol dan tampilkan tombol Save
                  editProfileBtn.style.display = 'none';
                  saveProfileBtn.style.display = 'block';
                  cancelEditBtn.style.display = 'block';
                  changePasswordForm.style.display = 'block';
                  newPasswordForm.style.display = 'block';
                  currentPassword.style.display = 'block';
                  isEditing = true;
              }
          });

          // Event listener untuk tombol "Cancel Edit"
          cancelEditBtn.addEventListener('click', function() {
              if (isEditing) {
                  // Kembalikan ke mode awal
                  profileName.setAttribute('readonly', '');
                  profileEmail.setAttribute('readonly', '');
                  profilePhone.setAttribute('readonly', '');
                  profilePhotoInput.style.display = 'none';
                  profilePhotoLabel.style.display = 'none';

                  // Ganti teks tombol dan tampilkan tombol Edit
                  editProfileBtn.style.display = 'block';
                  saveProfileBtn.style.display = 'none';
                  cancelEditBtn.style.display = 'none';
                  changePasswordForm.style.display = 'none';
                  newPasswordForm.style.display = 'none';
                  currentPassword.style.display = 'none';
                  isEditing = false;
              }
          });

          // Preview gambar baru saat pengguna memilih file
          profilePhotoInput.addEventListener('change', function() {
              const file = profilePhotoInput.files[0];
              const reader = new FileReader();

              reader.onload = function(e) {
                  document.getElementById('profilePhotoPreview').src = e.target.result;
              }

              reader.readAsDataURL(file);
          });
      });
    </script>
    <script>
        function togglePassword(id){
            const x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
                document.getElementById(id + 'Eye').classList.replace("bx-hide", "bx-show");
            } else {
                x.type = "password";
                document.getElementById(id + 'Eye').classList.replace("bx-show", "bx-hide");
            }
        }
        function readNotifikasi(id) {
            axios.post("{{ route('notifikasi.read', ':id') }}".replace(':id', id), {
                _method: 'PATCH',
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    window.location.reload();
                } else {
                    alert(response.data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        document.getElementById('confirmMarkAllBtn').addEventListener('click', function() {
            axios.post("{{ route('notifikasi.markAllAsRead') }}", {
                _method: 'PATCH',
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    window.location.reload();
                } else {
                    alert(response.data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>



