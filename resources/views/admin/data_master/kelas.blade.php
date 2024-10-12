@extends('admin.layout.master')
@section('title', ' - Admin Data Kelas')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Kelas</h1>
        <p class="ps-3">Pengelolaan Data Kelas.</p>
    </div>

    <!-- Card untuk Tombol Tambah Kelas dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                        <i class="bx bx-plus me-2"></i> Tambah Kelas
                    </button>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('admin.kelas') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Kelas..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Kelas -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <h3 class="m-0">Tabel Kelas</h3>
                </div>
                <div class="col text-end">
                    <a href="{{ route('admin.deleted', ['modelType' => 'kelas']) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-trash me-1"></i> Lihat Sampah
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-kelas" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Kelompok</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelass as $kelas)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $kelas->nama_kelas }}</td>
                                <td>{{ $kelas->tingkat }}</td>
                                <td>{{ $kelas->kelompok }}</td>
                                <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                <td>{{ $kelas->wali_kelas ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKelas{{ $kelas->id_kelas }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $kelas->id_kelas }}')"><i class="bx bx-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Kelas ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                                <option value="XIII">XIII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-select" id="jurusan" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->singkatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelompok" class="form-label">Kelompok <span class="text-danger">*</span></label>
                            <select class="form-select" id="kelompok" name="kelompok" required>
                                <option value="">Pilih Kelompok</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    @foreach ($kelass as $kelas)
    <div class="modal fade" id="modalEditKelas{{ $kelas->id_kelas }}" tabindex="-1" aria-labelledby="modalEditKelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.kelas.update', $kelas->id_kelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKelasLabel">Edit Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_kelas_sebelumnya_{{ $kelas->id_kelas }}" class="form-label">Nama Kelas Sebelumnya <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_kelas_sebelumnya_{{ $kelas->id_kelas }}" value="{{ $kelas->nama_kelas }}" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_kelas_{{ $kelas->id_kelas }}" class="form-label">Nama Kelas Baru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_kelas_{{ $kelas->id_kelas }}" name="nama_kelas" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tingkat_{{ $kelas->id_kelas }}" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_tingkat_{{ $kelas->id_kelas }}" name="tingkat" required>
                                <option value="X" {{ $kelas->tingkat == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ $kelas->tingkat == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ $kelas->tingkat == 'XII' ? 'selected' : '' }}>XII</option>
                                <option value="XIII" {{ $kelas->tingkat == 'XIII' ? 'selected' : '' }}>XIII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jurusan_{{ $kelas->id_kelas }}" class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jurusan_{{ $kelas->id_kelas }}" name="jurusan_id" required>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id_jurusan }}" {{ $kelas->id_jurusan == $jurusan->id_jurusan ? 'selected' : '' }}>
                                        {{ $jurusan->singkatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kelompok_{{ $kelas->id_kelas }}" class="form-label">Kelompok <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_kelompok_{{ $kelas->id_kelas }}" name="kelompok" required>
                                <option value="A" {{ $kelas->kelompok == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ $kelas->kelompok == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ $kelas->kelompok == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ $kelas->kelompok == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-kelas', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    <script>
        function confirmDelete(id) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/kelas/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Untuk modal tambah kelas
            const tingkat = document.getElementById('tingkat');
            const jurusan = document.getElementById('jurusan');
            const kelompok = document.getElementById('kelompok');
            const namaKelas = document.getElementById('nama_kelas');

            function updateNamaKelas() {
                if (tingkat && jurusan && kelompok && namaKelas) { // Pengecekan null untuk elemen tambah kelas
                    const selectedTingkat = tingkat.value;
                    const selectedJurusan = jurusan.options[jurusan.selectedIndex].text;
                    const selectedKelompok = kelompok.value;

                    namaKelas.value = selectedTingkat && selectedJurusan && selectedKelompok ? 
                        `${selectedTingkat} ${selectedJurusan} ${selectedKelompok}` : '';
                }
            }

            if (tingkat && jurusan && kelompok) { // Pengecekan null sebelum menambahkan event listener
                tingkat.addEventListener('change', updateNamaKelas);
                jurusan.addEventListener('change', updateNamaKelas);
                kelompok.addEventListener('change', updateNamaKelas);
            }

            // Untuk semua modal edit kelas
            document.querySelectorAll('[id^="modalEditKelas"]').forEach(function(modal) {
                const kelasId = modal.id.replace("modalEditKelas", ""); // Ambil ID kelas dari ID modal

                // Ambil elemen input/select yang diperlukan
                const tingkatSelect = document.getElementById(`edit_tingkat_${kelasId}`);
                const jurusanSelect = document.getElementById(`edit_jurusan_${kelasId}`);
                const kelompokSelect = document.getElementById(`edit_kelompok_${kelasId}`);
                const namaKelasInput = document.getElementById(`edit_nama_kelas_${kelasId}`);

                // Fungsi untuk update nama kelas baru berdasarkan pilihan
                function updateNamaKelas() {
                    if (tingkatSelect && jurusanSelect && kelompokSelect && namaKelasInput) { // Pengecekan null untuk modal edit kelas
                        const tingkat = tingkatSelect.value;
                        const jurusan = jurusanSelect.selectedOptions[0].text;
                        const kelompok = kelompokSelect.value;

                        const namaKelasBaru = `${tingkat} ${jurusan} ${kelompok}`;
                        namaKelasInput.value = namaKelasBaru;
                    }
                }

                // Tambahkan event listener hanya jika elemen ada
                if (tingkatSelect && jurusanSelect && kelompokSelect) { // Pengecekan null sebelum menambahkan event listener
                    tingkatSelect.addEventListener('change', updateNamaKelas);
                    jurusanSelect.addEventListener('change', updateNamaKelas);
                    kelompokSelect.addEventListener('change', updateNamaKelas);
                }
            });
        });
    </script>




    {{-- SweetAlert --}}
@include('admin.layout.sweetalert')

@endsection
