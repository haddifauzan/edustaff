@extends('admin.layout.master')
@section('title', ' - Admin Data Jabatan')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Jabatan</h1>
        <p class="ps-3">Pengelolaan Data Jabatan.</p>
    </div>

    <!-- Card untuk Tombol Tambah jabatan dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJabatan">
                        <i class="bx bx-plus me-2"></i> Tambah Jabatan
                    </button>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('admin.jabatan') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Jabatan..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Jabatan -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <h3 class="m-0">Tabel Jabatan</h3>
                </div>
                <div class="col text-end">
                    <a href="{{ route('admin.deleted', ['modelType' => 'jabatan']) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-trash me-1"></i> Lihat Sampah
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-jabatan" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jabatan</th>
                            <th>Deskripsi Jabatan</th>
                            <th>Golongan</th>
                            <th>Level Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatans as $jabatan)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $jabatan->nama_jabatan }}</td>
                                <td style="max-width: 250px; ">{{ $jabatan->deskripsi_jabatan }}</td>
                                <td>{{ $jabatan->golongan }}</td>
                                <td>{{ $jabatan->level_jabatan }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditJabatan{{ $jabatan->id_jabatan }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $jabatan->id_jabatan }}')"><i class="bx bx-trash"></i></button>
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
                    Apakah Anda yakin ingin menghapus Jabatan ini?
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

    <!-- Modal Tambah Jabatan -->
    <div class="modal fade" id="modalTambahJabatan" tabindex="-1" aria-labelledby="modalTambahJabatanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.jabatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahJabatanLabel">Tambah Jabatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="deskripsi_jabatan" class="form-label">Deskripsi Jabatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi_jabatan" name="deskripsi_jabatan" rows="3" required></textarea>
                        </div>
                    
                        <div class="mb-3">
                            <label for="golongan" class="form-label">Golongan <span class="text-danger">*</span></label>
                            <select class="form-select" id="golongan" name="golongan" required>
                                <option selected disabled>Pilih Golongan</option>
                                <option value="I">Golongan I - Pengatur Muda</option>
                                <option value="II">Golongan II - Pengatur</option>
                                <option value="III">Golongan III - Penata Muda</option>
                                <option value="IV">Golongan IV - Penata</option>
                            </select>
                        </div>
                    
                        <div class="mb-3">
                            <label for="level_jabatan" class="form-label">Level Jabatan <span class="text-danger">*</span></label>
                            <select class="form-select" id="level_jabatan" name="level_jabatan" required>
                                <option selected disabled>Pilih Level Jabatan</option>
                                <option value="1">Level 1 - Staff</option>
                                <option value="2">Level 2 - Kepala Sub Bagian</option>
                                <option value="3">Level 3 - Kepala Bagian</option>
                                <option value="4">Level 4 - Wakil Kepala Sekolah</option>
                                <option value="5">Level 5 - Kepala Sekolah</option>
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

    <!-- Modal Edit Jabatan -->
    @foreach ($jabatans as $jabatan)
        <div class="modal fade" id="modalEditJabatan{{ $jabatan->id_jabatan }}" tabindex="-1" aria-labelledby="modalEditJabatanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.jabatan.update', $jabatan->id_jabatan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditJabatanLabel">Edit Jabatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="{{ $jabatan->nama_jabatan }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_jabatan" class="form-label">Deskripsi Jabatan</label>
                                <textarea class="form-control" id="deskripsi_jabatan" name="deskripsi_jabatan" rows="3" required>{{ $jabatan->deskripsi_jabatan }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="golongan" class="form-label">Golongan</label>
                                <select class="form-select" id="golongan" name="golongan" required>
                                    <option selected disabled>Pilih Golongan</option>
                                    <option value="I" {{ $jabatan->golongan == 'I' ? 'selected' : '' }}>Golongan I - Pengatur Muda</option>
                                    <option value="II" {{ $jabatan->golongan == 'II' ? 'selected' : '' }}>Golongan II - Pengatur</option>
                                    <option value="III" {{ $jabatan->golongan == 'III' ? 'selected' : '' }}>Golongan III - Penata Muda</option>
                                    <option value="IV" {{ $jabatan->golongan == 'IV' ? 'selected' : '' }}>Golongan IV - Penata</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="level_jabatan" class="form-label">Level Jabatan</label>
                                <select class="form-select" id="level_jabatan" name="level_jabatan" required>
                                    <option selected disabled>Pilih Level Jabatan</option>
                                    <option value="1" {{ $jabatan->level_jabatan == 1 ? 'selected' : '' }}>Level 1 - Staff</option>
                                    <option value="2" {{ $jabatan->level_jabatan == 2 ? 'selected' : '' }}>Level 2 - Kepala Sub Bagian</option>
                                    <option value="3" {{ $jabatan->level_jabatan == 3 ? 'selected' : '' }}>Level 3 - Kepala Bagian</option>
                                    <option value="4" {{ $jabatan->level_jabatan == 4 ? 'selected' : '' }}>Level 4 - Wakil Kepala Sekolah</option>
                                    <option value="5" {{ $jabatan->level_jabatan == 5 ? 'selected' : '' }}>Level 5 - Kepala Sekolah</option>
                                </select>
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
            new DataTable('#table-jabatan', {
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
            deleteForm.action = `/admin/jabatan/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>


    {{-- SweetAlert --}}
@include('admin.layout.sweetalert')

@endsection