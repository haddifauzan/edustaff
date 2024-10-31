@extends('admin.layout.master')
@section('title', ' - Laporan Data Pegawai')

@section('content')
    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Laporan Data Pegawai</h1>
        <p class="ps-3">Menampilkan laporan data pegawai.</p>
    </div>

    <!-- Card untuk filter dan tombol download -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.pegawai') }}" method="GET" class="row g-3">
                <!-- Input Pencarian -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pegawai</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nama, Email, NIP, NIK" value="{{ request('search') }}">
                </div>
    
                <!-- Select Tahun Ajaran -->
                <div class="col-md-4">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <select class="form-select" id="tahun_ajaran" name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @for($tahun = 2020; $tahun <= 2030; $tahun++)
                            <option value="{{ $tahun . '-' . ($tahun + 1) }}" {{ request('tahun_ajaran') == ($tahun . '-' . ($tahun + 1)) ? 'selected' : '' }}>
                                {{ $tahun . '-' . ($tahun + 1) }}
                            </option>
                        @endfor
                    </select>
                </div>
    
                <!-- Select Jabatan -->
                <div class="col-md-4">
                    <label for="id_jabatan" class="form-label">Jabatan</label>
                    <select class="form-select" id="id_jabatan" name="id_jabatan">
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatanList as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" {{ request('id_jabatan') == $jabatan->id_jabatan ? 'selected' : '' }}>
                                {{ $jabatan->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Select Status Pegawai -->
                <div class="col-md-4">
                    <label for="status_pegawai" class="form-label">Status Pegawai</label>
                    <select class="form-select" id="status_pegawai" name="status_pegawai">
                        <option value="">Pilih Status Pegawai</option>
                        <option value="Aktif" {{ request('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ request('status_pegawai') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
    
                <!-- Select Agama -->
                <div class="col-md-4">
                    <label for="agama" class="form-label">Agama</label>
                    <select class="form-select" id="agama" name="agama">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ request('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        <option value="Konghucu" {{ request('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
    
                <!-- Select Status Pernikahan -->
                <div class="col-md-4">
                    <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                    <select class="form-select" id="status_pernikahan" name="status_pernikahan">
                        <option value="">Pilih Status Pernikahan</option>
                        <option value="Menikah" {{ request('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Belum Menikah" {{ request('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Cerai" {{ request('status_pernikahan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                </div>
    
                <!-- Select Status Kepegawaian -->
                <div class="col-md-4">
                    <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                    <select class="form-select" id="status_kepegawaian" name="status_kepegawaian">
                        <option value="">Pilih Status Kepegawaian</option>
                        <option value="ASN" {{ request('status_kepegawaian') == 'ASN' ? 'selected' : '' }}>ASN</option>
                        <option value="Non-ASN" {{ request('status_kepegawaian') == 'Non-ASN' ? 'selected' : '' }}>Non-ASN</option>
                        <option value="Honorer" {{ request('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    </select>
                </div>
    
                <!-- Select Jenis Kelamin -->
                <div class="col-md-4">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
    
                <!-- Tombol Action -->
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter me-2"></i>Filter</button>
                    <a href="{{ route('admin.laporan.pegawai') }}" type="reset" class="btn btn-secondary"><i class="fa fa-undo me-2"></i>Reset</a>
                    <button type="button" class="btn btn-danger" onclick="window.open('{{ route('admin.laporan.pegawai.pdf') . '?' . http_build_query(request()->all()) }}', '_blank')">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fa fa-file-pdf me-2"></i><span class="button-text">Cetak Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card untuk menampilkan table pegawai -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Pegawai</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table-laporan-pegawai">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Jabatan</th>
                            <th>Status Kepegawaian</th>
                            <!-- Cek apakah filter 'tahun_ajaran' aktif -->
                            @if(isset($activeFilters['tahun_ajaran']))
                                <th>Tahun Ajaran</th>
                            @endif
                            <!-- Cek apakah filter 'agama' aktif -->
                            @if(isset($activeFilters['agama']))
                                <th>Agama</th>
                            @endif
                            <!-- Cek apakah filter 'jenis_kelamin' aktif -->
                            @if(isset($activeFilters['jenis_kelamin']))
                                <th>Jenis Kelamin</th>
                            @endif
                            <!-- Cek apakah filter 'status_pernikahan' aktif -->
                            @if(isset($activeFilters['status_pernikahan']))
                                <th>Status Pernikahan</th>
                            @endif
                            <!-- Cek apakah filter 'status_pegawai' aktif -->   
                            @if(isset($activeFilters['status_pegawai']))
                                <th>Status Pegawai</th>
                            @endif
                            <!-- Cek apakah filter 'status_kepegawaian' aktif -->
                            @if(isset($activeFilters['status_kepegawaian']))
                                <th>Status Kepegawaian</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $index => $pgw)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pgw->gelar_depan }} {{ $pgw->nama_pegawai }} {{ $pgw->gelar_belakang }}</td>
                            <td>{{ $pgw->email }}</td>
                            <td>{{ $pgw->no_tlp }}</td>
                            <td>{{ $pgw->jabatan->nama_jabatan ?? '-' }}</td>
                            <td>{{ $pgw->status_kepegawaian }}</td>
                            <!-- Jika filter 'tahun_ajaran' aktif -->
                            @if(isset($activeFilters['tahun_ajaran']))
                                <td>{{ \Carbon\Carbon::parse($pgw->created_at)->format('Y') . '-' . (\Carbon\Carbon::parse($pgw->created_at)->addYear()->format('Y')) }}</td>
                            @endif
                            <!-- Jika filter 'agama' aktif -->
                            @if(isset($activeFilters['agama']))
                                <td>{{ $pgw->agama }}</td>
                            @endif
                            <!-- Jika filter 'jenis_kelamin' aktif -->
                            @if(isset($activeFilters['jenis_kelamin']))
                                <td>{{ $pgw->jenis_kelamin }}</td>
                            @endif
                            <!-- Jika filter 'status_pernikahan' aktif -->
                            @if(isset($activeFilters['status_pernikahan']))
                                <td>{{ $pgw->status_pernikahan }}</td>
                            @endif
                            <!-- Jika filter 'status_pegawai' aktif -->   
                            @if(isset($activeFilters['status_pegawai']))
                                <td>{{ $pgw->status_pegawai }}</td>
                            @endif
                            <!-- Jika filter 'status_kepegawaian' aktif -->
                            @if(isset($activeFilters['status_kepegawaian']))
                                <td>{{ $pgw->status_kepegawaian }}</td>
                            @endif
                            <td>
                                <a href="{{route('admin.laporan.pegawai-detail.pdf', $pgw->id_pegawai)}}" target="_blank" class="btn btn-sm btn-danger">
                                    <i class="fa fa-file-pdf me-2"></i>PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-laporan-pegawai', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: false     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
    {{-- Button Loading --}}
    <script>
        function downloadFile(url, type) {
            const button = document.getElementById(type + 'Button');
            const spinner = button.querySelector('.spinner-border');
            const buttonText = button.querySelector('.button-text');
            const icon = button.querySelector('.fa');
        
            // Disable button and show spinner
            button.disabled = true;
            spinner.classList.remove('d-none');
            icon.classList.add('d-none');
            buttonText.textContent = 'Downloading...';
        
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'laporan-pegawai.' + (type === 'pdf' ? 'pdf' : 'xlsx');
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Download failed:', error);
                    alert('Download failed. Please try again.');
                })
                .finally(() => {
                    // Re-enable button and hide spinner
                    button.disabled = false;
                    spinner.classList.add('d-none');
                    icon.classList.remove('d-none');
                    buttonText.textContent = 'Download ' + (type === 'pdf' ? 'PDF' : 'Excel');
                });
        }
    </script>
@endsection