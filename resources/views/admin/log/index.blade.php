@extends('admin.layout.master')
@section('title', ' - Log Aktivitas')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-4">Log Aktivitas</h3>
            <div class="card-tools">
                <form action="{{ route('admin.log') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Data..." value="{{ request('search') }}">
                            <button class="btn btn-secondary" type="submit"><i class="bx bx-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Dari Tanggal">
                    </div>
                    <div class="col-md-3">
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="Sampai Tanggal">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-filter me-2"></i> Filter</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.log') }}" class="btn btn-danger"><i class="fas fa-sync-alt"></i></a>
                    </div>                        
                </form>
            </div>                
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap" id="table-log">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama User</th>
                            <th>Role</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>Data</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->id_log }}</td>
                                <td>{{ $log->user->nama_user ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $log->user->role === 'Pegawai' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $log->user->role ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $log->action === 'delete' ? 'bg-danger' : ($log->action === 'update' ? 'bg-info' : 'bg-primary') }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>{{ $log->model }}</td>
                                <td data-bs-toggle="tooltip" data-placement="top" title="{{ json_encode($log->data) }}" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis">{{ Str::limit(json_encode($log->data), 100, '...') }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td data-bs-toggle="tooltip" data-placement="top" title="{{ $log->user_agent }}" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis">{{ Str::limit($log->user_agent, 100, '...') }}</td>
                                <td>{{ $log->created_at }}</td>
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
            new DataTable('#table-log', {
                searching: false,  // Nonaktifkan search box
                paging: true,      // Mengaktifkan pagination
                info: true,        // Menampilkan informasi jumlah data
                ordering: true     // Mengaktifkan fitur pengurutan
            });
        });
    </script>

    @include('admin.layout.sweetalert')
@endsection