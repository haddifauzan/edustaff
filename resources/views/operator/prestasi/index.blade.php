@extends('operator.layout.master')
@section('title', ' - Operator Prestasi Pegawai')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Pengajuan Prestasi Pegawai</h1>
        <p class="ps-3">Pengelolaan pengajuan prestasi pegawai.</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('operator.prestasi') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Pegawai..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('operator.prestasi') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
            </div>            
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-prestasi" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Prestasi</th>
                            <th>Tanggal Prestasi</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($pengajuanPrestasi->count() === 0)
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pengajuan.</td>
                            </tr>
                        @else
                            @foreach($pengajuanPrestasi as $pengajuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengajuan->pegawai->nama_pegawai ?? '-' }}</td>
                                <td>{{ $pengajuan->nama_prestasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_prestasi)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->locale('id_ID')->isoFormat('D MMMM YYYY || HH:mm:ss') }}</td>
                                <td>
                                    @if($pengajuan->status === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pengajuan->status === 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <div><button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pengajuan->id_prestasi }}"><i class="fas fa-eye"></i> Lihat</button></div>
                                        @if($pengajuan->status === 'menunggu')
                                        <div>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#setujuPerubahan{{ $loop->index }}"><i class="fas fa-check me-2"></i> Setuju</button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakPerubahan{{ $loop->index }}"><i class="fas fa-times me-2"></i> Tolak</button>
                                        </div>
                                        @else
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $loop->index }}">
                                            <i class="fas fa-trash-alt me-2"></i> Hapus
                                        </button>
                                    </div>
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


@foreach($pengajuanPrestasi as $pengajuan)
<!-- Modal Setuju -->
<div class="modal fade" id="setujuPerubahan{{ $loop->index }}" tabindex="-1" aria-labelledby="setujuPerubahanLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.prestasi.setuju', $pengajuan->id_prestasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="setujuPerubahanLabel{{ $loop->index }}">Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menyetujui pengajuan ini?</p>
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
            <form action="{{ route('operator.prestasi.tolak', $pengajuan->id_prestasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakPerubahanLabel{{ $loop->index }}">Tolak Pengajuan Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menolak pengajuan ini?</p>
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

<!-- Modal Detail Prestasi -->
@foreach ($pengajuanPrestasi as $item)
<div class="modal fade" id="detailModal{{ $item->id_prestasi }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id_prestasi }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $item->id_prestasi }}">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Pegawai:</strong> {{ $item->pegawai->nama_pegawai }}</p>
                <p><strong>Nama Prestasi:</strong> {{ $item->nama_prestasi }}</p>
                <p><strong>Deskripsi:</strong> {{ $item->deskripsi_prestasi }}</p>
                <p><strong>Tanggal Dicapai:</strong> {{ \Carbon\Carbon::parse($pengajuan->tanggal_prestasi)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                <p><strong>Status:</strong>
                    @if ($item->status == 'menunggu')
                        <span class="badge bg-warning">{{ $item->status }}</span>
                    @elseif ($item->status == 'diterima')
                        <span class="badge bg-success">{{ $item->status }}</span>
                    @elseif ($item->status == 'ditolak')
                        <span class="badge bg-danger">{{ $item->status }}</span>
                    @endif
                <p><strong>Foto Sertifikat:</strong></p>
                <img src="{{ asset('prestasi/'.$item->foto_sertifikat) }}" alt="Foto Sertifikat" class="img-fluid mt-2" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Hapus -->
@foreach($pengajuanPrestasi as $pengajuan)
<div class="modal fade" id="hapusModal{{ $loop->index }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.prestasi.destroy', $pengajuan->id_prestasi) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel{{ $loop->index }}">Hapus Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus prestasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
            new DataTable('#table-prestasi', {
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
