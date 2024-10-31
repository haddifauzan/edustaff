@extends('operator.layout.master')
@section('title', ' - Operator Pengajuan')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Pengajuan Pensiun atau Keluar Pegawai</h1>
        <p class="ps-3">Pengelolaan pengajuan pensiun atau keluar pegawai.</p>
    </div>

    <!-- Card untuk Filter Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <form action="{{ route('operator.pengajuan') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Pegawai..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('operator.pengajuan') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
                <div class="col-md-2 mt-1 ms-auto">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahPengajuan"><i class="fas fa-plus me-2"></i> Tambah</button>
                </div>
            </div>            
        </div>
    </div>

    <!-- Table Pengajuan -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pengajuan" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis</th>
                            <th>Pengaju</th>
                            <th>Status</th>
                            <th>Waktu Pengajuan</th>
                            <th>Tanggal Berlaku</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuans as $pengajuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengajuan->pegawai->nama_pegawai ?? '-' }}</td>
                                <td class="text-capitalize">{{ $pengajuan->jenis_pengajuan }}</td>
                                <td class="text-capitalize">{{ $pengajuan->pengaju }}</td>
                                <td>
                                    @if($pengajuan->status_pengajuan === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pengajuan->status_pengajuan === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->format('d/m/Y || H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->tgl_berlaku)->format('d/m/Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pengajuan->id_pensiun_keluar }}"><i class="fas fa-eye me-2"></i> Cek</button>
                                </td>
                                <td>
                                    @if($pengajuan->status_pengajuan === 'menunggu')
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#setujuPengajuan{{ $pengajuan->id_pensiun_keluar }}"><i class="fas fa-check me-2"></i> Setuju</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakPengajuan{{ $pengajuan->id_pensiun_keluar }}"><i class="fas fa-times me-2"></i> Tolak</button>
                                        </div>
                                    @else
                                        <p class="text-center">-</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengajuan -->
    <div class="modal fade" id="modalTambahPengajuan" tabindex="-1" aria-labelledby="modalTambahPengajuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('operator.pengajuan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPengajuanLabel">Tambah Pengajuan Pensiun/Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pegawai_id" class="form-label">Pegawai Yang Diajukan</label>
                            <select class="form-select" id="pegawai_id" name="id_pegawai" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nik }} || {{ $pegawai->nama_pegawai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                            <select class="form-select" id="jenis_pengajuan" name="jenis_pengajuan" required>
                                <option value="pensiun">Pensiun</option>
                                <option value="keluar">Keluar</option>
                                <option value="diberhentikan">Diberhentikan</option>
                                <option value="dipindahkan">Dipindahkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Pengajuan</label> <span class="text-danger">*</span>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku Pensiun/Keluar</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control" id="keterangan_tambahan" name="keterangan_tambahan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengajuan -->
    @foreach($pengajuans as $pengajuan)
        <div class="modal fade" id="detailModal{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalShowPengajuanLabel">Detail Pengajuan Pensiun/Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Tanggal Berlaku -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Berlaku:</label>
                                <p>{{ \Carbon\Carbon::parse($pengajuan->tgl_berlaku)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                            </div>
    
                            <!-- Jenis Pengajuan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Pengajuan:</label>
                                <p>{{ ucfirst($pengajuan->jenis_pengajuan) }}</p>
                            </div>
                        </div>
    
                        <div class="row">
                            <!-- Status Pengajuan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Pengajuan:</label>
                                <p>
                                    @if($pengajuan->status_pengajuan === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pengajuan->status_pengajuan === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </p>
                            </div>
    
                            <!-- Pengaju -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pengaju:</label>
                                <p class="text-capitalize">{{ $pengajuan->pengaju }}</p>
                            </div>
                        </div>
    
                        <!-- Alasan Pengajuan -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Alasan:</label>
                                <p class="border p-2 rounded">{{ $pengajuan->alasan }}</p>
                            </div>
                        </div>
    
                        <!-- Keterangan Tambahan -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Keterangan Tambahan:</label>
                                <p class="border p-2 rounded">{{ $pengajuan->keterangan_tambahan ?? '-' }}</p>
                            </div>
                        </div>
    
                        <div class="row">
                            <!-- Operator yang Mengurus -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Operator yang Mengurus:</label>
                                <p class="border p-2 rounded">{{ $pengajuan->id_operator ? $pengajuan->operator->nama_user : '-' }}</p>
                            </div>
    
                            <!-- Pegawai Terkait -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pegawai Terkait:</label>
                                <p class="border p-2 rounded">{{ $pengajuan->pegawai->nama_pegawai }}</p>
                            </div>
                        </div>
    
                        <!-- Waktu Pengajuan -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Waktu Pengajuan:</label>
                                <p>{{ \Carbon\Carbon::parse($pengajuan->created_at)->locale('id_ID')->isoFormat('D MMMM YYYY // HH:mm:ss') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Setuju Pengajuan -->
        <div class="modal fade" id="setujuPengajuan{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="setujuPengajuanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="setujuPengajuanLabel">Setujui Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui pengajuan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('operator.pengajuan.approve', $pengajuan->id_pensiun_keluar) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Ya, Setujui</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tolak Pengajuan -->
        <div class="modal fade" id="tolakPengajuan{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="tolakPengajuanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tolakPengajuanLabel">Tolak Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('operator.pengajuan.reject', $pengajuan->id_pensiun_keluar) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-pengajuan', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    {{-- SweetAlert --}}
    @include('operator.layout.sweetalert')
@endsection

