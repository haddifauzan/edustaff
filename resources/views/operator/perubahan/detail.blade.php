@extends('operator.layout.master')
@section('title', ' - Detail Pengajuan Perubahan')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('operator.perubahan') }}">Pengajuan Perubahan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan</li>
    </ol>
</nav>
<!-- Card untuk Judul Halaman -->
<div class="card mb-4">
    <h1 class="ps-3 pt-3 pb-1 text-bold">Detail Pengajuan Perubahan Data</h1>
    <p class="ps-3">Berikut adalah detail dari pengajuan perubahan data pegawai.</p>
</div>

<div class="card">
    <div class="card-body">
        <h3>Perubahan yang Diajukan:</h3>
        <ul class="list-group">
            <!-- Loop untuk menampilkan perubahan kolom -->
            @foreach(json_decode($pengajuan->kolom_diubah, true) as $kolom => $value)
            <li class="list-group-item">
                <strong>{{ ucwords(str_replace('_', ' ', $kolom)) }}:</strong><br>
                @if(in_array($kolom, ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran']))
                @if($pengajuan->status_konfirmasi == 'disetujui')
                <div class="col-md-6">
                    <p>Foto Baru</p>
                    <a href="{{ asset($value['new']) }}" data-fancybox="foto-baru">
                        <img src="{{ asset($value['new']) }}" alt="Foto Baru" class="img-thumbnail" width="150" />
                    </a>
                </div>
            @elseif($pengajuan->status_konfirmasi == 'ditolak')
                <div class="col-md-6">
                    <p>Foto Lama</p>
                    <a href="{{ asset($value['old']) }}" data-fancybox="foto-lama">
                        <img src="{{ asset($value['old']) }}" alt="Foto Lama" class="img-thumbnail" width="150"/>
                    </a>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <p>Foto Lama</p>
                        <a href="{{ asset($value['old']) }}" data-fancybox="foto-lama">
                            <img src="{{ asset($value['old']) }}" alt="Foto Lama" class="img-thumbnail" width="150"/>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <p>Foto Baru</p>
                        <a href="{{ asset($value['new']) }}" data-fancybox="foto-baru">
                            <img src="{{ asset($value['new']) }}" alt="Foto Baru" class="img-thumbnail" width="150" />
                        </a>
                    </div>
                </div>
            @endif
                @else
                    <div class="d-flex">
                        <div class="pe-3">
                            <strong>Data Lama:</strong>
                            <p>{{ $value['old'] }}</p>
                        </div>
                        <div class="ms-5">
                            <strong>Data Baru:</strong>
                            <p>{{ $value['new'] }}</p>
                        </div>
                    </div>
                @endif
            </li>
            @endforeach
        </ul>

        <hr>
        <h3 class="mt-4">Detail Pengajuan:</h3>
        <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->locale('id_ID')->isoFormat('D MMMM YYYY || HH:mm:ss') }}</p>
        <p><strong>Status:</strong>
            @if($pengajuan->status_konfirmasi === 'menunggu')
                <span class="badge bg-warning">Menunggu</span>
            @elseif($pengajuan->status_konfirmasi === 'disetujui')
                <span class="badge bg-success">Disetujui</span>
            @else
                <span class="badge bg-danger">Ditolak</span>
            @endif
        </p>
        <hr>
        <h3 class="mt-4">Operator Yang Merespon</h3>
        <p class="mt-2"><strong>Nama Operator:</strong> {{ $pengajuan->operator->nama_user ?? '-' }}</p>
                <h6>Respon Operator:</h6>
                <textarea class="form-control" rows="3" readonly style="background: white;">{{ $pengajuan->pesan_operator ?? 'Belum ada respon dari operator.' }}</textarea>

        <div class="d-flex mt-4">
            @if($pengajuan->status_konfirmasi === 'menunggu')
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#setujuPerubahanModal"><i class="fas fa-check me-2"></i> Setuju</button>
            </div>
            <div>
                <button type="button" class="btn btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#tolakPerubahanModal"><i class="fas fa-times me-2"></i> Tolak</button>
            </div>
            @endif
            <a href="{{route('operator.perubahan')}}" class="btn btn-secondary ms-3"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
        </div>
    </div>
</div>

<!-- Modal Setuju -->
<div class="modal fade" id="setujuPerubahanModal" tabindex="-1" aria-labelledby="setujuPerubahanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.perubahan.setuju', $pengajuan->id_konfirmasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="setujuPerubahanModalLabel">Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pesan_operator_setuju" class="form-label">Respon Operator</label>
                        <textarea class="form-control" id="pesan_operator_setuju" name="pesan_operator" rows="3" required></textarea>
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
<div class="modal fade" id="tolakPerubahanModal" tabindex="-1" aria-labelledby="tolakPerubahanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('operator.perubahan.tolak', $pengajuan->id_konfirmasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakPerubahanModalLabel">Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pesan_operator_tolak" class="form-label">Respon Operator</label>
                        <textarea class="form-control" id="pesan_operator_tolak" name="pesan_operator" rows="3" required></textarea>
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

@include('operator.layout.sweetalert')
@endsection

