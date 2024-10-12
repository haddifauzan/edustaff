@extends('operator.layout.master')
@section('title', ' - Operator Tugas Tambahan')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Tugas Tambahan Pegawai</h1>
        <p class="ps-3">Pengelolaan data tugas tambahan pegawai.</p>
    </div>

    <!-- Card untuk Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('operator.tugas.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_tugas" placeholder="Cari nama tugas..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="btn-group col-md-4 ms-auto" role="group" aria-label="Basic example">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahTugasModal">
                        <i class="bx bx-plus me-2"></i>Tambah Tugas
                    </button>
                    <!-- Button untuk membuka daftar pegawai dalam offcanvas -->
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#pegawaiOffcanvas" aria-controls="pegawaiOffcanvas">
                       <i class="bx bx-arrow-to-left me-2"></i>  Daftar Pegawai
                    </button>
                </div>
            </div>            
        </div>
    </div>

    <!-- Card untuk Tugas Tambahan -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-tugas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Tugas</th>
                                <th>Deskripsi</th>
                                <th>Pegawai</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop untuk menampilkan tugas tambahan -->
                            @foreach($tugasTambahan as $tugas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tugas->nama_tugas }}</td>
                                <td>
                                    <span data-bs-toggle="tooltip" data-bs-html="true" title="{{ $tugas->deskripsi_tugas }}">
                                        {{ Str::limit($tugas->deskripsi_tugas, 20) }}
                                    </span>
                                </td>
                                <td>{{ $tugas->pegawai->nama_pegawai }}</td>
                                <td>{{ \Carbon\Carbon::parse($tugas->tgl_mulai)->format('d M Y') }}</td>
                                <td>{{ $tugas->tgl_selesai ? \Carbon\Carbon::parse($tugas->tgl_selesai)->format('d M Y') : '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <!-- Button untuk mengedit tugas -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTugasModal_{{ $tugas->id_tugas_tambahan }}">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <!-- Button untuk menghapus tugas -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal_{{ $tugas->id_tugas_tambahan }}">
                                            <i class="bx bx-trash"></i>
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
    </div>
    <!-- Offcanvas untuk daftar pegawai -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="pegawaiOffcanvas" aria-labelledby="pegawaiOffcanvasLabel" style="width: 800px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="pegawaiOffcanvasLabel">Daftar Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>NIK</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop untuk menampilkan data pegawai -->
                        @foreach($pegawais as $pegawai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pegawai->nama_pegawai }}</td>
                            <td>{{ $pegawai->nik }}</td>
                            <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#aturTugasModal_{{ $pegawai->id_pegawai }}">
                                    <i class="bx bx-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Atur Tugas -->
    @foreach($pegawais as $pegawai)
    <div class="modal fade" id="aturTugasModal_{{ $pegawai->id_pegawai }}" tabindex="-1" aria-labelledby="aturTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aturTugasModalLabel">Atur Tugas Tambahan - {{ $pegawai->nama_pegawai }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengatur tugas tambahan -->
                    <form action="{{ route('operator.tugas.atur') }}" method="POST">
                        @csrf
                        <!-- Hidden input untuk ID Pegawai -->
                        <input type="hidden" name="id_pegawai" value="{{ $pegawai->id_pegawai }}">
                        
                        <div class="mb-3">
                            <label for="nama_pegawai_{{ $pegawai->id_pegawai }}" class="form-label">Pegawai</label>
                            <input type="text" class="form-control" id="nama_pegawai_{{ $pegawai->id_pegawai }}" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tugas_tambahan_{{ $pegawai->id_pegawai }}" class="form-label">Tugas Tambahan</label>
                            <select class="form-select" id="tugas_tambahan_{{ $pegawai->id_pegawai }}" name="tugas_tambahan" required>
                                <option value="">Pilih Tugas Tambahan</option>
                                @foreach($tugasTambahanDaftar as $tugasDaftar)
                                <option value="{{ $tugasDaftar->id }}">{{ $tugasDaftar->nama_tugas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai_{{ $pegawai->id_pegawai }}" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai_{{ $pegawai->id_pegawai }}" name="tgl_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai_{{ $pegawai->id_pegawai }}" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai_{{ $pegawai->id_pegawai }}" name="tgl_selesai">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <!-- Modal Tambah Tugas -->
    <div class="modal fade" id="tambahTugasModal" tabindex="-1" aria-labelledby="tambahTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTugasModalLabel">Tambah Tugas Tambahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambah tugas tambahan -->
                    <form action="{{ route('operator.tugas.tambah') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="pegawai_id" class="form-label">Pegawai</label>
                            <select class="form-select" id="pegawai_id" name="id_pegawai" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nama_pegawai }} || {{$pegawai->nik}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_tugas" class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" placeholder="Masukkan nama tugas">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_tugas" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" id="deskripsi_tugas" name="deskripsi_tugas" rows="3" placeholder="Masukkan deskripsi tugas"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal Edit Tugas -->
    @foreach($tugasTambahan as $tugas)
    <div class="modal fade" id="editTugasModal_{{ $tugas->id_tugas_tambahan }}" tabindex="-1" aria-labelledby="editTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTugasModalLabel">Edit Tugas Tambahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit tugas tambahan -->
                    <form action="{{ route('operator.tugas.update', ['id' => $tugas->id_tugas_tambahan]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_tugas_tambahan" id="id_tugas_{{ $tugas->id_tugas_tambahan }}" value="{{ $tugas->id_tugas_tambahan }}">
                        <div class="mb-3">
                            <label for="edit_pegawai_id_{{ $tugas->id_tugas_tambahan }}" class="form-label">Pegawai</label>
                            <select class="form-select" id="edit_pegawai_id_{{ $tugas->id_tugas_tambahan }}" name="id_pegawai" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}" {{ $tugas->id_pegawai === $pegawai->id_pegawai ? 'selected' : '' }}>{{ $pegawai->nama_pegawai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_tugas_{{ $tugas->id_tugas_tambahan }}" class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" id="edit_nama_tugas_{{ $tugas->id_tugas_tambahan }}" name="nama_tugas" value="{{ $tugas->nama_tugas }}">
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi_tugas_{{ $tugas->id_tugas_tambahan }}" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" id="edit_deskripsi_tugas_{{ $tugas->id_tugas_tambahan }}" name="deskripsi_tugas" rows="3">{{ $tugas->deskripsi_tugas }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tgl_mulai_{{ $tugas->id_tugas_tambahan }}" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="edit_tgl_mulai_{{ $tugas->id_tugas_tambahan }}" name="tgl_mulai" value="{{ $tugas->tgl_mulai }}">
                        </div>
                        <div class="mb-3">
                            <label for="edit_tgl_selesai_{{ $tugas->id_tugas_tambahan }}" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="edit_tgl_selesai_{{ $tugas->id_tugas_tambahan }}" name="tgl_selesai" value="{{ $tugas->tgl_selesai }}">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Konfirmasi Hapus -->
    @foreach($tugasTambahan as $tugas)
    <div class="modal fade" id="confirmDeleteModal_{{ $tugas->id_tugas_tambahan }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus tugas tambahan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('operator.tugas.delete', $tugas->id_tugas_tambahan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-tugas', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var aturTugasModal = document.getElementById('aturTugasModal');
            aturTugasModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var idPegawai = button.getAttribute('data-id');
                
                fetch('/pegawai/' + idPegawai)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nama_pegawai').value = data.nama_pegawai;
                        // Simpan ID pegawai ke dalam form untuk dikirim ke server
                        document.querySelector('#aturTugasModal form').action = '/atur-tugas/' + idPegawai;
                    });
            });
        });

        document.querySelector('.btn-danger').addEventListener('click', function() {
            document.querySelector('input[name="search"]').value = '';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const aturTugasButtons = document.querySelectorAll('.atur-tugas-btn');
            aturTugasButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pegawaiId = this.getAttribute('data-pegawai-id');
                    const pegawaiNama = this.getAttribute('data-pegawai-nama');
                    
                    document.getElementById('pegawai_id').value = pegawaiId;
                    document.getElementById('nama_pegawai').value = pegawaiNama;
                });
            });
        });


    </script>

    {{-- SweetAlert --}}
    @include('operator.layout.sweetalert')

@endsection
