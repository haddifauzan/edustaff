<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .signature {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double black;
            padding-bottom: 10px;
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
        .kop-surat p {
            font-size: 12px;
            margin: 0;
        }
        .header {
            text-align: left;
            margin-bottom: 30px;
        }
        .header h5 {
            font-size: 16px;
            margin: 5px 0;
        }
        .header h3, .header h4 {
            font-size: 14px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

    <!-- PDF Header -->
    <div class="header">
        @php
            // Daftar filter yang akan ditampilkan
            $filters = [
                'Pencarian' => $search ?? null,
                'Tahun Ajaran' => $tahunAjaran ?? null,
                'Jabatan' => $jabatan ?? null,
                'Status Pegawai' => $statusPegawai ?? null,
                'Agama' => $agama ?? null,
                'Status Pernikahan' => $statusPernikahan ?? null,
                'Status Kepegawaian' => $statusKepegawaian ?? null,
                'Jenis Kelamin' => isset($jenisKelamin) ? ($jenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan') : null,
            ];

            // Filter array to remove empty values
            $filtered = array_filter($filters);
        @endphp

        @if (count($filtered) == 0)
            <h5>Data Semua Pegawai</h5>
        @else
            <h5>Filter Laporan Data Pegawai</h5>
            <ul>
                @foreach ($filtered as $label => $value)
                    <li>{{ $label }}: {{ $value }}</li>
                @endforeach
            </ul>
        @endif
    </div>



    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Jabatan</th>
                <th>Status Kepegawaian</th>
            </tr>
        </thead>
        <tbody>
            @if($pegawai->isEmpty())
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pegawai.</td>
                </tr>
            @else
                @foreach($pegawai as $index => $pgw)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pgw->gelar_depan }} {{ $pgw->nama_pegawai }} {{ $pgw->gelar_belakang }}</td>
                    <td>{{ $pgw->email }}</td>
                    <td>{{ $pgw->no_tlp }}</td>
                    <td>{{ $pgw->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $pgw->status_kepegawaian }}</td>
                </tr>
                @endforeach
            @endif
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
