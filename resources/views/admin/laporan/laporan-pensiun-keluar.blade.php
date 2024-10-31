@extends('admin.layout.master')
@section('title', ' - Laporan Pensiun Keluar Pegawai')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Laporan Pensiun atau Keluar Pegawai</h1>
        <p class="ps-3">Menampilkan laporan pensiun atau keluar pegawai.</p>
    </div>

    <!-- Card untuk filter dan tombol download -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.pensiun-keluar') }}" method="GET" class="row g-3">
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
                <!-- Select Jenis Pengajuan -->
                <div class="col-md-4">
                    <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                    <select class="form-select" id="jenis_pengajuan" name="jenis_pengajuan">
                        <option value="">Pilih Jenis Pengajuan</option>
                        <option value="Pensiun" {{ request('jenis_pengajuan') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                        <option value="Keluar" {{ request('jenis_pengajuan') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        <option value="Diberhentikan" {{ request('jenis_pengajuan') == 'Diberhentikan' ? 'selected' : '' }}>Diberhentikan</option>
                        <option value="Dipindahkan" {{ request('jenis_pengajuan') == 'Dipindahkan' ? 'selected' : '' }}>Dipindahkan</option>
                    </select>
                </div>

                <!-- Select Status Pengajuan -->
                <div class="col-md-4">
                    <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
                    <select class="form-select" id="status_pengajuan" name="status_pengajuan">
                        <option value="">Pilih Status Pengajuan</option>
                        <option value="Disetujui" {{ request('status_pengajuan') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Menunggu" {{ request('status_pengajuan') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Ditolak" {{ request('status_pengajuan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Select Pengaju -->
                <div class="col-md-4">
                    <label for="pengaju" class="form-label">Pengaju</label>
                    <select class="form-select" id="pengaju" name="pengaju">
                        <option value="">Pilih Pengaju</option>
                        <option value="Pegawai" {{ request('pengaju') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="Operator" {{ request('pengaju') == 'Operator' ? 'selected' : '' }}>Operator</option>
                    </select>
                </div>
                 <!-- Tombol Action -->
                 <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter me-2"></i>Filter</button>
                    <a href="{{ route('admin.laporan.pensiun-keluar') }}" type="reset" class="btn btn-secondary"><i class="fa fa-undo me-2"></i>Reset</a>
                    <button type="button" class="btn btn-danger" onclick="window.open('{{ route('admin.laporan.pensiun-keluar.pdf') . '?' . http_build_query(request()->all()) }}', '_blank')">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fa fa-file-pdf me-2"></i><span class="button-text">Cetak Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Riwayat Pensiun atau Keluar Pegawai -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Pensiun atau Keluar Pegawai</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table-pensiun-keluar">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis Pengajuan</th>
                            <th>Status Pengajuan</th>
                            <th>Pengaju</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Berlaku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pensiunKeluar as $pk)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $pk->pegawai->gelar_depan }} {{ $pk->pegawai->nama_pegawai }} {{ $pk->pegawai->gelar_belakang }}</td>
                            <td>{{ ucwords($pk->jenis_pengajuan) }}</td>
                            <td>
                                @switch($pk->status_pengajuan)
                                    @case('disetujui')
                                        <span class="badge bg-success">{{ ucwords($pk->status_pengajuan) }}</span>
                                        @break

                                    @case('ditolak')
                                        <span class="badge bg-danger">{{ ucwords($pk->status_pengajuan) }}</span>
                                        @break

                                    @default
                                        <span class="badge bg-warning">{{ ucwords($pk->status_pengajuan) }}</span>
                                @endswitch
                            </td>
                            <td>
                                @switch($pk->pengaju)
                                    @case('operator')
                                        <span class="badge bg-info">{{ ucwords($pk->pengaju) }}</span>
                                        @break

                                    @case('pegawai')
                                        <span class="badge bg-primary">{{ ucwords($pk->pengaju) }}</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pk->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $pk->tgl_berlaku ? \Carbon\Carbon::parse($pk->tgl_berlaku)->format('d/m/Y') : '-' }}</td>
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
            new DataTable('#table-pensiun-keluar', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: false     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
@endsection