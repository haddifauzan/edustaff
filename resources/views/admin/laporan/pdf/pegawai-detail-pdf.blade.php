<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - {{ $pegawai->nama_pegawai }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 10px; }
        .content { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; table-layout: auto; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }

        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px solid black;
            padding-bottom: 2px;
        }
        .kop-surat h1 { font-size: 18px; margin: 0; }
        .kop-surat h2 { font-size: 16px; margin: 0; }
        .kop-surat h3 { font-size: 12px; margin: 0; }
        .kop-surat p { font-size: 10px; margin: 0; }
    </style>
</head>
<body>
    <!-- KOP Surat -->
    <div class="kop-surat">
        <h1>Laporan Data Pegawai</h1>
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>
    <div class="header text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('foto_profil/' . $pegawai->foto_pegawai))) }}" alt="Foto Pegawai" width="150">
        <h1>Detail Pegawai</h1>
        <h2>{{ $pegawai->gelar_depan . ' ' . $pegawai->nama_pegawai . ' ' . $pegawai->gelar_belakang }}</h2>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>NIK</th>
                <td>{{ $pegawai->nik ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $pegawai->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td>{{ $pegawai->no_tlp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $pegawai->tempat_lahir }}, {{ $pegawai->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $pegawai->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $pegawai->agama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status Pernikahan</th>
                <td>{{ $pegawai->status_pernikahan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status Kepegawaian</th>
                <td>{{ $pegawai->status_kepegawaian }}</td>
            </tr>
            <tr>
                <th>Pangkat / Golongan</th>
                <td>{{ $pegawai->pangkat ?? '-' }} / {{ $pegawai->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. SK Pengangkatan</th>
                <td>{{ $pegawai->no_sk_pengangkatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengangkatan</th>
                <td>{{ $pegawai->tgl_pengangkatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $pegawai->nip ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pendidikan Terakhir</th>
                <td>{{ $pegawai->pendidikan_terakhir ?? '-' }} ({{ $pegawai->tahun_lulus ?? '-' }})</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h3>Data Tambahan</h3>
        @if($pegawai->tugasTambahan->count() > 0 || $pegawai->mapels->count() > 0 || $pegawai->walikelas->count() > 0 || $pegawai->kepalaJurusan->count() > 0)
            @if($pegawai->tugasTambahan->count() > 0)
                <h4>Tugas Tambahan:</h4>
                <ul>
                    @foreach($pegawai->tugasTambahan as $tugas)
                        <li>{{ $tugas->nama_tugas }}</li>
                    @endforeach
                </ul>
            @endif
            @if($pegawai->mapels->count() > 0)
                <h4>Guru Mata Pelajaran:</h4>
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
            @endif
            @if($pegawai->walikelas->count() > 0)
                <h4>Walikelas:</h4>
                <ul>
                    @foreach($pegawai->walikelas as $walikelas)
                        <li>{{ $walikelas->nama_kelas }}</li>
                    @endforeach
                </ul>
            @endif
            @if($pegawai->kepalaJurusan->count() > 0)
                <h4>Kepala Jurusan:</h4>
                <ul>
                    @foreach($pegawai->kepalaJurusan as $kepalaJurusan)
                        <li>{{ $kepalaJurusan->nama_jurusan }}</li>
                    @endforeach
                </ul>
            @endif
        @else
            <p>Tidak Ada Data</p>
        @endif
    </div>

    <div class="content">
        <h3>Riwayat Jabatan</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawai->riwayatJabatan as $rj)
                    <tr>
                        <td>{{ $rj->jabatan->nama_jabatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($rj->tgl_mulai)->format('d/m/Y') }}</td>
                        <td>{{ $rj->tgl_selesai ? \Carbon\Carbon::parse($rj->tgl_selesai)->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
