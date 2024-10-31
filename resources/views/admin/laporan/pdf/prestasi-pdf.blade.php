<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prestasi Pegawai</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 12px;}
        th { background-color: #f2f2f2; }
        .signature {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
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
    </style>
</head>
<body>
    <!-- KOP Surat -->
    <div class="kop-surat">
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>
    <div class="title">Laporan Data Prestasi Pegawai</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prestasi</th>
                <th>Deskripsi Prestasi</th>
                <th>Tanggal Dicapai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestasi as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_prestasi }}</td>
                <td>{{ $p->deskripsi_prestasi }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_dicapai)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($p->status) }}</td>
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

