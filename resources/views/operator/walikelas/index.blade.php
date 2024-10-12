@extends('operator.layout.master')
@section('title', ' - Operator Wali Kelas')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Guru Guru Wali Kelas</h1>
        <p class="ps-3">Pengelolaan data Guru Wali Kelas.</p>
    </div>

    <!-- Card untuk Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('operator.walikelas.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari kelas...">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="btn-group col-md-4 ms-auto" role="group" aria-label="Basic example">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#pegawaiModal" aria-controls="pegawaiModal">
                       <i class="bx bx-window-open me-2"></i>  Daftar Guru
                    </button>
                </div>
            </div>            
        </div>
    </div>

    <!-- Card untuk Kelas dan Walikelas -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-tugas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Kelompok</th>
                                <th>Jurusan</th>
                                <th>Walikelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop untuk menampilkan data kelas -->
                            @foreach($kelass as $kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelas->nama_kelas }}</td>
                                <td>{{ $kelas->tingkat }}</td>
                                <td>{{ $kelas->kelompok }}</td>
                                <td>{{ $kelas->jurusan ? $kelas->jurusan->singkatan : '-' }}</td>
                                <td>{{ $kelas->walikelas ? $kelas->walikelas->gelar_depan . ' ' . $kelas->walikelas->nama_pegawai . ' ' . $kelas->walikelas->gelar_belakang : '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#aturGuruWalikelasModal_{{ $kelas->id_kelas }}">
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
                    <h5 class="modal-title" id="pegawaiModalLabel">Daftar guru</h5>
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
                                @foreach($gurus as $guru)
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

    <!-- Modal Atur Wali Kelas -->
    @foreach($kelass as $kelas)
    <div class="modal fade" id="aturGuruWalikelasModal_{{ $kelas->id_kelas }}" tabindex="-1" aria-labelledby="aturGuruWalikelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aturGuruWalikelasModalLabel">Atur Wali Kelas untuk {{ $kelas->nama_kelas }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('operator.kelas.update_walikelas', $kelas->id_kelas) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Input untuk memilih walikelas -->
                        <div class="mb-3">
                            <label for="id_walikelas" class="form-label">Wali Kelas</label>
                            <select class="form-select" id="id_walikelas" name="id_walikelas" required>
                                <option value="">Pilih Wali Kelas</option>
                                @foreach($walikelas as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}" {{ old('id_walikelas', $kelas->id_walikelas) == $pegawai->id_pegawai ? 'selected' : '' }}>
                                        {{ $pegawai->gelar_depan . ' ' . $pegawai->nama_pegawai . ' ' . $pegawai->gelar_belakang }}
                                    </option>
                                @endforeach
                            </select>
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
