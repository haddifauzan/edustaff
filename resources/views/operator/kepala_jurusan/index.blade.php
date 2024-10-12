@extends('operator.layout.master')
@section('title', ' - Operator Kepala Jurusan')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Kepala Jurusan</h1>
        <p class="ps-3">Pengelolaan data Kepala Jurusan.</p>
    </div>

    <!-- Card untuk Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('operator.kepala_jurusan.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Jurusan...">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="btn-group col-md-3 ms-auto" role="group" aria-label="Basic example">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#pegawaiModal" aria-controls="pegawaiModal">
                       <i class="bx bx-window-open me-2"></i>  Daftar Pegawai
                    </button>
                </div>
            </div>            
        </div>
    </div>

    <!-- Card untuk Jurusan -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Jurusan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Jurusan</th>
                                <th>Singkatan</th>
                                <th>Deskripsi</th>
                                <th>Kepala Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop untuk menampilkan data jurusan -->
                            @foreach($jurusans as $jurusan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jurusan->nama_jurusan }}</td>
                                <td>{{ $jurusan->singkatan }}</td>
                                <td>{{ $jurusan->deskripsi_jurusan }}</td>
                                <td>{{ $jurusan->kepalaJurusan ? "{$jurusan->kepalaJurusan->gelar_depan} {$jurusan->kepalaJurusan->nama_pegawai} {$jurusan->kepalaJurusan->gelar_belakang}" : '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#aturKepalaJurusanModal_{{ $jurusan->id_jurusan }}">
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
    </div>

    <!-- Modal untuk daftar guru -->
    <div class="modal fade" id="pegawaiModal" tabindex="-1" aria-labelledby="pegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pegawaiModalLabel">Daftar Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>NIK</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Status Pegawai</th>
                                    <th>Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop untuk menampilkan data pegawai -->
                                @foreach($pegawais as $guru)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guru->gelar_depan . ' ' . $guru->nama_pegawai . ' ' . $guru->gelar_belakang }}</td>
                                    <td>{{ $guru->nik }}</td>
                                    <td>{{ $guru->status_kepegawaian }}</td>
                                    <td>{{ $guru->status_pegawai }}</td>
                                    <td>{{ $guru->jabatan->nama_jabatan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Mengatur Kepala Jurusan -->
    @foreach($jurusans as $jurusan)
    <div class="modal fade" id="aturKepalaJurusanModal_{{ $jurusan->id_jurusan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atur Kepala Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('operator.jurusan.updateKepalaJurusan', $jurusan->id_jurusan) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_kepala_jurusan">Pilih Kepala Jurusan</label>
                            <select class="form-select" name="id_kepala_jurusan" id="id_kepala_jurusan" required>
                                <option value="">Pilih Kepala Jurusan</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}" {{ $jurusan->id_kepala_jurusan == $pegawai->id_pegawai ? 'selected' : '' }}>
                                        {{ $pegawai->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            new DataTable('#table-tugas', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    <script>
        document.querySelector('.btn-danger').addEventListener('click', function() {
            document.querySelector('input[name="search"]').value = '';
        });
    </script>

    {{-- SweetAlert --}}
    @include('operator.layout.sweetalert')

@endsection
