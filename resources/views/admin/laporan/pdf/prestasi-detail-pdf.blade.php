<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Prestasi Pegawai</title>
    <style>
        body {
            font-family: 'Times New Roman', serif; 
            font-size: 12pt; 
            color: #333;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px; 
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24pt;
            font-weight: bold;
            color: #004085;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 14pt;
            color: #555;
        }

        main {
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .content strong {
            color: #004085;
        }

        .field {
            margin: 8px 0; 
        }

        .field-label {
            font-weight: bold;
            width: 120px; 
        }

        .field-value {
            color: #555;
        }

        img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        .no-image {
            color: #888;
            font-style: italic;
        }

        footer {
            text-align: center;
            color: #888;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Detail Prestasi Pegawai</h1>
            <h2 class="subtitle">Informasi mengenai prestasi yang dicapai oleh pegawai</h2>
        </header>

        <main>
            <div class="content">
                <h3>{{ $prestasi->pegawai->nama_pegawai }}</h3>

                <div class="field">
                    <span class="field-label"><strong>Nama Prestasi:</strong></span> 
                    <span class="field-value">{{ $prestasi->nama_prestasi }}</span>
                </div>
                <div class="field">
                    <span class="field-label"><strong>Deskripsi:</strong></span> 
                    <span class="field-value">{{ $prestasi->deskripsi_prestasi }}</span>
                </div>
                <div class="field">
                    <span class="field-label"><strong>Tanggal Dicapai:</strong></span> 
                    <span class="field-value">{{ \Carbon\Carbon::parse($prestasi->tgl_dicapai)->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <div class="field">
                    <span class="field-label"><strong>Status:</strong></span> 
                    <span class="field-value">{{ ucfirst($prestasi->status) }}</span>
                </div>
            </div>

            <div class="content">
                <strong>Foto Sertifikat:</strong><br>
                @if($prestasi->foto_sertifikat)
                    <img src="{{ public_path('prestasi/' . $prestasi->foto_sertifikat) }}" alt="Foto Sertifikat">
                @else
                    <p class="no-image">Tidak ada sertifikat yang tersedia</p>
                @endif
            </div>
        </main>

        <footer>
            Dicetak pada {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY HH:mm') }}
        </footer>
    </div>
</body>
</html>