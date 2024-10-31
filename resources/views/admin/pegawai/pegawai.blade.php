@extends('admin.layout.master')
@section('title', ' - Admin Data Pegawai')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data Pegawai</h1>
        <p class="ps-3">Pengelolaan data dan akun pegawai.</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mt-1">
                    <form action="{{ route('admin.pegawai') }}" method="GET">
                        <div class="input-group">
                            <select class="form-select" name="status_akun" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="Aktif" {{ request('status_akun') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ request('status_akun') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 mt-1"></div>
                <div class="col-md-5 mt-1">
                    <form action="{{ route('admin.pegawai') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('admin.pegawai') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-user" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto Profil</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Status Akun</th>
                            <th>Terakhir Login</th>
                            <th>Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawais as $pegawai)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><img src="{{ asset('foto_profil/'.$pegawai->foto_profil) }}" alt="Foto Profil" width="60" class="rounded-circle"></td>
                                <td>{{ $pegawai->nama_user }}</td>
                                <td>{{ $pegawai->email }}</td>
                                <td>{{ $pegawai->no_hp }}</td>
                                <td>
                                    <span class="badge {{ $pegawai->status_akun === 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $pegawai->status_akun === 'Aktif' ? 'Aktif' : 'Non-Aktif' }}</span>
                                </td>
                                <td id="last-login-{{ $pegawai->id_pegawai }}">
                                    {{ $pegawai->last_login ? \Carbon\Carbon::parse($pegawai->last_login)->diffForHumans() : '-' }}
                                </td>
                                <td><a href="{{ route('admin.pegawai.show', $pegawai->id_pegawai) }}" class="btn btn-primary btn-sm"><i class="bx bx-show"></i></a></td>
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
            new DataTable('#table-user', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>
    <script>
        function toggleStatus(id) {
            fetch(`/admin/pegawai/toggle/${id}`, {
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
@endsection
