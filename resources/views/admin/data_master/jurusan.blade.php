@extends('admin.layout.master')
@section('title', ' - Admin Data Jurusan')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Jurusan</h1>
        <p class="ps-3">Pengelolaan Data Jurusan.</p>
    </div>

    <!-- Card untuk Tombol Tambah jabatan dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJurusan">
                        <i class="bx bx-plus me-2"></i> Tambah Jurusan
                    </button>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('admin.jurusan') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Jurusan..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Jurusan -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <h3 class="m-0">Tabel Jurusan</h3>
                </div>
                <div class="col text-end">
                    <a href="{{ route('admin.deleted', ['modelType' => 'jurusan']) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-trash me-1"></i> Lihat Sampah
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-jurusan" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jurusan</th>
                            <th>Singkatan</th>
                            <th>Deskripsi Jurusan</th>
                            <th>Kepala Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurusans as $jurusan)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $jurusan->nama_jurusan }}</td>
                                <td>{{ $jurusan->singkatan }}</td>
                                <td style="max-width: 250px; ">{{ $jurusan->deskripsi_jurusan }}</td>
                                <td>{{ $jurusan->kepalaJurusan->nama_pegawai ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditJurusan{{ $jurusan->id_jurusan }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $jurusan->id_jurusan }}')"><i class="bx bx-trash"></i></button>
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
                    Apakah Anda yakin ingin menghapus Jurusan ini?
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

    <!-- Modal Tambah Jurusan -->
    <div class="modal fade" id="modalTambahJurusan" tabindex="-1" aria-labelledby="modalTambahJurusanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.jurusan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahJurusanLabel">Tambah Jurusan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_jurusan" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="singakatan_jurusan" class="form-label">Singkatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="singkatan_jurusan" name="singkatan"required></input>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_jurusan" class="form-label">Deskripsi Jurusan </label>
                            <textarea class="form-control" id="deskripsi_jurusan" name="deskripsi_jurusan" rows="3"></textarea>
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

    <!-- Modal Edit Jurusan -->
    @foreach ($jurusans as $jurusan)
        <div class="modal fade" id="modalEditJurusan{{ $jurusan->id_jurusan }}" tabindex="-1" aria-labelledby="modalEditJurusanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditJurusanLabel">Edit Jurusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="{{ $jurusan->nama_jurusan }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="singakatan_jurusan" class="form-label">Singkatan</label>
                                <input type="text" class="form-control" id="singkatan_jurusan" name="singkatan" value="{{ $jurusan->singkatan }}" required></input>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_jurusan" class="form-label">Deskripsi Jurusan</label>
                                <textarea class="form-control" id="deskripsi_jurusan" name="deskripsi_jurusan" rows="3" required>{{ $jurusan->deskripsi_jurusan }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-jurusan', {
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
            deleteForm.action = `/admin/jurusan/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>


    {{-- SweetAlert --}}
@include('admin.layout.sweetalert')
@endsection
