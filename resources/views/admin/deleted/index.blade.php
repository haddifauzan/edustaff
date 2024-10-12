@extends('admin.layout.master')
@section('title', ' - Admin Sampah')

@section('content')
<div>
    <!-- Card for Title -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Data {{ ucfirst($modelType) }} yang Terhapus</h3>
            <p class="card-text">Data yang telah dihapus dari {{ $modelType }} akan ditampilkan di sini. Anda dapat memulihkan atau menghapusnya secara permanen.</p>
        </div>
    </div>

    <!-- Card for Table and Search -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tabel Data {{ ucfirst($modelType) }}</h5>
            <!-- Search form aligned to the right -->
            <form action="{{ route('admin.deleted', ['modelType' => $modelType]) }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Data" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            @if($modelType == 'kelas')
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                            @elseif($modelType == 'jurusan')
                                <th>Nama Jurusan</th>
                                <th>Singkatan</th>
                            @elseif($modelType == 'jabatan')
                                <th>Nama Jabatan</th>
                                <th>Deskripsi</th>
                            @elseif($modelType == 'mapel')
                                <th>Nama Mapel</th>
                                <th>Kode Mapel</th>
                            @endif
                            <th>Deleted At</th>
                            <th>Expired At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedData as $data)
                        <tr>
                            @if($modelType == 'kelas')
                                <td>{{ $data->nama_kelas ?: '-' }}</td>
                                <td>{{ $data->tingkat ?: '-' }}</td>
                                @php $primaryKey = 'id_kelas'; @endphp
                            @elseif($modelType == 'jurusan')
                                <td>{{ $data->nama_jurusan ?: '-' }}</td>
                                <td>{{ $data->singkatan ?: '-' }}</td>
                                @php $primaryKey = 'id_jurusan'; @endphp
                            @elseif($modelType == 'jabatan')
                                <td>{{ $data->nama_jabatan ?: '-' }}</td>
                                <td>{{ $data->deskripsi_jabatan ?: '-' }}</td>
                                @php $primaryKey = 'id_jabatan'; @endphp
                            @elseif($modelType == 'mapel')
                                <td>{{ $data->nama_pelajaran ?: '-' }}</td>
                                <td>{{ $data->kode_pelajaran ?: '-' }}</td>
                                @php $primaryKey = 'id_pelajaran'; @endphp
                            @endif
                            <td>{{ $data->deleted_at }}</td>
                            <td>{{ $data->expired_at }}</td>
                            <td class="text-center">
                                <form action="{{ route('deleted.forceDelete', ['modelType' => $modelType, 'id' => $data->$primaryKey]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus permanen?')"><i class="bx bx-trash"></i></button>
                                </form>

                                <form action="{{ route('deleted.restore', ['modelType' => $modelType, 'id' => $data->$primaryKey]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success"><i class="bx bx-undo"></i></button>
                                </form>
                            </td>
                        </tr>            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>


{{-- SweetAlert --}}
@include('admin.layout.sweetalert')

@endsection
