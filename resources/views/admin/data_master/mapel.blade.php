@extends('admin.layout.master')
@section('title', ' - Admin Data Mapel')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Mata Pelajaran</h1>
        <p class="ps-3">Pengelolaan Data Mata Pelajaran.</p>
    </div>

    <!-- Card untuk Tombol Tambah Mapel dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMapel">
                        <i class="bx bx-plus me-2"></i> Tambah Mata Pelajaran
                    </button>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('admin.mapel') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Mapel..." value="{{ request('search') }}">
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
                    <h3 class="m-0">Tabel Mapel</h3>
                </div>
                <div class="col text-end">
                    <a href="{{ route('admin.deleted', ['modelType' => 'mapel']) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-trash me-1"></i> Lihat Sampah
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-mapel" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mapel</th>
                            <th>Kode Mapel</th>
                            <th>Deskripsi</th>
                            <th>Jenis Mapel</th> 
                            <th>Tingkat</th>  
                            <th>Jurusan</th>
                            <th>Guru</th>  
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapels as $mapel)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $mapel->nama_pelajaran }}</td>
                                <td>{{ $mapel->kode_pelajaran }}</td>
                                <td style="max-width: 250px; ">{{ $mapel->deskripsi ? $mapel->deskripsi : '-' }}</td>
                                <td>{{ $mapel->jenis_mapel }}</td>
                                <td>{{ $mapel->tingkat }}</td>
                                <td>{{ $mapel->jenis_mapel == 'Kejuruan' ? $mapel->jurusan->nama_jurusan : '-' }}</td>
                                <td>{{ $mapel->guru->nama_pegawai ?? "-"}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditMapel{{ $mapel->id_pelajaran }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $mapel->id_pelajaran }}')"><i class="bx bx-trash"></i></button>
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
                    Apakah Anda yakin ingin menghapus Mata Pelajaran ini?
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

    <!-- Modal Tambah Mapel -->
    <div class="modal fade" id="modalTambahMapel" tabindex="-1" aria-labelledby="modalTambahMapelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahMapelLabel">Tambah Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_pelajaran" class="form-label">Nama Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="kode_pelajaran" class="form-label">Kode Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kode_pelajaran" name="kode_pelajaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_mapel" class="form-label">Jenis Mapel <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis_mapel" name="jenis_mapel" required>
                                <option value="">-- Pilih Jenis Mapel --</option>
                                <option value="NA">NA</option>
                                <option value="Kejuruan">Kejuruan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                                <option value="XIII">XIII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan" name="jurusan" style="display:none;">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
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

    <!-- Modal Edit Mapel -->
    @foreach ($mapels as $mapel)
        <div class="modal fade" id="modalEditMapel{{ $mapel->id_pelajaran }}" tabindex="-1" aria-labelledby="modalEditMapelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.mapel.update', $mapel->id_pelajaran) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditMapelLabel">Edit Mapel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_pelajaran" class="form-label">Nama Mapel</label>
                                <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" value="{{ $mapel->nama_pelajaran }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="kode_pelajaran" class="form-label">Kode Mapel</label>
                                <input type="text" class="form-control" id="kode_pelajaran" name="kode_pelajaran" value="{{ $mapel->kode_pelajaran }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $mapel->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_mapel" class="form-label">Jenis Mapel</label>
                                <select class="form-select jenis_mapel_edit" id="jenis_mapel{{ $mapel->id_pelajaran }}" name="jenis_mapel" required>
                                    <option value="">-- Pilih Jenis Mapel --</option>
                                    <option value="NA" {{ $mapel->jenis_mapel == 'NA' ? 'selected' : '' }}>NA</option>
                                    <option value="Kejuruan" {{ $mapel->jenis_mapel == 'Kejuruan' ? 'selected' : '' }}>Kejuruan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tingkat" class="form-label">Tingkat</label>
                                <select class="form-select" id="tingkat" name="tingkat" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="X" {{ $mapel->tingkat == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ $mapel->tingkat == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ $mapel->tingkat == 'XII' ? 'selected' : '' }}>XII</option>
                                    <option value="XIII" {{ $mapel->tingkat == 'XIII' ? 'selected' : '' }}>XIII</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <select class="form-select jurusan_edit" id="jurusan_edit{{ $mapel->id_pelajaran }}" name="jurusan" style="{{ $mapel->jenis_mapel == 'Kejuruan' ? '' : 'display:none;' }}">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id_jurusan }}" {{ $mapel->id_jurusan == $jurusan->id_jurusan ? 'selected' : '' }}>{{ $jurusan->nama_jurusan  }}</option>
                                    @endforeach
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
            new DataTable('#table-mapel', {
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
            deleteForm.action = `/admin/mapel/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisMapelSelect = document.querySelector('#jenis_mapel');
            const jurusanSelect = document.querySelector('#jurusan');

            jenisMapelSelect.addEventListener('change', function () {
                if (this.value === 'Kejuruan') {
                    jurusanSelect.style.display = 'block';
                } else {
                    jurusanSelect.style.display = 'none';
                }
            });

            // Jika pada saat diedit dan jenis Mapel adalah Kejuruan, maka jurusan sudah langsung muncul
            if (jenisMapelSelect.value === 'Kejuruan') {
                jurusanSelect.style.display = 'block';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($mapels as $mapel)
                // Memantau perubahan pada dropdown jenis_mapel
                const jenisMapelSelect{{ $mapel->id_pelajaran }} = document.getElementById('jenis_mapel{{ $mapel->id_pelajaran }}');
                const jurusanSelect{{ $mapel->id_pelajaran }} = document.getElementById('jurusan_edit{{ $mapel->id_pelajaran }}');
                
                // Menampilkan atau menyembunyikan input jurusan berdasarkan pilihan jenis_mapel
                jenisMapelSelect{{ $mapel->id_pelajaran }}.addEventListener('change', function() {
                    if (jenisMapelSelect{{ $mapel->id_pelajaran }}.value === 'Kejuruan') {
                        jurusanSelect{{ $mapel->id_pelajaran }}.style.display = '';
                    } else {
                        jurusanSelect{{ $mapel->id_pelajaran }}.style.display = 'none';
                    }
                });

                // Jika saat halaman dimuat jenis_mapel sudah Kejuruan, tampilkan jurusan
                if (jenisMapelSelect{{ $mapel->id_pelajaran }}.value === 'Kejuruan') {
                    jurusanSelect{{ $mapel->id_pelajaran }}.style.display = '';
                }
            @endforeach
        });
    </script>


    {{-- SweetAlert --}}
@include('admin.layout.sweetalert')

@endsection
