<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tugas Tambahan Pegawai</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .kop-surat { text-align: center; margin-bottom: 20px; }
        .kop-surat h3, .kop-surat h4 { margin: 0; }
        .kop-surat p { margin: 0; font-size: 10px; }
        hr { border: 1px solid #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
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

    <h2 style="text-align: center;">Laporan Tugas Tambahan Pegawai</h2>

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Nama Tugas Tambahan</th>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tugasTambahan as $index => $tt)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tt->pegawai->gelar_depan }} {{ $tt->pegawai->nama_pegawai }} {{ $tt->pegawai->gelar_belakang }}</td>
                <td>{{ $tt->nama_tugas }}</td>
                <td>{{ $tt->deskripsi_tugas }}</td>
                <td>{{ \Carbon\Carbon::parse($tt->tgl_mulai)->format('d/m/Y') }}</td>
                <td>{{ $tt->tgl_selesai ? \Carbon\Carbon::parse($tt->tgl_selesai)->format('d/m/Y') : '-' }}</td>
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
