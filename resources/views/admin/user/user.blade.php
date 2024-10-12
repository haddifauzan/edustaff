@extends('admin.layout.master')
@section('title', ' - Admin Data User')

@section('content')

    <!-- Card untuk Judul Halaman -->
    <div class="card mb-4">
        <h1 class="ps-3 pt-3 pb-1 text-bold">Data User</h1>
        <p class="ps-3">Pengelolaan data dan akun user.</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET">
                        <div class="input-group">
                            <select class="form-select" name="role" onchange="this.form.submit()">
                                <option value="">Semua Role</option>
                                <option value="Pegawai" {{ request('role') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                                <option value="Operator" {{ request('role') == 'Operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET">
                        <div class="input-group">
                            <select class="form-select" name="status_akun" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="Aktif" {{ request('status_akun') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ request('status_akun') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET"> 
                        <button type="submit" class="btn btn-danger w-100"><i class="bx bx-refresh"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-3 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET">
                        <div class="input-group">
                            <!-- Sertakan semua parameter yang diperlukan -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <input type="hidden" name="status_akun" value="{{ request('status_akun') }}">
                            <input type="hidden" name="sort_order" value="{{ request('sort_order') }}"> <!-- Sertakan sort_order yang saat ini dipilih -->
                
                            <select class="form-select" name="sort_by" onchange="this.form.submit()">
                                <option value="">Urutkan Berdasarkan</option>
                                <option value="nama_user" {{ request('sort_by') == 'nama_user' ? 'selected' : '' }}>Nama</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 mt-1">
                    <form action="{{ route('admin.user') }}" method="GET">
                        <div class="input-group">
                            <!-- Pastikan semua filter lain dipertahankan -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <input type="hidden" name="status_akun" value="{{ request('status_akun') }}">
                            <input type="hidden" name="sort_by" value="{{ request('sort_by') ?? '' }}"> <!-- Pertahankan sort_by -->

                            <select class="form-select" name="sort_order" onchange="this.form.submit()">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : (request('sort_order') === null ? 'selected' : '') }}>Ascending</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                    </form>                                      
                </div>  
            </div>
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
                            <th>Role</th>
                            <th>Terakhir Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><img src="{{ asset('foto_profil/'.$user->foto_profil) }}" alt="Foto Profil" width="60" class="rounded-circle"></td>
                                <td>{{ $user->nama_user }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $user->id_user }}" {{ $user->status_akun === 'Aktif' ? 'checked' : '' }} onchange="toggleStatus('{{ $user->id_user }}')">
                                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $user->id_user }}">
                                            {{ $user->status_akun === 'Aktif' ? 'Aktif' : 'Non-Aktif' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $user->role === 'Operator' ? 'bg-warning' : 'bg-success' }}">{{ $user->role }}</span>
                                </td>
                                <td id="last-login-{{ $user->id_user }}">
                                    {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : '-' }}
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
            fetch(`/admin/user/toggle/${id}`, {
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
