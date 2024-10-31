@extends('operator.layout.master')
@section('title', ' - Operator Perubahan Data')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Pengajuan Perubahan Data Pegawai</h1>
        <p class="ps-3">Pengelolaan pengajuan perubahan data pegawai.</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('operator.perubahan') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Pegawai..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('operator.perubahan') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
            </div>            
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pengajuan" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Waktu Perubahan</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($riwayatPengajuan->count() === 0)
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pengajuan.</td>
                            </tr>
                        @else
                            @foreach($riwayatPengajuan as $pengajuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengajuan->pegawai->nama_pegawai ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->locale('id_ID')->isoFormat('D MMMM YYYY || HH:mm:ss') }}</td>
                                <td>
                                    @if($pengajuan->status_konfirmasi === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pengajuan->status_konfirmasi === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('operator.perubahan.detail', $pengajuan->id_konfirmasi) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye me-2"></i> Cek</a></td>   
                                <td>
                                    @if($pengajuan->status_konfirmasi === 'menunggu')
                                    <div class="d-flex">
                                        <div>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#setujuPerubahan{{ $loop->index }}"><i class="fas fa-check me-2"></i> Setuju</button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#tolakPerubahan{{ $loop->index }}"><i class="fas fa-times me-2"></i> Tolak</button>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-center">-</p>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>            
        </div>
    </div>


@foreach($riwayatPengajuan as $pengajuan)
<!-- Modal Setuju -->
<div class="modal fade" id="setujuPerubahan{{ $loop->index }}" tabindex="-1" aria-labelledby="setujuPerubahanLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.perubahan.setuju', $pengajuan->id_konfirmasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="setujuPerubahanLabel{{ $loop->index }}">Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pesan_operator" class="form-label">Respon Operator</label>
                        <textarea class="form-control" id="pesan_operator" name="pesan_operator" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Setujui</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakPerubahan{{ $loop->index }}" tabindex="-1" aria-labelledby="tolakPerubahanLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.perubahan.tolak', $pengajuan->id_konfirmasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakPerubahanLabel{{ $loop->index }}">Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pesan_operator" class="form-label">Respon Operator</label>
                        <textarea class="form-control" id="pesan_operator" name="pesan_operator" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
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
