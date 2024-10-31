@extends('pegawai.layout.master')
@section('title', ' - Pegawai Perubahan')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="ps-3 pt-3 pb-1 text-bold">Pengajuan Perubahan Data Pegawai</h2>
                    <p class="ps-3">Berikut merupakan form dan riwayat untuk mengajukan perubahan data pegawai.</p>
                </div>
                <div class="col-md-3 my-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#riwayatPengajuanModal">
                        <i class="bx bx-history me-2"></i> Lihat Riwayat Pengajuan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Form Pengajuan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pegawai.updateDataDiri') }}" method="POST" enctype="multipart/form-data" id="formPerubahan">
                @csrf
                <div class="row mt-3">
                    <h4 class="col-12">Data Diri Pegawai</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK<span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" required maxlength="16" placeholder="Masukkan NIK" value="{{ old('nik', $pegawai->nik) }}"> 
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai<span class="text-danger">*</span></label>
                            <input type="text" name="nama_pegawai" class="form-control" required maxlength="100" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"> 
                            @error('nama_pegawai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir<span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" required placeholder="Masukkan Kota" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}"> 
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir<span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}"> 
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="alamat">Alamat<span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $pegawai->alamat) }}</textarea> 
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <h4 class="col-12">Data Tambahan</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agama">Agama<span class="text-danger">*</span></label>
                            <select name="agama" class="form-select" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama', $pegawai->agama) === 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $pegawai->agama) === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Hindu" {{ old('agama', $pegawai->agama) === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $pegawai->agama) === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $pegawai->agama) === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_pernikahan">Status Pernikahan<span class="text-danger">*</span></label>
                            <select name="status_pernikahan" class="form-select" required>
                                <option value="Menikah" {{ old('status_pernikahan', $pegawai->status_pernikahan) === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Belum Menikah" {{ old('status_pernikahan', $pegawai->status_pernikahan) === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Cerai" {{ old('status_pernikahan', $pegawai->status_pernikahan) === 'Cerai' ? 'selected' : '' }}>Cerai</option>
                            </select>
                            @error('status_pernikahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="no_tlp">Nomor Telepon<span class="text-danger">*</span></label>
                            <input type="text" name="no_tlp" class="form-control" required maxlength="15" placeholder="Masukkan No Telepon" value="{{ old('no_tlp', $pegawai->no_tlp) }}"> 
                            @error('no_tlp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="Masukkan Email" value="{{ old('email', $pegawai->email) }}"> 
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="pendidikan_terakhir">Pendidikan Terakhir<span class="text-danger">*</span></label>
                            <input type="text" name="pendidikan_terakhir" class="form-control" required maxlength="50" placeholder="Masukkan Pendidikan Terakhir" value="{{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) }}"> 
                            @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tahun_lulus">Tahun Lulus<span class="text-danger">*</span></label>
                            <input type="number" name="tahun_lulus" class="form-control" required placeholder="Masukkan Tahun Lulus" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_lulus', $pegawai->tahun_lulus) }}"> 
                            @error('tahun_lulus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="gelar_depan">Gelar Depan</label>
                            <select name="gelar_depan" class="form-select" value="{{ old('gelar_depan', $pegawai->gelar_depan) }}">
                                <option value="">Pilih Gelar Depan</option>
                                <option value="Dr." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Dr.' ? 'selected' : '' }}>Dr. (Doktor)</option>
                                <option value="Drg." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Drg.' ? 'selected' : '' }}>Drg. (Dokter Gigi)</option>
                                <option value="Drs." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Drs.' ? 'selected' : '' }}>Drs. (Doktorandus)</option>
                                <option value="Ir." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Ir.' ? 'selected' : '' }}>Ir. (Insinyur)</option>
                                <option value="Prof." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Prof.' ? 'selected' : '' }}>Prof. (Profesor)</option>
                                <option value="H." {{ old('gelar_depan', $pegawai->gelar_depan) === 'H.' ? 'selected' : '' }}>H. (Haji)</option>
                                <option value="Hj." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Hj.' ? 'selected' : '' }}>Hj. (Hajah)</option>
                                <option value="Dr." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Dr.' ? 'selected' : '' }}>Dr. (Dokter)</option>
                                <option value="Drg." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Drg.' ? 'selected' : '' }}>Drg. (Dokter Gigi)</option>
                                <option value="Sp." {{ old('gelar_depan', $pegawai->gelar_depan) === 'Sp.' ? 'selected' : '' }}>Sp. (Spesialis)</option>
                                <option value="Lainnya" {{ old('gelar_depan', $pegawai->gelar_depan) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <input type="text" name="gelar_depan_lainnya" class="form-control mt-2" maxlength="50" placeholder="Masukkan Gelar Depan lainnya" style="{{ old('gelar_depan', $pegawai->gelar_depan) === 'Lainnya' ? 'display: block;' : 'display: none;' }}" value="{{ old('gelar_depan_lainnya', $pegawai->gelar_depan_lainnya) }}">
                            <script>
                                document.querySelector('[name="gelar_depan"]').addEventListener('change', function() {
                                    if (this.value === 'Lainnya') {
                                        document.querySelector('[name="gelar_depan_lainnya"]').style.display = 'block';
                                    } else {
                                        document.querySelector('[name="gelar_depan_lainnya"]').style.display = 'none';
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="gelar_belakang">Gelar Belakang</label>
                            <select name="gelar_belakang" class="form-select" value="{{ old('gelar_belakang', $pegawai->gelar_belakang) }}">
                                <option value="">Pilih Gelar Belakang</option>
                                <option value="S.Pd" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Pd' ? 'selected' : '' }}>S.Pd (Sarjana Pendidikan)</option>
                                <option value="S.Psi" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Psi' ? 'selected' : '' }}>S.Psi (Sarjana Psikologi)</option>
                                <option value="S.Kom" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Kom' ? 'selected' : '' }}>S.Kom (Sarjana Komputer)</option>
                                <option value="S.T" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.T' ? 'selected' : '' }}>S.T (Sarjana Teknik)</option>
                                <option value="S.E" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.E' ? 'selected' : '' }}>S.E (Sarjana Ekonomi)</option>
                                <option value="S.Si" {{ old('gelar_belakang', $pegawai->gelar_belakang)  === 'S.Si' ? 'selected' : '' }}>S.Si (Sarjana Sains)</option>
                                <option value="S.H" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.H' ? 'selected' : '' }}>S.H (Sarjana Hukum)</option>
                                <option value="S.Farm" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Farm' ? 'selected' : '' }}>S.Farm (Sarjana Farmasi)</option>
                                <option value="S.Ked" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Ked' ? 'selected' : '' }}>S.Ked (Sarjana Kedokteran)</option>
                                <option value="S.Sos" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Sos' ? 'selected' : '' }}>S.Sos (Sarjana Sosial)</option>
                                <option value="S.Sn" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'S.Sn' ? 'selected' : '' }}>S.Sn (Sarjana Seni)</option>
                                <option value="M.Pd" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Pd' ? 'selected' : '' }}>M.Pd (Magister Pendidikan)</option>
                                <option value="M.Psi" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Psi' ? 'selected' : '' }}>M.Psi (Magister Psikologi)</option>
                                <option value="M.Kom" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Kom' ? 'selected' : '' }}>M.Kom (Magister Komputer)</option>
                                <option value="M.E" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.E' ? 'selected' : '' }}>M.E (Magister Ekonomi)</option>
                                <option value="M.T" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.T' ? 'selected' : '' }}>M.T (Magister Teknik)</option>
                                <option value="M.Si" {{ old('gelar_belakang', $pegawai->gelar_belakang)  === 'M.Si' ? 'selected' : '' }}>M.Si (Magister Sains)</option>
                                <option value="M.H" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.H' ? 'selected' : '' }}>M.H (Magister Hukum)</option>
                                <option value="M.Farm" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Farm' ? 'selected' : '' }}>M.Farm (Magister Farmasi)</option>
                                <option value="M.Ked" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Ked' ? 'selected' : '' }}>M.Ked (Magister Kedokteran)</option>
                                <option value="M.Sos" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Sos' ? 'selected' : '' }}>M.Sos (Magister Sosial)</option>
                                <option value="M.Sn" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'M.Sn' ? 'selected' : '' }}>M.Sn (Magister Seni)</option>
                                <option value="Lainnya" {{ old('gelar_belakang', $pegawai->gelar_belakang) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <input type="text" name="gelar_belakang_lainnya" class="form-control mt-2" maxlength="50" placeholder="Masukkan Gelar Belakang lainnya" style="{{ old('gelar_belakang', $pegawai->gelar_belakang) === 'Lainnya' ? 'display: block;' : 'display: none;' }}" value="{{ old('gelar_belakang_lainnya') }}">
                            <script>
                                document.querySelector('[name="gelar_belakang"]').addEventListener('change', function() {
                                    if (this.value === 'Lainnya') {
                                        document.querySelector('[name="gelar_belakang_lainnya"]').style.display = 'block';
                                    } else {
                                        document.querySelector('[name="gelar_belakang_lainnya"]').style.display = 'none';
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <h4 class="col-12">Data Kepegawaian</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_pegawai">Foto Pegawai <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_pegawai" class="form-control @error('foto_pegawai') is-invalid @enderror">
                            @if ($pegawai->foto_pegawai)
                                <img src="{{ asset('foto_profil/' . $pegawai->foto_pegawai) }}" alt="Foto Pegawai" width="100" class="mt-2"> 
                            @endif
                            @error('foto_pegawai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_kepegawaian">Status Kepegawaian<span class="text-danger">*</span></label>
                            <select name="status_kepegawaian" class="form-select" required>
                                <option value="ASN" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) === 'ASN' ? 'selected' : '' }}>ASN</option>
                                <option value="Non-ASN" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) === 'Non-ASN' ? 'selected' : '' }}>Non-ASN</option>
                                <option value="Honorer" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) === 'Honorer' ? 'selected' : '' }}>Honorer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" maxlength="18" placeholder="Masukkan NIP" value="{{ old('nip', $pegawai->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="no_sk_pengangkatan">Nomor SK Pengangkatan</label>
                            <input type="text" name="no_sk_pengangkatan" class="form-control @error('no_sk_pengangkatan') is-invalid @enderror" maxlength="50" placeholder="Masukkan No SK Pengangkatan" value="{{ old('no_sk_pengangkatan', $pegawai->no_sk_pengangkatan) }}"> 
                            @error('no_sk_pengangkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tgl_pengangkatan">Tanggal Pengangkatan</label>
                            <input type="date" name="tgl_pengangkatan" class="form-control @error('tgl_pengangkatan') is-invalid @enderror" value="{{ old('tgl_pengangkatan', $pegawai->tgl_pengangkatan) }}">
                            @error('tgl_pengangkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="pangkat">Pangkat</label>
                            <select name="pangkat" class="form-select">
                                <option value="">Pilih Pangkat</option>
                                <option value="Juru Muda" {{ old('pangkat', $pegawai->pangkat) === 'Juru Muda' ? 'selected' : '' }}>Juru Muda</option>
                                <option value="Juru Muda Tingkat I" {{ old('pangkat', $pegawai->pangkat) === 'Juru Muda Tingkat I' ? 'selected' : '' }}>Juru Muda Tingkat I</option>
                                <option value="Juru" {{ old('pangkat', $pegawai->pangkat) === 'Juru' ? 'selected' : '' }}>Juru</option>
                                <option value="Juru Tingkat I" {{ old('pangkat', $pegawai->pangkat) === 'Juru Tingkat I' ? 'selected' : '' }}>Juru Tingkat I</option>
                                <option value="Penata Muda" {{ old('pangkat', $pegawai->pangkat) === 'Penata Muda' ? 'selected' : '' }}>Penata Muda</option>
                                <option value="Penata Muda Tingkat I" {{ old('pangkat', $pegawai->pangkat) === 'Penata Muda Tingkat I' ? 'selected' : '' }}>Penata Muda Tingkat I</option>
                                <option value="Pengatur" {{ old('pangkat', $pegawai->pangkat) === 'Pengatur' ? 'selected' : '' }}>Pengatur</option>
                                <option value="Pengatur Tingkat I" {{ old('pangkat', $pegawai->pangkat) === 'Pengatur Tingkat I' ? 'selected' : '' }}>Pengatur Tingkat I</option>
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="golongan">Golongan</label>
                            <select name="golongan" class="form-select">
                                <option value="">Pilih Golongan</option>
                                <option value="I/a" {{ old('golongan', $pegawai->golongan) === 'I/a' ? 'selected' : '' }}>I/a</option>
                                <option value="I/b" {{ old('golongan', $pegawai->golongan) === 'I/b' ? 'selected' : '' }}>I/b</option>
                                <option value="I/c" {{ old('golongan', $pegawai->golongan) === 'I/c' ? 'selected' : '' }}>I/c</option>
                                <option value="I/d" {{ old('golongan', $pegawai->golongan) === 'I/d' ? 'selected' : '' }}>I/d</option>
                                <option value="II/a" {{ old('golongan', $pegawai->golongan) === 'II/a' ? 'selected' : '' }}>II/a</option>
                                <option value="II/b" {{ old('golongan', $pegawai->golongan) === 'II/b' ? 'selected' : '' }}>II/b</option>
                                <option value="II/c" {{ old('golongan', $pegawai->golongan) === 'II/c' ? 'selected' : '' }}>II/c</option>
                                <option value="II/d" {{ old('golongan', $pegawai->golongan) === 'II/d' ? 'selected' : '' }}>II/d</option>
                                <option value="III/a" {{ old('golongan', $pegawai->golongan) === 'III/a' ? 'selected' : '' }}>III/a</option>
                                <option value="III/b" {{ old('golongan', $pegawai->golongan) === 'III/b' ? 'selected' : '' }}>III/b</option>
                                <option value="III/c" {{ old('golongan', $pegawai->golongan) === 'III/c' ? 'selected' : '' }}>III/c</option>
                                <option value="III/d" {{ old('golongan', $pegawai->golongan) === 'III/d' ? 'selected' : '' }}>III/d</option>
                                <option value="IV/a" {{ old('golongan', $pegawai->golongan) === 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                <option value="IV/b" {{ old('golongan', $pegawai->golongan) === 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                <option value="IV/c" {{ old('golongan', $pegawai->golongan) === 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                <option value="IV/d" {{ old('golongan', $pegawai->golongan) === 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                <!-- Add more options as necessary -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="status_pegawai">Status Pegawai<span class="text-danger">*</span></label>
                            <select name="status_pegawai" class="form-select" required>
                                <option value="Aktif" {{ old('status_pegawai', $pegawai->status_pegawai) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ old('status_pegawai', $pegawai->status_pegawai) === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Data Foto -->
                <div class="row mt-5">
                    <h4 class="col-12">Data Foto Dokumen</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_ijazah">Foto Ijazah <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_ijazah" class="form-control @error('foto_ijazah') is-invalid @enderror" accept="image/*" value="{{ old('foto_ijazah') }}">
                            @if ($pegawai->foto_ijazah)
                                <img src="{{ asset($pegawai->foto_ijazah) }}" alt="Foto Ijazah" width="100" class="mt-2"> 
                            @endif
                            @error('foto_ijazah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_ktp" class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*" value="{{ old('foto_ktp') }}">
                            @if ($pegawai->foto_ktp)
                                <img src="{{ asset($pegawai->foto_ktp) }}" alt="Foto KTP" width="100" class="mt-2"> 
                            @endif
                            @error('foto_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="foto_kk">Foto Kartu Keluarga <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_kk" class="form-control @error('foto_kk') is-invalid @enderror" accept="image/*" value="{{ old('foto_kk') }}">
                            @if ($pegawai->foto_kk)
                                <img src="{{ asset($pegawai->foto_kk) }}" alt="Foto Kartu Keluarga" width="100" class="mt-2"> 
                            @endif
                            @error('foto_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="foto_akte_kelahiran">Foto Akte Kelahiran <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_akte_kelahiran" class="form-control @error('foto_akte_kelahiran') is-invalid @enderror" accept="image/*" value="{{ old('foto_akte_kelahiran') }}">
                            @if ($pegawai->foto_akte_kelahiran)
                                <img src="{{ asset($pegawai->foto_akte_kelahiran) }}" alt="Foto Akte Kelahiran" width="100" class="mt-2"> 
                            @endif
                            @error('foto_akte_kelahiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <!-- Submit Button -->
                <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                            Ajukan Perubahan
                        </button>
                    </div>
                </div>            
                <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Perubahan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menyimpan perubahan?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.addEventListener('click', function() {
                        this.classList.add('disabled');
                        this.querySelector('span').classList.remove('d-none');
                        document.getElementById('formPerubahan').submit();
                    });
                </script>            
            </form>            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="riwayatPengajuanModal" tabindex="-1" aria-labelledby="riwayatPengajuanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatPengajuanLabel">Riwayat Pengajuan Perubahan Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Waktu Pengajuan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($riwayatPengajuan->count() === 0)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data pengajuan.</td>
                                </tr>
                            @else
                                @foreach($riwayatPengajuan as $pengajuan)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->locale('id_ID')->isoFormat('D MMMM YYYY || HH:mm:ss') }}</td>
                                    <td>
                                        @if($pengajuan->status_konfirmasi === 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($pengajuan->status_konfirmasi === 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>   
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailPerubahan{{ $loop->index }}"><i class="fas fa-eye me-2"></i> Lihat</button>
                                            </div>
                                            @if($pengajuan->status_konfirmasi === 'menunggu')
                                                <div>
                                                    <button type="button" class="btn btn-danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#konfirmasiBatalkan{{ $loop->index }}"><i class="fas fa-ban me-2"></i> Batalkan</button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


@foreach($riwayatPengajuan as $pengajuan)
<div class="modal fade" id="konfirmasiBatalkan{{ $loop->index }}" tabindex="-1" aria-labelledby="konfirmasiBatalkanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiBatalkanLabel">Batalkan Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin membatalkan pengajuan perubahan data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('batalkanPengajuan', $pengajuan->id_konfirmasi) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Detail Pengajuan -->
@foreach($riwayatPengajuan as $pengajuan)
<div class="modal fade" id="detailPerubahan{{ $loop->index }}" tabindex="-1" aria-labelledby="detailPerubahanLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPerubahanLabel{{ $loop->index }}">Detail Pengajuan Perubahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Perubahan yang Diajukan:</h3>
                <ul class="list-group">
                    <!-- Loop untuk menampilkan perubahan kolom -->
                    @foreach(json_decode($pengajuan->kolom_diubah, true) as $kolom => $value)
                    <li class="list-group-item">
                        <strong>{{ ucwords(str_replace('_', ' ', $kolom)) }}:</strong><br>
                        @if(in_array($kolom, ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran']))
                            @if($pengajuan->status_konfirmasi == 'disetujui')
                                <div class="col-md-6">
                                    <p>Foto Baru</p>
                                    <a href="{{ asset($value['new']) }}" data-fancybox="foto-baru">
                                        <img src="{{ asset($value['new']) }}" alt="Foto Baru" class="img-thumbnail" width="150" />
                                    </a>
                                </div>
                            @elseif($pengajuan->status_konfirmasi == 'ditolak')
                                <div class="col-md-6">
                                    <p>Foto Lama</p>
                                    <a href="{{ asset($value['old']) }}" data-fancybox="foto-lama">
                                        <img src="{{ asset($value['old']) }}" alt="Foto Lama" class="img-thumbnail" width="150"/>
                                    </a>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Foto Lama</p>
                                        <a href="{{ asset($value['old']) }}" data-fancybox="foto-lama">
                                            <img src="{{ asset($value['old']) }}" alt="Foto Lama" class="img-thumbnail" width="150"/>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Foto Baru</p>
                                        <a href="{{ asset($value['new']) }}" data-fancybox="foto-baru">
                                            <img src="{{ asset($value['new']) }}" alt="Foto Baru" class="img-thumbnail" width="150" />
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <table class="table table-bordered">
                                <tr>
                                    <th>Data Lama</th>
                                    <td>{{ $value['old'] }}</td>
                                </tr>
                                <tr>
                                    <th>Data Baru</th>
                                    <td>{{ $value['new'] }}</td>
                                </tr>
                            </table>
                        @endif
                    </li>
                    @endforeach
                </ul>

                <hr>
                <h3 class="mt-4">Detail Pengajuan:</h3>
                <p><strong>Waktu Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->locale('id_ID')->isoFormat('D MMMM YYYY || HH:mm:ss') }}</p>
                <p><strong>Status:</strong>
                    @if($pengajuan->status_konfirmasi === 'menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                    @elseif($pengajuan->status_konfirmasi === 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </p>
                <hr>
                <p class="mt-2"><strong>Nama Operator:</strong> {{ $pengajuan->operator->nama_user ?? '-' }}</p>
                <h6>Respon Operator:</h6>
                <textarea class="form-control" rows="3" readonly style="background: white;">{{ $pengajuan->pesan_operator ?? 'Belum ada respon dari operator.' }}</textarea>
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
@endsection