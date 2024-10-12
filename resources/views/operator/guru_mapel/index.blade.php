@extends('operator.layout.master')
@section('title', ' - Operator Guru Mapel')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Guru Mata Pelajaran</h1>
        <p class="ps-3">Pengelolaan data Guru Mata Pelajaran.</p>
    </div>

    <!-- Card untuk Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('operator.guru_mapel.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari nama atau kode Mapel...">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="btn-group col-md-4 ms-auto" role="group" aria-label="Basic example">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#pegawaiModal" aria-controls="pegawaiModal">
                       <i class="bx bx-window-open me-2"></i>  Daftar Guru
                    </button>
                    <button class="btn btn-outline-info" type="button" data-bs-toggle="modal" data-bs-target="#kelasModal" aria-controls="kelasModal">
                       <i class="bx bx-window-open me-2"></i>  Daftar Kelas
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
                                <th>Nama Mapel</th>
                                <th>Kode Pelajaran</th>
                                <th>Jenis Mapel</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mapels as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapel->nama_pelajaran }}</td>
                                <td>{{ $mapel->kode_pelajaran }}</td>
                                <td>{{ $mapel->jenis_mapel }}</td>
                                <td>{{ $mapel->tingkat }}</td>
                                <td>{{ $mapel->jenis_mapel == 'Kejuruan' ? $mapel->jurusan->singkatan : '-' }}</td>
                                <td>{{ $mapel->guru->nama_pegawai ?? 'Tidak Ada Guru' }}</td>
                                <td>
                                    <ul>
                                        @foreach($mapel->kelas as $kelas)
                                            <li>{{ $kelas->nama_kelas }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#aturGuruMapelModal_{{ $mapel->id_pelajaran }}" onclick="console.log({{ $mapel->id_pelajaran }})">
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
                                    <td>{{ $guru->nama_pegawai }}</td>
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

    <!-- Modal untuk daftar kelas -->
    <div class="modal fade" id="kelasModal" tabindex="-1" aria-labelledby="kelasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kelasModalLabel">Daftar Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Kelompok</th>
                                    <th>Jurusan</th>
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
                                    <td>{{ $kelas->jurusan->singkatan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($mapels as $mapel)
    <!-- Modal Atur Guru dan Kelas untuk Mapel {{ $mapel->nama_pelajaran }} -->
    <div class="modal fade" id="aturGuruMapelModal_{{ $mapel->id_pelajaran }}" tabindex="-1" aria-labelledby="aturGuruMapelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aturGuruMapelModalLabel">Atur Guru dan Kelas untuk Mapel {{ $mapel->nama_pelajaran }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengatur guru dan kelas -->
                    <form action="{{ route('operator.guru_mapel.update', $mapel->id_pelajaran) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Input untuk memilih guru -->
                        <div class="mb-3">
                            <label for="nama_pelajaran" class="form-label">Nama Mapel</label>
                            <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" value="{{ $mapel->nama_pelajaran }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kode_pelajaran" class="form-label">Kode Mapel</label>
                            <input type="text" class="form-control" id="kode_pelajaran" name="kode_pelajaran" value="{{ $mapel->kode_pelajaran }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat</label>
                            <input type="text" class="form-control" id="tingkat" name="tingkat" value="{{ $mapel->tingkat }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_pegawai" class="form-label">Guru</label>
                            <select class="form-select" id="id_pegawai" name="id_pegawai">
                                <option value="">Pilih Guru</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_pegawai }}" {{ $mapel->id_pegawai == $guru->id_pegawai ? 'selected' : '' }}>
                                        {{ $guru->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input untuk memilih banyak kelas -->
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="search_kelas_{{ $mapel->id_pelajaran }}" placeholder="Cari nama kelas..." aria-label="Cari nama kelas" aria-describedby="search_kelas_button">
                                <button class="btn btn-secondary" type="button" id="search_kelas_button"><i class="bx bx-search"></i></button>
                            </div>
                            <div class="form-check" id="list_kelas_{{ $mapel->id_pelajaran }}">
                                @if($kelass->where('tingkat', $mapel->tingkat)->count() > 0)
                                    @foreach($kelass->where('tingkat', $mapel->tingkat) as $kelas)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="kelas_{{ $kelas->id_kelas }}" name="kelas[]" value="{{ $kelas->id_kelas }}"
                                                {{ in_array($kelas->id_kelas, $mapel->kelas->pluck('id_kelas')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kelas_{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center">Tingkat kelas belum tersedia.</p>
                                @endif
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#search_kelas_button').click(function () {
                                    var search = $('#search_kelas_{{ $mapel->id_pelajaran }}').val();
                                    $('#list_kelas_{{ $mapel->id_pelajaran }}').find('div').each(function () {
                                        var label = $(this).find('label').text();
                                        if (label.toLowerCase().includes(search.toLowerCase())) {
                                            $(this).show();
                                        } else {
                                            $(this).hide();
                                        }
                                    });
                                });
                            });
                        </script>

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
