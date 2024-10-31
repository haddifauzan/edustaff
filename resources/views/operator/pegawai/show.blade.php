@extends('operator.layout.master')
@section('title', ' - Operator Detail Pegawai')

@section('content')
<div class="mt-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 text-white">{{ $pegawai->gelar_depan . ' ' . $pegawai->nama_pegawai . ' ' . $pegawai->gelar_belakang }}</h2>
                    <div>
                        <a href="{{ route('operator.pegawai.edit', $pegawai->id_pegawai) }}" class="btn btn-light border-warning"><i class="bx bx-pencil me-2"></i> Edit</a>
                        <a href="{{ route('operator.pegawai') }}" class="btn btn-light border-primary"><i class="bx bx-arrow-back me-2"></i> Kembali</a>
                    </div>
                </div>

                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-3 mb-4 pt-3">
                            @if($pegawai->foto_pegawai)
                                <img src="{{ asset('foto_profil'.'/'.$pegawai->foto_pegawai) }}" alt="Foto Pegawai" class="img-thumbnail rounded-circle shadow" width="200">
                            @else
                                <img src="{{ asset('images/foto_profil/default.png') }}" alt="Foto Pegawai" class="img-thumbnail rounded-circle shadow" width="200"> 
                            @endif
                        </div>

                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th scope="row" width="200">NIK</th>
                                            <td>{{ $pegawai->nik ? $pegawai->nik : '-' }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th scope="row" width="200">Email</th>
                                            <td>{{ $pegawai->email ? $pegawai->email : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">No. Telepon</th>
                                            <td>{{ $pegawai->no_tlp ? $pegawai->no_tlp : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Jenis Kelamin</th>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tempat, Tanggal Lahir</th>
                                            <td>{{ $pegawai->tempat_lahir }}, {{ $pegawai->tanggal_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Alamat</th>
                                            <td>{{ $pegawai->alamat ? $pegawai->alamat : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Agama</th>
                                            <td>{{ $pegawai->agama ? $pegawai->agama : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status Pernikahan</th>
                                            <td>{{ $pegawai->status_pernikahan ? $pegawai->status_pernikahan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status Kepegawaian</th>
                                            <td>
                                                <span class="badge {{ $pegawai->status_kepegawaian == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $pegawai->status_kepegawaian }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Pangkat / Golongan</th>
                                            <td>{{ $pegawai->pangkat ? $pegawai->pangkat : '-' }} / {{ $pegawai->golongan ? $pegawai->golongan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">No. SK Pengangkatan</th>
                                            <td>{{ $pegawai->no_sk_pengangkatan ? $pegawai->no_sk_pengangkatan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tanggal Pengangkatan</th>
                                            <td>{{ $pegawai->tgl_pengangkatan ? $pegawai->tgl_pengangkatan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">NIP</th>
                                            <td>{{ $pegawai->nip ? $pegawai->nip : '-' }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th scope="row">Pendidikan Terakhir</th>
                                            <td>{{ $pegawai->pendidikan_terakhir ? $pegawai->pendidikan_terakhir : '-' }} ({{ $pegawai->tahun_lulus ? $pegawai->tahun_lulus : '-' }})</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Gelar Depan</th>
                                            <td>{{ $pegawai->gelar_depan ? $pegawai->gelar_depan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Gelar Belakang</th>
                                            <td>{{ $pegawai->gelar_belakang ? $pegawai->gelar_belakang : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status Pegawai</th>
                                            <td>
                                                <span class="badge {{ $pegawai->status_pegawai == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $pegawai->status_pegawai }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Jabatan</th>
                                            <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tanggal Mulai</th>
                                            <td>{{ $pegawai->riwayatJabatan->last() ? \Carbon\Carbon::parse($pegawai->riwayatJabatan->last()->tgl_mulai)->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tanggal Selesai</th>
                                            <td>{{ $pegawai->riwayatJabatan->last() ? \Carbon\Carbon::parse($pegawai->riwayatJabatan->last()->tgl_selesai)->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Lama Jabatan</th>
                                            <td>
                                                @php
                                                    $riwayatJabatan = $pegawai->riwayatJabatan->last();
                                                    if ($riwayatJabatan) {
                                                        $mulai = \Carbon\Carbon::parse($riwayatJabatan->tgl_mulai);
                                                        $selesai = \Carbon\Carbon::parse($riwayatJabatan->tgl_selesai ?? now());
                                                        $diff = $mulai->diffInDays($selesai);
                                                        $years = floor($diff / 365);
                                                        $months = floor(($diff % 365) / 30);
                                                        $days = $diff % 30;
                                                    } else {
                                                        $years = 0;
                                                        $months = 0;
                                                        $days = 0;
                                                    }
                                                @endphp
                                                @if($years > 0)
                                                    {{ $years }} tahun
                                                @endif
                                                @if($months > 0)
                                                    {{ $months }} bulan
                                                @endif
                                                @if($days > 0)
                                                    {{ $days }} hari
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Riwayat Jabatan</th>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#riwayatJabatanModal">
                                                    <i class="bx bx-box me-2"></i> Lihat Riwayat Jabatan
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3 class="text-center my-3"><strong>Data Tambahan</strong></h3>
                    <div class="row">
                        @if(isset($pegawai->tugasTambahan) && $pegawai->tugasTambahan->count() > 0 || isset($pegawai->mapels) && $pegawai->mapels->count() > 0 || isset($pegawai->walikelas) && $pegawai->walikelas->count() > 0 || isset($pegawai->kepalaJurusan) && $pegawai->kepalaJurusan->count() > 0)
                            @if(isset($pegawai->tugasTambahan) && $pegawai->tugasTambahan->count() > 0)
                                <div class="col-md-3 text-center mb-3">
                                    <p><strong>Tugas Tambahan:</strong></p>
                                    <ul>
                                        @foreach($pegawai->tugasTambahan as $tugas)
                                            <li>{{ $tugas->nama_tugas }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(isset($pegawai->mapels) && $pegawai->mapels->count() > 0)
                                <div class="col-md-3 text-center mb-3">
                                    <p><strong>Guru Mata Pelajaran:</strong></p>
                                    <ul>
                                        @foreach($pegawai->mapels as $guruMapel)
                                            @if($guruMapel->mapelKelas->count() > 0)
                                                <li>
                                                    {{ $guruMapel->nama_pelajaran }} ({{ $guruMapel->mapelKelas->pluck('kelas.nama_kelas')->implode(', ') }})
                                                </li>
                                            @else
                                                <li>-</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(isset($pegawai->walikelas) && $pegawai->walikelas->count() > 0)
                                <div class="col-md-3 text-center mb-3">
                                    <p><strong>Walikelas:</strong></p>
                                    <ul>
                                        @foreach($pegawai->walikelas as $walikelas)
                                            <li>{{ $walikelas->nama_kelas }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(isset($pegawai->kepalaJurusan) && $pegawai->kepalaJurusan->count() > 0)
                                <div class="col-md-3 text-center mb-3">
                                    <p><strong>Kepala Jurusan:</strong></p>
                                    <ul>
                                        @foreach($pegawai->kepalaJurusan as $kepalaJurusan)
                                            <li>{{ $kepalaJurusan->nama_jurusan }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @else
                            <p>Tidak Ada Data</p>
                        @endif
                    </div>
                    
                    <hr>
                    <h3 class="my-4 text-center fw-bold">Dokumen Pegawai</h3>
                    <div class="row">
                        @if($pegawai->foto_ijazah)
                            <div class="col-md-3 text-center mb-3">
                                <p><strong>Foto Ijazah:</strong></p>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imageModal" data-title="Foto Ijazah" data-image="{{ asset($pegawai->foto_ijazah) }}">
                                    <i class="bx bx-image-alt me-2"></i> Lihat Gambar
                                </button>
                            </div>
                        @endif
                        @if($pegawai->foto_ktp)
                            <div class="col-md-3 text-center mb-3">
                                <p><strong>Foto KTP:</strong></p>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imageModal" data-title="Foto KTP" data-image="{{ asset($pegawai->foto_ktp) }}">
                                    <i class="bx bx-image-alt me-2"></i> Lihat Gambar
                                </button>
                            </div>
                        @endif
                        @if($pegawai->foto_kk)
                            <div class="col-md-3 text-center mb-3">
                                <p><strong>Foto Kartu Keluarga:</strong></p>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imageModal" data-title="Foto KK" data-image="{{ asset($pegawai->foto_kk) }}">
                                    <i class="bx bx-image-alt me-2"></i> Lihat Gambar
                                </button>
                            </div>
                        @endif
                        @if($pegawai->foto_akte_kelahiran)
                            <div class="col-md-3 text-center mb-3">
                                <p><strong>Foto Akte Kelahiran:</strong></p>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imageModal" data-title="Foto Akte Kelahiran" data-image="{{ asset($pegawai->foto_akte_kelahiran) }}">
                                    <i class="bx bx-image-alt me-2"></i> Lihat Gambar
                                </button>
                            </div>
                        @endif
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">Judul Gambar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <img src="" id="modalImage" alt="Gambar" class="img-fluid">
        </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan riwayat jabatan -->
<div class="modal fade" id="riwayatJabatanModal" tabindex="-1" aria-labelledby="riwayatJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatJabatanModalLabel">Riwayat Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pegawai->riwayatJabatan as $rj)
                                <tr>
                                    <td>{{ $rj->jabatan->nama_jabatan ?? '-' }}</td>
                                    <td>{{ $rj->tgl_mulai ? \Carbon\Carbon::parse($rj->tgl_mulai)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $rj->tgl_selesai ? \Carbon\Carbon::parse($rj->tgl_selesai)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <!-- Tombol untuk hapus riwayat jabatan -->
                                        <form action="{{ route('operator.jabatan.deleteRiwayat', $rj->id_riwayat_jabatan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('operator.jabatan.deleteAllRiwayat', $pegawai->id_pegawai) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua riwayat?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Semua</button>
                </form>
                <a href="{{ route('operator.jabatan.pegawai') }}" class="btn btn-primary">Atur Jabatan</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            // Button yang diklik
            var button = event.relatedTarget;
            var imageTitle = button.getAttribute('data-title');
            var imageUrl = button.getAttribute('data-image');

            // Update modal title dan image
            var modalTitle = imageModal.querySelector('.modal-title');
            var modalImage = imageModal.querySelector('#modalImage');
            
            modalTitle.textContent = imageTitle;
            modalImage.src = imageUrl;
        });
    });

</script>
  
@endsection