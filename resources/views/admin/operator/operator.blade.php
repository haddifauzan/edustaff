@extends('admin.layout.master')
@section('title', ' - Admin Data Operator')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Operator</h1>
        <p class="ps-3">Pengelolaan data dan akun operator.</p>
    </div>

    <!-- Card untuk Tombol Tambah Operator dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-1">
                    <a href="{{ route('admin.operator.create') }}" class="btn btn-primary"><i class="bx bx-plus me-2"></i> Tambah Operator</a>
                </div>
                <div class="col-md-4 ms-auto mt-1">
                    <form action="{{ route('admin.operator') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Operator..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card untuk Menampilkan Data Operator -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-operator" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto Profil</th>
                            <th>Nama Operator</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Status Akun</th>
                            <th>Terakhir Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operators as $operator)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><img src="{{ asset('foto_profil/'.$operator->foto_profil) }}" alt="Foto Profil" width="60" class="rounded-circle"></td>
                                <td>{{ $operator->nama_user }}</td>
                                <td>{{ $operator->email }}</td>
                                <td>{{ $operator->no_hp }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $operator->id_user }}" {{ $operator->status_akun === 'Aktif' ? 'checked' : '' }} onchange="toggleStatus('{{ $operator->id_user }}')">
                                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $operator->id_user }}">
                                            {{ $operator->status_akun === 'Aktif' ? 'Aktif' : 'Non-Aktif' }}
                                        </label>
                                    </div>
                                </td>
                                <td id="last-login-{{ $operator->id_user }}">
                                    {{ $operator->last_login ? \Carbon\Carbon::parse($operator->last_login)->diffForHumans() : '-' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.operator.edit', $operator->id_user) }}" class="btn btn-warning btn-sm"><i class="bx bx-pencil"></i></a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $operator->id_user }}')"><i class="bx bx-trash"></i></button>
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
                    Apakah Anda yakin ingin menghapus operator ini?
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
            new DataTable('#table-operator', {
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
            deleteForm.action = `/admin/operator/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }

        function toggleStatus(id) {
            fetch(`/admin/operator/toggle/${id}`, {
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
                element.checked = data.status_akun === 'Aktif';
                element.labels[0].textContent = data.status_akun;
            })
            .catch(error => console.error('Request gagal terkirim:', error));
        }
    </script>
    
{{-- SweetAlert --}}
@include('admin.layout.sweetalert')

@endsection
