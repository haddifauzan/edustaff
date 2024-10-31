<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Jabatan Pegawai</title>
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
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
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

    <!-- KOP Surat -->
    <div class="kop-surat">
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>

    <h3 style="text-align: center;">Laporan Riwayat Jabatan Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Nama Jabatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatJabatan as $index => $rj)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rj->pegawai->gelar_depan }} {{ $rj->pegawai->nama_pegawai }} {{ $rj->pegawai->gelar_belakang }}</td>
                    <td>{{ $rj->jabatan->nama_jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($rj->tgl_mulai)->format('d/m/Y') }}</td>
                    <td>{{ $rj->tgl_selesai ? \Carbon\Carbon::parse($rj->tgl_selesai)->format('d/m/Y') : '-' }}</td>
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
