@extends('admin.layout.master')
@section('title', ' - Laporan Riwayat Jabatan Pegawai')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Laporan Riwayat Jabatan Pegawai</h1>
        <p class="ps-3">Menampilkan laporan riwayat jabatan pegawai.</p>
    </div>

    <!-- Card untuk filter dan tombol download -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.riwayat-jabatan') }}" method="GET" class="row g-3">
                <!-- Input Pencarian -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pegawai</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nama, Email, NIP, NIK" value="{{ request('search') }}">
                </div>
                <!-- Select Tahun Ajaran -->
                <div class="col-md-4">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <select class="form-select" id="tahun_ajaran" name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @for($tahun = 2020; $tahun <= 2030; $tahun++)
                            <option value="{{ $tahun . '-' . ($tahun + 1) }}" {{ request('tahun_ajaran') == ($tahun . '-' . ($tahun + 1)) ? 'selected' : '' }}>
                                {{ $tahun . '-' . ($tahun + 1) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <!-- Select Jabatan -->
                <div class="col-md-4">
                    <label for="id_jabatan" class="form-label">Jabatan</label>
                    <select class="form-select" id="id_jabatan" name="id_jabatan">
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatanList as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" {{ request('id_jabatan') == $jabatan->id_jabatan ? 'selected' : '' }}>
                                {{ $jabatan->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <!-- Tombol Action -->
                 <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter me-2"></i>Filter</button>
                    <a href="{{ route('admin.laporan.riwayat-jabatan') }}" type="reset" class="btn btn-secondary"><i class="fa fa-undo me-2"></i>Reset</a>
                    <button type="button" class="btn btn-danger" onclick="window.open('{{ route('admin.laporan.riwayat-jabatan.pdf') . '?' . http_build_query(request()->all()) }}', '_blank')">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fa fa-file-pdf me-2"></i><span class="button-text">Cetak Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Riwayat Jabatan Pegawai -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Riwayat Jabatan Pegawai</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table-riwayat-jabatan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Jabatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatJabatan as $index => $rj)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $rj->pegawai->gelar_depan }} {{ $rj->pegawai->nama_pegawai }} {{ $rj->pegawai->gelar_belakang }}</td>
                            <td>{{ $rj->jabatan->nama_jabatan }}</td>
                            <td>{{ \Carbon\Carbon::parse($rj->tgl_mulai)->format('d/m/Y') }}</td>
                            <td>{{ $rj->tgl_selesai ? \Carbon\Carbon::parse($rj->tgl_selesai)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-riwayat-jabatan', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: false     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
    
@endsection