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
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double black;
            padding-bottom: 10px;
        }

        .kop-surat {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-bottom: 10px;
        }

        .kop-surat img {
            width: 80px;
            height: auto;
            margin-right: 20px;
        }

        .kop-surat div {
            text-align: center;
        }

        .kop-surat h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .kop-surat p {
            font-size: 12px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="kop-surat">
          <img src="{{ asset('assets/img/logo/smkn1cmi_logo.png') }}" alt="Logo Sekolah"> 
          <div>
            <h3 style="font-size: 18px;">SMK NEGERI 1 CIMAHI</h3> 
            <p>l. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</p> 
          </div>
        </div>
        <h2>LAPORAN DATA PEGAWAI</h2> 
      </div>

    <table>
        <thead>
            <tr>
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
                    <td colspan="5" style="text-align: center;">Tidak ada data pegawai.</td>
                </tr>
            @else
                @foreach($pegawai as $pgw)
                <tr>
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

    <div class="signature">
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p>(__________________)</p>
    </div>
</body>
</html>
