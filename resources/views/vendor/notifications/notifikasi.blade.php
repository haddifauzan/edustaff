<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifikasi</title>

    <link rel="icon" type="image/x-icon" href="{{asset('/assets/img/logo/smkn1cmi_logo.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-icons.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>

    <style>
        .card-notifikasi {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card-notifikasi:hover {
            transform: scale(1.01);
        }

        .bg-unread {
            background-color: #e9f7fe;
        }

        .bg-read {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <div class="container mt-3 px-lg-5 px-3">
        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="text-primary fs-5" onclick="location.reload()">
            <i class="bx bx-left-arrow-alt"></i> Kembali
        </a>
    
        <h1 class="mb-4 mt-3">Notifikasi</h1>
    
        <!-- Tombol untuk Mark All as Read dan Hapus Semua -->
        <div class="mb-4 d-flex flex-wrap align-items-center justify-content-between">
            <div>
                <button class="btn btn-warning mb-2 mb-sm-0 me-2" onclick="confirmMarkAllAsRead()">Tandai Semua Sebagai Terbaca</button>
                <button class="btn btn-danger mb-2 mb-sm-0" onclick="confirmDeleteAll()">Hapus Semua Notifikasi</button>
            </div>
            <div class="d-flex align-items-center gap-2 pt-1 flex-wrap flex-md-nowrap">
                <span class="badge rounded-pill border border-success px-3 py-2 d-flex align-items-center justify-content-center text-success">
                    <i class="bx bx-check text-success me-1"></i>
                    {{ $notifications->whereNotNull('read_at')->count() }} Pesan Dibaca
                </span>
                <span class="badge rounded-pill border border-primary px-3 py-2 d-flex align-items-center justify-content-center text-primary">
                    <i class="bx bx-time text-primary me-1"></i>
                    {{ $notifications->whereNull('read_at')->count() }} Pesan Belum Dibaca
                </span>
            </div>
        </div>
    
        <!-- Notifikasi Card -->
        @if($notifications->isEmpty())
            <div class="alert alert-info">
                Tidak ada notifikasi.
            </div>
        @else
            <div class="row g-3">
                @foreach ($notifications as $notification)
                <div class="col-12 col-md-6">
                    <div class="d-flex">
                        <div class="avatar me-3">
                            @if ($notification->sender && isset($notification->sender->foto_profil))
                                <img src="{{ asset('foto_profil/' . $notification->sender->foto_profil) }}" alt="Avatar" class="w-px-50 h-auto rounded-circle mt-2" />
                            @else
                                <img src="{{ asset('images/foto_profil/default.png') }}" alt="Avatar" class="w-px-50 h-auto rounded-circle mt-2" />
                            @endif
                        </div>
                        <div class="card card-notifikasi {{ is_null($notification->read_at) ? 'bg-unread' : 'bg-read' }} w-100 ms-2">
                            <div class="card-body" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $notification->id_notifikasi }}">
                                <h5 class="card-title">{{ $notification->judul }}</h5>
                                <p class="card-text text-truncate">{{ Str::limit($notification->pesan, 100) }}</p>
                                <span class="fw-bold">Dikirim oleh: </span>
                                <p class="text-truncate fs-6 text-secondary">{{ $notification->sender ? $notification->sender->nama_user : 'Sistem' }}</p>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-warning">Belum dibaca</span>
                                    @else
                                        <span class="badge bg-success">Sudah dibaca</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center pt-0">
                                <button class="btn btn-outline-danger" onclick="confirmDeleteNotifikasi({{ $notification->id_notifikasi }})"><i class="bx bx-trash"></i> Hapus Pesan</button>
                                <p class="text-muted ms-auto">{{ $notification->created_at->format('d-m-Y H:i') }}</p>               
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Modal untuk Detail Notifikasi -->
                <div class="modal fade" id="modalDetail{{ $notification->id_notifikasi }}" tabindex="-1" aria-labelledby="modalLabel{{ $notification->id_notifikasi }}" aria-hidden="true">
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
            </div>
        @endif
    </div>
    

    <!-- Modal Konfirmasi Hapus Satu Notifikasi -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus notifikasi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Semua Notifikasi -->
    <div class="modal fade" id="confirmDeleteAllModal" tabindex="-1" aria-labelledby="confirmDeleteAllModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteAllModalLabel">Konfirmasi Penghapusan Semua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus semua notifikasi?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteAllBtn">Hapus Semua</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Mark All as Read -->
    <div class="modal fade" id="confirmMarkAllModal" tabindex="-1" aria-labelledby="confirmMarkAllModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmMarkAllModalLabel">Konfirmasi Tandai Semua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmMarkAllBtn">Tandai Semua</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    

    <script type="text/javascript">
        let notifikasiIdToDelete = null;
    
        function confirmDeleteNotifikasi(id) {
            notifikasiIdToDelete = id;
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            confirmModal.show();
        }
    
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (notifikasiIdToDelete !== null) {
                axios.delete("{{ route('notifikasi.destroy', ':id') }}".replace(':id', notifikasiIdToDelete), {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
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
        });
    
        function confirmDeleteAll() {
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteAllModal'));
            confirmModal.show();
        }
    
        document.getElementById('confirmDeleteAllBtn').addEventListener('click', function() {
            axios.delete("{{ route('notifikasi.destroyAll') }}", {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
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
    
        function confirmMarkAllAsRead() {
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmMarkAllModal'));
            confirmModal.show();
        }
    
        document.getElementById('confirmMarkAllBtn').addEventListener('click', function() {
            axios.post("{{ route('notifikasi.markAllAsRead') }}", {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
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
    
        function readNotifikasi(id) {
            var url = "{{ route('notifikasi.read', ':id') }}".replace(':id', id);
            console.log("Generated URL:", url); // Tambahkan ini untuk melihat URL
    
            axios.post(url, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
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
    
        
    
    </script>    
</body>
</html>
