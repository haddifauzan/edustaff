@extends('admin.layout.master')
@section('title', isset($operator) ? 'Edit Operator' : 'Tambah Operator')

@section('content')

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.operator') }}">Data Operator</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($operator) ? 'Edit Operator' : 'Tambah Operator' }}</li>
        </ol>
    </nav>

    <!-- Card untuk Form Tambah/Edit Operator -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">{{ isset($operator) ? 'Edit Operator' : 'Tambah Operator' }}</h3>
        </div>
        <div class="card-body">
            <!-- Form untuk Tambah/Edit Operator -->
            <form action="{{ isset($operator) ? route('admin.operator.update', $operator->id_user) : route('admin.operator.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($operator))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nama_user" class="form-label">Nama Operator <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_user') is-invalid @enderror" id="nama_user" name="nama_user" placeholder="Masukkan nama operator" value="{{ old('nama_user', isset($operator) ? $operator->nama_user : '') }}">
                    @error('nama_user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ old('email', isset($operator) ? $operator->email : '') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" value="{{ old('no_hp', isset($operator) ? $operator->no_hp : '') }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Foto Profil</label>
                    <small class="text-danger ms-2">*Gambar harus berupa file jpg/jpeg/png dan tidak boleh lebih dari 2048KB</small>
                    <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" id="foto_profil" name="foto_profil" onchange="previewImage(event)">
                    @error('foto_profil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <img id="preview_foto_profil" src="{{ isset($operator) && $operator->foto_profil ? asset('foto_profil/'.$operator->foto_profil) : '' }}" alt="Foto Profil" width="100" style="display: {{ isset($operator) && $operator->foto_profil ? '' : 'none' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ isset($operator) ? 'Password Baru' : 'Password' }}</label>
                    <small class="text-danger ms-2">*Password Minimal 6 Karakter</small>
                    <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye" onclick="togglePassword('password')"><i class="bx bx-hide" id="passwordEye"></i></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye" onclick="togglePassword('password_confirmation')"><i class="bx bx-hide" id="passwordConfirmationEye"></i></span>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-primary">{{ isset($operator) ? 'Update Operator' : 'Tambah Operator' }}</button>
                <a href="{{ route('admin.operator') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview_foto_profil');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
