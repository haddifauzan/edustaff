@extends('operator.layout.master')
@section('title', ' - Operator Data Pegawai')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Jabatan Pegawai</h1>
        <p class="ps-3">Pengelolaan data jabatan pegawai.</p>
    </div>

    <!-- Card untuk Tombol Tambah Pegawai dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 ms-auto mt-1">
                    <form action="{{ route('operator.jabatan.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama atau NIK Pegawai..." value="{{ request('search') }}">
                            <select name="jabatan" class="form-select">
                                <option value="">Semua Jabatan</option>
                                <option value="-" {{ request('jabatan') === '-' ? 'selected' : '' }}>Belum Memiliki Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}" {{ request('jabatan') == $jabatan->id_jabatan ? 'selected' : '' }}>
                                        {{ $jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('operator.jabatan.pegawai') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
            </div>            
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Pegawai -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pegawai" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>NIK</th>
                            <th>Status Kepegawaian</th>
                            <th>Status Pegawai</th>
                            <th>Jabatan</th>
                            <th>Guru Mapel</th>
                            <th>Mulai Jabatan</th>
                            <th>Selesai Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawais as $pegawai)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pegawai->nama_pegawai }}</td>
                                <td>{{ $pegawai->nik }}</td>
                                <td>{{ $pegawai->status_kepegawaian }}</td>
                                <td>
                                    <span class="badge {{ $pegawai->status_pegawai === 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $pegawai->status_pegawai }}</span>
                                </td>
                                <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                                <td>
                                    <i class="bx {{ $pegawai->is_guru ? 'bx-check' : 'bx-x' }} text-{{ $pegawai->is_guru ? 'success' : 'danger' }} d-flex align-items-center justify-content-center fs-4"></i></td>
                                <td>{{ \Carbon\Carbon::parse($pegawai->riwayatJabatan->last()->tgl_mulai ?? 'now')->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pegawai->riwayatJabatan->last()->tgl_selesai ?? 'now')->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <!-- Tombol untuk membuka modal edit jabatan -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editJabatanModal"
                                            data-id="{{ $pegawai->id_pegawai }}"
                                            data-nama="{{ $pegawai->nama_pegawai }}"
                                            data-jabatan="{{ $pegawai->jabatan->id_jabatan ?? '' }}"
                                            data-is_guru="{{ $pegawai->is_guru ? '1' : '0' }}"
                                            data-tgl_mulai="{{ $pegawai->riwayatJabatan->last()->tgl_mulai ?? ''}}" 
                                            data-tgl_selesai="{{ $pegawai->riwayatJabatan->last()->tgl_selesai ?? '' }}"
                                        >
                                            <i class="bx bx-edit"></i>
                                        </button>
                                    </div>
                                </td>                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </div>
    </div>

    <!-- Modal Edit Jabatan Pegawai -->
    <div class="modal fade" id="editJabatanModal" tabindex="-1" aria-labelledby="editJabatanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJabatanModalLabel">Edit Jabatan Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('operator.pegawai.updateJabatan') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_pegawai" id="id_pegawai">

                        <div class="mb-3">
                            <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="nama_pegawai" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select class="form-select" name="jabatan" id="jabatan">
                                @foreach($jabatans as $j)
                                    <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" id="is_guru" name="is_guru" value="1">
                                <label class="form-check-label" for="is_guru">Sebagai Guru Mapel</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-pegawai', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editJabatanModal = document.getElementById('editJabatanModal');

            editJabatanModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; 
                var idPegawai = button.getAttribute('data-id');
                var namaPegawai = button.getAttribute('data-nama');
                var jabatan = button.getAttribute('data-jabatan');
                var tglMulai = button.getAttribute('data-tgl_mulai');
                var tglSelesai = button.getAttribute('data-tgl_selesai');
                var isGuru = button.getAttribute('data-is_guru') === '1';

                var modalTitle = editJabatanModal.querySelector('.modal-title');
                var idPegawaiInput = editJabatanModal.querySelector('#id_pegawai');
                var namaPegawaiInput = editJabatanModal.querySelector('#nama_pegawai');
                var jabatanSelect = editJabatanModal.querySelector('#jabatan');
                var tglMulaiInput = editJabatanModal.querySelector('#tgl_mulai');
                var tglSelesaiInput = editJabatanModal.querySelector('#tgl_selesai');
                var isGuruCheck = editJabatanModal.querySelector('#is_guru');

                modalTitle.textContent = 'Edit Jabatan: ' + namaPegawai;
                idPegawaiInput.value = idPegawai;
                namaPegawaiInput.value = namaPegawai;
                jabatanSelect.value = jabatan;
                tglMulaiInput.value = tglMulai;
                tglSelesaiInput.value = tglSelesai; 
                isGuruCheck.checked = isGuru;
            });
        });
    </script>

    {{-- SweetAlert --}}
    @include('operator.layout.sweetalert')

@endsection
