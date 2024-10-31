@extends('pegawai.layout.master')
@section('title', ' - Pegawai Bantuan')

@section('content')

{{-- SweetAlert --}}
@include('pegawai.layout.sweetalert')

<div class="d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-header">
            <h3 class="card-title">Form Bantuan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bantuan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori Bantuan</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori Bantuan</option>
                        <option value="Teknis">Teknis</option>
                        <option value="Non Teknis">Non Teknis</option>
                    </select>
                </div>

                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i> Kirim Bantuan Ke WhatsApp</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
