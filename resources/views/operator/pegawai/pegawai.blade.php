@extends('operator.layout.master')
@section('title', ' - Operator Data Pegawai')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Pegawai</h1>
        <p class="ps-3">Pengelolaan data dan akun pegawai.</p>
    </div>

    <!-- Card untuk Tombol Tambah Pegawai dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <a href="{{ route('operator.pegawai.create') }}" class="btn btn-primary"><i class="bx bx-plus me-2"></i> Tambah Pegawai</a>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('operator.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Pegawai..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Pegawai -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pegawai" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto Profil</th>
                            <th>Nama Pegawai</th>
                            <th>NIK</th>
                            <th>Status Kepegawaian</th>
                            <th>Status Pegawai</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawais as $pegawai)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><img src="{{ asset('foto_profil/'.$pegawai->foto_pegawai) }}" alt="Foto Profil" width="60" class="rounded-circle"></td>
                                <td>{{ $pegawai->nama_pegawai }}</td>
                                <td>{{ $pegawai->nik }}</td>
                                <td>{{ $pegawai->status_kepegawaian }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $pegawai->id_pegawai }}" {{ $pegawai->status_pegawai === 'Aktif' ? 'checked' : '' }} onchange="toggleStatus('{{ $pegawai->id_pegawai }}')">
                                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $pegawai->id_pegawai }}">
                                            {{ $pegawai->status_pegawai === 'Aktif' ? 'Aktif' : 'Non-Aktif' }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('operator.pegawai.show', $pegawai->id_pegawai) }}" class="btn btn-info btn-sm"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('operator.pegawai.edit', $pegawai->id_pegawai) }}" class="btn btn-warning btn-sm"><i class="bx bx-pencil"></i></a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $pegawai->id_pegawai }}')"><i class="bx bx-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Pegawai ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            new DataTable('#table-pegawai', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
    <!-- Script untuk Toggle Status dan Konfirmasi Hapus -->
    <script>
        function confirmDelete(id) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/operator/pegawai/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }

        function toggleStatus(id) {
            fetch(`/operator/pegawai/toggle/${id}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const element = document.getElementById(`flexSwitchCheckDefault${id}`);
                element.checked = data.status_pegawai === 'Aktif';
                element.labels[0].textContent = data.status_pegawai;
            })
            .catch(error => console.error('Request gagal terkirim:', error));
        }

    </script>

    {{-- SweetAlert --}}
    @include('operator.layout.sweetalert')

@endsection
