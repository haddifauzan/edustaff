@extends('pegawai.layout.master')
@section('title', ' - Pengajuan Pensiun/Keluar')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4 p-2">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Pengajuan Pensiun/Keluar Pegawai</h1>
        <p class="ps-3">Form dan data pengajuan pensiun/keluar pegawai.</p>
    </div>

    <!-- Card untuk Menampilkan Data Pegawai -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                @if($pengajuans->where('status_pengajuan', 'menunggu' || 'disetujui')->count() > 0)
                    <button type="button" class="btn btn-primary" onclick="alert('Anda memiliki pengajuan yang masih menunggu atau persetujuan sudah disetujui. Jika masih menunggu, Silahkan tunggu persetujuan dari admin atau batalkan pengajuan yang masih menunggu.'); return false;">
                        <i class="fas fa-plus me-2"></i> Tambah Pengajuan
                    </button>
                @else
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPengajuan">
                        <i class="fas fa-plus me-2"></i> Tambah Pengajuan
                    </button>
                @endif

            </div>
            <div class="table-responsive">
                <table id="table-pengajuan" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Pengajuan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Alasan</th>
                            <th>Pengaju</th>
                            <th>Status</th>
                            <th>Tanggal Berlaku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuans as $pengajuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $pengajuan->jenis_pengajuan }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->format('d/m/Y H:i') }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($pengajuan->alasan, 30) }}</td>
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
                                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_berlaku)->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalShow{{ $pengajuan->id_pensiun_keluar }}"><i class="bx bx-show"></i></button>
                                        @if($pengajuan->status_pengajuan === 'menunggu')
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pengajuan->id_pensiun_keluar }}"><i class="bx bx-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalBatal{{ $pengajuan->id_pensiun_keluar }}"><i class="bx bx-block"></i></button>
                                        @endif
                                    </div>
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
                <form action="{{ route('pegawai.pengajuan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPengajuanLabel">Tambah Pengajuan Pensiun/Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                            <select class="form-select" id="jenis_pengajuan" name="jenis_pengajuan" required>
                                <option value="pensiun">Pensiun</option>
                                <option value="keluar">Keluar</option>
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

    <!-- Modal Edit Pengajuan -->
    @foreach($pengajuans as $pengajuan)
    <div class="modal fade" id="modalEdit{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="modalEditPengajuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pegawai.pengajuan.update', $pengajuan->id_pensiun_keluar) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPengajuanLabel">Edit Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                            <select class="form-select" id="jenis_pengajuan" name="jenis_pengajuan" required>
                                <option value="pensiun" {{ $pengajuan->jenis_pengajuan === 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                                <option value="keluar" {{ $pengajuan->jenis_pengajuan === 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Pengajuan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3" required>{{ $pengajuan->alasan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku</label>
                            <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" value="{{ $pengajuan->tgl_berlaku }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control" id="keterangan_tambahan" name="keterangan_tambahan" rows="3">{{ $pengajuan->keterangan_tambahan }}</textarea>
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

    <!-- Modal Batal Pengajuan -->
    @foreach($pengajuans as $pengajuan)
    <div class="modal fade" id="modalBatal{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="modalBatalPengajuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pegawai.pengajuan.destroy', $pengajuan->id_pensiun_keluar) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBatalPengajuanLabel">Batalkan Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin membatalkan pengajuan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Batalkan Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Detail Pengajuan -->
    @foreach($pengajuans as $pengajuan)
    <div class="modal fade" id="modalShow{{ $pengajuan->id_pensiun_keluar }}" tabindex="-1" aria-labelledby="modalShowPengajuanLabel" aria-hidden="true">
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
    @endforeach


    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-pengajuan', {
                searching: false,
                paging: true,
                info: true,
                ordering: true
            });
        });
    </script>

{{-- SweetAlert --}}
@include('pegawai.layout.sweetalert')
@endsection
