<!-- resources/views/admin/pegawai/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai - {{ $pegawai->nama_pegawai }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
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