@extends('pegawai.layout.master')
@section('title', ' - Prestasi Pegawai')

@section('content')
    {{-- Card untuk Header --}}
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Manajemen Prestasi Pegawai</h2>
            <p class="card-text">Tambah prestasi baru dan lihat riwayat pengajuan prestasi Anda di sini.</p>
        </div>
    </div>

    <div class="row">
        {{-- Card untuk Form di Sebelah Kiri --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 id="form-title">Tambah Prestasi</h3> {{-- Nama form dinamis --}}
                </div>
                <div class="card-body">
                    {{-- Form Tambah/Edit Prestasi --}}
                    <form id="prestasiForm" action="{{ route('pegawai.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST') {{-- Dinamis diubah saat edit --}}
                        <input type="hidden" id="prestasi_id" name="id_prestasi"> {{-- Hidden input untuk ID saat edit --}}
                        
                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                            <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control @error('nama_prestasi') is-invalid @enderror" placeholder="Masukkan nama prestasi" required>
                            @error('nama_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_prestasi" class="form-label">Deskripsi Prestasi</label>
                            <textarea name="deskripsi_prestasi" id="deskripsi_prestasi" class="form-control @error('deskripsi_prestasi') is-invalid @enderror" rows="3" placeholder="Deskripsikan prestasi" required></textarea>
                            @error('deskripsi_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tgl_dicapai" class="form-label">Tanggal Dicapai</label>
                            <input type="date" name="tgl_dicapai" id="tgl_dicapai" class="form-control @error('tgl_dicapai') is-invalid @enderror" required>
                            @error('tgl_dicapai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_sertifikat" class="form-label">Upload Bukti/Sertifikat</label><span class="text-danger ms-2">*format file: .jpg, .jpeg, .png</span>
                            <input type="file" name="foto_sertifikat" id="foto_sertifikat" class="form-control @error('foto_sertifikat') is-invalid @enderror">
                            <img id="foto_sertifikat_preview" alt="Foto Sertifikat" class="mt-2" style="display:none; width:100px;">
                            @error('foto_sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <script>
                            if (this.getAttribute('data-foto')) {
                                const fotoSrc = this.getAttribute('data-foto');
                                const fotoElement = document.getElementById('foto_sertifikat_preview');
                                fotoElement.src = fotoSrc;
                                fotoElement.style.display = 'block';
                            }
                        </script>

                        <button type="submit" class="btn btn-primary" id="form-button">Simpan Prestasi</button> {{-- Tombol dinamis --}}
                        <button type="reset" class="btn btn-secondary ms-2">Reset</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Card untuk Tabel di Sebelah Kanan --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3>Riwayat Pengajuan Prestasi</h3>
                </div>
                <div class="card-body">
                    {{-- Tabel Riwayat Pengajuan Prestasi --}}
                    <div class="table-responsive">
                        <table class="table table-hover" id="table-prestasi">
                            <thead>
                                <tr>
                                    <th>Nama Prestasi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestasi as $item)
                                <tr>
                                    <td>{{ $item->nama_prestasi }}</td>
                                    
                                    <td>{{ $item->tgl_dicapai }}</td>
                                    <td>
                                        @if ($item->status == 'menunggu')
                                            <span class="badge bg-warning">{{ $item->status }}</span>
                                        @elseif ($item->status == 'diterima')
                                            <span class="badge bg-success">{{ $item->status }}</span>
                                        @elseif ($item->status == 'ditolak')
                                            <span class="badge bg-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                        <!-- Tombol Detail Prestasi -->
                                        <button type="button" class="btn btn-sm btn-info detail-button" data-id="{{ $item->id_prestasi }}" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_prestasi }}">
                                            <i class="bx bx-show"></i>
                                        </button>
                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-sm btn-warning edit-button"
                                                data-id="{{ $item->id_prestasi }}"
                                                data-nama="{{ $item->nama_prestasi }}"
                                                data-deskripsi="{{ $item->deskripsi_prestasi }}"
                                                data-tanggal="{{ $item->tgl_dicapai }}"
                                                data-foto="{{ $item->foto_sertifikat }}">
                                                <i class="bx bx-pencil"></i>
                                            </button>
                                            {{-- Tombol Hapus --}}
                                            <button type="button" class="btn btn-sm btn-danger delete-button" data-id="{{ $item->id_prestasi }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Batal --}}
    @foreach ($prestasi as $item)
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pegawai.prestasi.destroy' , ['id' => $item->id_prestasi]) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Batalkan Prestasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin membatalkan prestasi ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Detail Prestasi -->
    @foreach ($prestasi as $item)
    <div class="modal fade" id="detailModal{{ $item->id_prestasi }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id_prestasi }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $item->id_prestasi }}">Detail Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Pegawai:</strong> {{ $item->pegawai->nama_pegawai }}</p>
                    <p><strong>Nama Prestasi:</strong> {{ $item->nama_prestasi }}</p>
                    <p><strong>Deskripsi:</strong> {{ $item->deskripsi_prestasi }}</p>
                    <p><strong>Tanggal Dicapai:</strong> {{ \Carbon\Carbon::parse($item->tanggal_prestasi)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                    <p><strong>Status:</strong>
                        @if ($item->status == 'menunggu')
                            <span class="badge bg-warning">{{ $item->status }}</span>
                        @elseif ($item->status == 'diterima')
                            <span class="badge bg-success">{{ $item->status }}</span>
                        @elseif ($item->status == 'ditolak')
                            <span class="badge bg-danger">{{ $item->status }}</span>
                        @endif
                    <p><strong>Foto Sertifikat:</strong></p>
                    <img src="{{ asset('prestasi/'.$item->foto_sertifikat) }}" alt="Foto Sertifikat" class="img-fluid mt-2" style="max-width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    {{-- SweetAlert --}}
    @include('pegawai.layout.sweetalert')

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-prestasi', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event Listener Tombol Edit
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    // Mengisi form dengan data prestasi yang dipilih
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const deskripsi = this.getAttribute('data-deskripsi');
                    const tanggal = this.getAttribute('data-tanggal');
    
                    // Set data ke dalam form
                    document.getElementById('prestasi_id').value = id;
                    document.getElementById('nama_prestasi').value = nama;
                    document.getElementById('deskripsi_prestasi').value = deskripsi;
                    document.getElementById('tgl_dicapai').value = tanggal;
    
                    // Set foto sertifikat jika ada
                    if (this.getAttribute('data-foto')) {
                        document.getElementById('foto_sertifikat').src = this.getAttribute('data-foto');
                    }
    
                    // Ubah form title dan button menjadi mode edit
                    document.getElementById('form-title').textContent = 'Edit Prestasi';
    
                    // Ubah action form untuk edit (POST dan ubah menjadi PUT)
                    const form = document.getElementById('prestasiForm');
                    form.action = `/pegawai/prestasi/update/${id}`;
                    form.method = 'POST';
    
                    // Tambahkan input method PUT untuk form edit
                    if (!document.querySelector('input[name="_method"]')) {
                        const methodInput = document.createElement('input');
                        methodInput.setAttribute('type', 'hidden');
                        methodInput.setAttribute('name', '_method');
                        methodInput.setAttribute('value', 'PUT');
                        form.appendChild(methodInput);
                    }
                });
            });
        });
    </script>
    
@endsection
