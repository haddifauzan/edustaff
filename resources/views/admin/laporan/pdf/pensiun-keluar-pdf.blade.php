<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pensiun atau Keluar Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            font-size: 14px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 5px;
        }
        .kop-surat h1 {
            font-size: 24px;
            margin: 0;
        }
        .kop-surat h2 {
            font-size: 18px;
            margin: 0;
        }
        .kop-surat h3 {
            font-size: 14px;
            margin: 0;
        }
        .header {
            text-align: left;
            margin-bottom: 30px;
        }
        .signature {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
        <hr>
    </div>
    <h3 style="text-align: center;">Laporan Pensiun atau Keluar Pegawai</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
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
            @foreach($pensiunKeluar as $index => $pk)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pk->pegawai->gelar_depan }} {{ $pk->pegawai->nama_pegawai }} {{ $pk->pegawai->gelar_belakang }}</td>
                <td>{{ $pk->jenis_pengajuan }}</td>
                <td>{{ $pk->status_pengajuan }}</td>
                <td>{{ $pk->pengaju }}</td>
                <td>{{ \Carbon\Carbon::parse($pk->created_at)->format('d/m/Y') }}</td>
                <td>{{ $pk->tgl_berlaku ? \Carbon\Carbon::parse($pk->tgl_berlaku)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Kota Cimahi, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <p>Kepala Sekolah</p>
        <p><strong>{{ $kepalaSekolah ? $kepalaSekolah->gelar_depan . ' ' . $kepalaSekolah->nama_pegawai . ' ' . $kepalaSekolah->gelar_belakang : 'Nama Kepala Sekolah' }}</strong></p>
        <br><br>
        <p>(__________________)</p>
        <p>NIP. {{ $kepalaSekolah ? $kepalaSekolah->nip : '123456789' }}</p>
    </div>
</body>
</html>
