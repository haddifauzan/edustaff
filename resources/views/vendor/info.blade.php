<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>EDUSTAFF - Info Aplikasi</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/smkn1cmi_logo.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
    <style>
        /* Custom Styling */
        body {
            background-color: #f4f6f8;
            font-family: 'Public Sans', sans-serif;
        }

        .misc-wrapper {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 800px;
            margin: 2rem auto;
        }

        .misc-wrapper h2 {
            font-size: 2rem;
            color: #333;
            font-weight: 600;
            text-align: center;
        }

        .misc-wrapper p {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .list-group-item {
            padding: 1.25rem;
            border: none;
            border-radius: 10px;
            margin-bottom: 1rem;
            background-color: #f7f7f7;
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #e6e6e6;
        }

        .list-group-item i {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #0d6efd;
        }

        .list-group-item strong {
            font-weight: 600;
            color: #333;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Selamat Datang di EduStaff!</h2>
            <p class="mb-4 mx-2">EduStaff adalah aplikasi yang dirancang untuk mempermudah Administrasi Kepegawaian di SMK Negeri 1 Cimahi. Aplikasi ini menyediakan berbagai fitur untuk mendukung pengelolaan data pegawai, jabatan, dan tugas tambahan.</p>
            
            <h4 class="mt-4">Fitur Utama:</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <i class="bx bx-user"></i> 
                    <strong>Manajemen Pegawai:</strong> 
                    Tambah, edit, dan hapus data pegawai. Memudahkan pengelolaan informasi pegawai secara efisien.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-briefcase"></i> 
                    <strong>Manajemen Jabatan:</strong> 
                    Kelola jabatan pegawai dengan mudah, termasuk penambahan dan penghapusan jabatan.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-book"></i> 
                    <strong>Manajemen Mata Pelajaran:</strong> 
                    Atur mata pelajaran yang diajarkan di sekolah, termasuk penugasan guru.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-building"></i> 
                    <strong>Manajemen Kelas:</strong> 
                    Kelola kelas dan walikelas, termasuk penjadwalan dan pengelolaan siswa.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-file"></i> 
                    <strong>Laporan:</strong> 
                    Buat laporan pegawai, riwayat jabatan, dan prestasi untuk analisis dan evaluasi.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-bell"></i> 
                    <strong>Notifikasi:</strong> 
                    Dapatkan notifikasi terkait pengajuan dan perubahan data untuk tetap terinformasi.
                </li>
                <li class="list-group-item">
                    <i class="bx bx-help-circle"></i> 
                    <strong>Bantuan:</strong> 
                    Akses bantuan dan panduan penggunaan aplikasi untuk memaksimalkan fungsionalitas.
                </li>
            </ul>

            <p class="mb-4 mx-2">Kami berkomitmen untuk memberikan pengalaman terbaik dalam pengelolaan administrasi kepegawaian. Jika Anda memiliki pertanyaan atau butuh bantuan, silakan hubungi kami.</p>
            <a href="javascript:window.history.back()" class="btn btn-primary"><i class="bx bx-arrow-back me-2"></i> Kembali ke Halaman Sebelumnya</a>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
