@extends('admin.layout.master')
@section('title', ' - Laporan Prestasi Pegawai')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Laporan Data Prestasi Pegawai</h1>
        <p class="ps-3">Menampilkan laporan data prestasi pegawai.</p>
    </div>

    <!-- Card untuk filter dan tombol download -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.prestasi') }}" method="GET" class="row g-3">
                <!-- Input Pencarian -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pegawai</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nama, Email, NIP, NIK" value="{{ request('search') }}">
                </div>
                <!-- Input untuk Search Nama Prestasi -->
                <div class="col-md-4">
                    <label for="search_prestasi" class="form-label">Cari Nama Prestasi</label>
                    <input type="text" class="form-control" id="search_prestasi" name="search_prestasi" placeholder="Nama Prestasi" value="{{ request('search_prestasi') }}">
                </div>
                <!-- Select Tahun Ajaran -->
                <div class="col-md-2">
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
                <!-- Select Status -->
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Pilih Status</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    </select>
                </div>
                 <!-- Tombol Action -->
                 <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter me-2"></i>Filter</button>
                    <a href="{{ route('admin.laporan.prestasi') }}" type="reset" class="btn btn-secondary"><i class="fa fa-undo me-2"></i>Reset</a>
                    <button type="button" class="btn btn-danger" onclick="window.open('{{ route('admin.laporan.prestasi.pdf') . '?' . http_build_query(request()->all()) }}', '_blank')">
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
            <h5>Daftar Prestasi Pegawai</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table-prestasi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Prestasi</th>
                            <th>Deskripsi Prestasi</th>
                            <th>Tanggal Dicapai</th>
                            <th>Foto Sertifikat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestasi as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{$p->pegawai->gelar_depan}} {{ $p->pegawai->nama_pegawai }} {{ $p->pegawai->gelar_belakang }}</td>
                            <td>{{ $p->nama_prestasi }}</td>
                            <td>{{ $p->deskripsi_prestasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_dicapai)->format('d/m/Y') }}</td>
                            <td>
                                @if($p->foto_sertifikat)
                                    <a href="{{ asset('prestasi/' . $p->foto_sertifikat) }}" target="_blank">
                                        <img src="{{ asset('prestasi/' . $p->foto_sertifikat) }}" width="100" />
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @switch($p->status)
                                    @case('diterima')
                                        <span class="badge bg-success">Diterima</span>
                                        @break

                                    @case('menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                        @break

                                    @case('ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break

                                    @default
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.laporan.prestasi-detail.pdf', $p->id_prestasi) }}" class="btn btn-sm btn-danger" target="_blank">
                                    <i class="fa fa-print"></i> PDF
                                </a>
                            </td>
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
            new DataTable('#table-prestasi', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: false     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
    
@endsection