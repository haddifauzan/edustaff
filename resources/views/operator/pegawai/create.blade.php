@extends('operator.layout.master')
@section('title', ' - Operator Tambah Pegawai')

@section('content')
<div>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('operator.pegawai') }}">Data Pegawai</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
        </ol>
    </nav>

    <!-- Card for form -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Tambah Data Pegawai</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('operator.pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Data Pegawai -->
                <div class="row mt-3">
                    <h4 class="col-12">Data Diri Pegawai</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK<span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" required maxlength="16" placeholder="Masukkan NIK" value="{{ old('nik') }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai<span class="text-danger">*</span></label>
                            <input type="text" name="nama_pegawai" class="form-control" required maxlength="100" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_pegawai') }}">
                            @error('nama_pegawai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir<span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" required placeholder="Masukkan Kota" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir<span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="alamat">Alamat<span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <!-- Data Tambahan -->
                <div class="row mt-5">
                    <h4 class="col-12">Data Tambahan</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agama">Agama<span class="text-danger">*</span></label>
                            <select name="agama" class="form-select" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') === 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Hindu" {{ old('agama') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
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
                                <option value="Menikah" {{ old('status_pernikahan') === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Belum Menikah" {{ old('status_pernikahan') === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Cerai" {{ old('status_pernikahan') === 'Cerai' ? 'selected' : '' }}>Cerai</option>
                            </select>
                            @error('status_pernikahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="no_tlp">Nomor Telepon<span class="text-danger">*</span></label>
                            <input type="text" name="no_tlp" class="form-control" required maxlength="15" placeholder="Masukkan No Telepon" value="{{ old('no_tlp') }}">
                            @error('no_tlp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="Masukkan Email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="pendidikan_terakhir">Pendidikan Terakhir<span class="text-danger">*</span></label>
                            <input type="text" name="pendidikan_terakhir" class="form-control" required maxlength="50" placeholder="Masukkan Pendidikan Terakhir" value="{{ old('pendidikan_terakhir') }}">
                            @error('pendidikan_terakhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tahun_lulus">Tahun Lulus<span class="text-danger">*</span></label>
                            <input type="number" name="tahun_lulus" class="form-control" required placeholder="Masukkan Tahun Lulus" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_lulus') }}">
                            @error('tahun_lulus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="gelar_depan">Gelar Depan</label>
                            <select name="gelar_depan" class="form-select" value="{{ old('gelar_depan') }}">
                                <option value="">Pilih Gelar Depan</option>
                                <!-- Gelar Depan Umum -->
                                <option value="Dr.">Dr. (Doktor)</option>
                                <option value="Drg.">Drg. (Dokter Gigi)</option>
                                <option value="Drs.">Drs. (Doktorandus)</option>
                                <option value="Ir.">Ir. (Insinyur)</option>
                                <option value="Prof.">Prof. (Profesor)</option>
                                <option value="H.">H. (Haji)</option>
                                <option value="Hj.">Hj. (Hajah)</option>
                                <!-- Gelar Profesi Medis -->
                                <option value="Dr.">Dr. (Dokter)</option>
                                <option value="Drg.">Drg. (Dokter Gigi)</option>
                                <option value="Sp.">Sp. (Spesialis)</option>
                                <!-- Gelar Lainnya -->
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" name="gelar_depan_lainnya" class="form-control mt-2" maxlength="50" placeholder="Masukkan Gelar Depan lainnya" style="display: none;" value="{{ old('gelar_depan_lainnya') }}">
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
                            <select name="gelar_belakang" class="form-select">
                                <option value="">Pilih Gelar Belakang</option>
                                <option value="S.Pd" {{ old('gelar_belakang') === 'S.Pd' ? 'selected' : '' }}>S.Pd (Sarjana Pendidikan)</option>
                                <option value="S.Psi" {{ old('gelar_belakang') === 'S.Psi' ? 'selected' : '' }}>S.Psi (Sarjana Psikologi)</option>
                                <option value="S.Kom" {{ old('gelar_belakang') === 'S.Kom' ? 'selected' : '' }}>S.Kom (Sarjana Komputer)</option>
                                <option value="S.T" {{ old('gelar_belakang') === 'S.T' ? 'selected' : '' }}>S.T (Sarjana Teknik)</option>
                                <option value="S.E" {{ old('gelar_belakang') === 'S.E' ? 'selected' : '' }}>S.E (Sarjana Ekonomi)</option>
                                <option value="S.Si" {{ old('gelar_belakang')  === 'S.Si' ? 'selected' : '' }}>S.Si (Sarjana Sains)</option>
                                <option value="S.H" {{ old('gelar_belakang') === 'S.H' ? 'selected' : '' }}>S.H (Sarjana Hukum)</option>
                                <option value="S.Farm" {{ old('gelar_belakang') === 'S.Farm' ? 'selected' : '' }}>S.Farm (Sarjana Farmasi)</option>
                                <option value="S.Ked" {{ old('gelar_belakang') === 'S.Ked' ? 'selected' : '' }}>S.Ked (Sarjana Kedokteran)</option>
                                <option value="S.Sos" {{ old('gelar_belakang') === 'S.Sos' ? 'selected' : '' }}>S.Sos (Sarjana Sosial)</option>
                                <option value="S.Sn" {{ old('gelar_belakang') === 'S.Sn' ? 'selected' : '' }}>S.Sn (Sarjana Seni)</option>
                                <option value="M.Pd" {{ old('gelar_belakang') === 'M.Pd' ? 'selected' : '' }}>M.Pd (Magister Pendidikan)</option>
                                <option value="M.Psi" {{ old('gelar_belakang') === 'M.Psi' ? 'selected' : '' }}>M.Psi (Magister Psikologi)</option>
                                <option value="M.Kom" {{ old('gelar_belakang') === 'M.Kom' ? 'selected' : '' }}>M.Kom (Magister Komputer)</option>
                                <option value="M.E" {{ old('gelar_belakang') === 'M.E' ? 'selected' : '' }}>M.E (Magister Ekonomi)</option>
                                <option value="M.T" {{ old('gelar_belakang') === 'M.T' ? 'selected' : '' }}>M.T (Magister Teknik)</option>
                                <option value="M.Si" {{ old('gelar_belakang')  === 'M.Si' ? 'selected' : '' }}>M.Si (Magister Sains)</option>
                                <option value="M.H" {{ old('gelar_belakang') === 'M.H' ? 'selected' : '' }}>M.H (Magister Hukum)</option>
                                <option value="M.Farm" {{ old('gelar_belakang') === 'M.Farm' ? 'selected' : '' }}>M.Farm (Magister Farmasi)</option>
                                <option value="M.Ked" {{ old('gelar_belakang') === 'M.Ked' ? 'selected' : '' }}>M.Ked (Magister Kedokteran)</option>
                                <option value="M.Sos" {{ old('gelar_belakang') === 'M.Sos' ? 'selected' : '' }}>M.Sos (Magister Sosial)</option>
                                <option value="M.Sn" {{ old('gelar_belakang') === 'M.Sn' ? 'selected' : '' }}>M.Sn (Magister Seni)</option>
                                <option value="Lainnya" {{ old('gelar_belakang') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <input type="text" name="gelar_belakang_lainnya" class="form-control mt-2" maxlength="50" placeholder="Masukkan Gelar Belakang lainnya" style="{{ old('gelar_belakang') === 'Lainnya' ? 'display: block;' : 'display: none;' }}" value="{{ old('gelar_belakang_lainnya') }}">
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

                <!-- Data Kepegawaian -->
                <div class="row mt-5">
                    <h4 class="col-12">Data Kepegawaian</h4>
                    <!-- Foto Pegawai and NIP -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_pegawai">Foto Pegawai <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_pegawai" class="form-control @error('foto_pegawai') is-invalid @enderror">
                            @error('foto_pegawai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_kepegawaian">Status Kepegawaian<span class="text-danger">*</span></label>
                            <select name="status_kepegawaian" class="form-select" required>
                                <option value="ASN">ASN</option>
                                <option value="Non-ASN">Non-ASN</option>
                                <option value="Honorer">Honorer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" maxlength="18" placeholder="Masukkan NIP" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SK Pengangkatan and Status Kepegawaian -->
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="no_sk_pengangkatan">Nomor SK Pengangkatan</label>
                            <input type="text" name="no_sk_pengangkatan" class="form-control @error('no_sk_pengangkatan') is-invalid @enderror" maxlength="50" required placeholder="Masukkan No SK Pengangkatan" value="{{ old('no_sk_pengangkatan', '') }}">
                            @error('no_sk_pengangkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="tgl_pengangkatan">Tanggal Pengangkatan</label>
                            <input type="date" name="tgl_pengangkatan" class="form-control @error('tgl_pengangkatan') is-invalid @enderror" required value="{{ old('tgl_pengangkatan', '') }}">
                            @error('tgl_pengangkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Pangkat and Pegawai -->
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="pangkat">Pangkat</label>
                            <select name="pangkat" class="form-select">
                                <option value="">Pilih Pangkat</option>
                                <option value="Juru Muda" {{ old('pangkat') === 'Juru Muda' ? 'selected' : '' }}>Juru Muda</option>
                                <option value="Juru Muda Tingkat I" {{ old('pangkat') === 'Juru Muda Tingkat I' ? 'selected' : '' }}>Juru Muda Tingkat I</option>
                                <option value="Juru" {{ old('pangkat') === 'Juru' ? 'selected' : '' }}>Juru</option>
                                <option value="Juru Tingkat I" {{ old('pangkat') === 'Juru Tingkat I' ? 'selected' : '' }}>Juru Tingkat I</option>
                                <option value="Penata Muda" {{ old('pangkat') === 'Penata Muda' ? 'selected' : '' }}>Penata Muda</option>
                                <option value="Penata Muda Tingkat I" {{ old('pangkat') === 'Penata Muda Tingkat I' ? 'selected' : '' }}>Penata Muda Tingkat I</option>
                                <option value="Pengatur" {{ old('pangkat') === 'Pengatur' ? 'selected' : '' }}>Pengatur</option>
                                <option value="Pengatur Tingkat I" {{ old('pangkat') === 'Pengatur Tingkat I' ? 'selected' : '' }}>Pengatur Tingkat I</option>
                                <option value="Pembina" {{ old('pangkat') === 'Pembina' ? 'selected' : '' }}>Pembina</option>
                                <option value="Pembina Tingkat I" {{ old('pangkat') === 'Pembina Tingkat I' ? 'selected' : '' }}>Pembina Tingkat I</option>
                                <!-- Add more options as necessary -->
                            </select>
                        </div>
                    </div>

                    <!-- Golongan and Status Pegawai -->
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="golongan">Golongan</label>
                            <select name="golongan" class="form-select">
                                <option value="">Pilih Golongan</option>
                                <option value="I/a" {{ old('golongan') === 'I/a' ? 'selected' : '' }}>I/a</option>
                                <option value="I/b" {{ old('golongan') === 'I/b' ? 'selected' : '' }}>I/b</option>
                                <option value="I/c" {{ old('golongan') === 'I/c' ? 'selected' : '' }}>I/c</option>
                                <option value="I/d" {{ old('golongan') === 'I/d' ? 'selected' : '' }}>I/d</option>
                                <option value="II/a" {{ old('golongan') === 'II/a' ? 'selected' : '' }}>II/a</option>
                                <option value="II/b" {{ old('golongan') === 'II/b' ? 'selected' : '' }}>II/b</option>
                                <option value="II/c" {{ old('golongan') === 'II/c' ? 'selected' : '' }}>II/c</option>
                                <option value="II/d" {{ old('golongan') === 'II/d' ? 'selected' : '' }}>II/d</option>
                                <option value="III/a" {{ old('golongan') === 'III/a' ? 'selected' : '' }}>III/a</option>
                                <option value="III/b" {{ old('golongan') === 'III/b' ? 'selected' : '' }}>III/b</option>
                                <option value="III/c" {{ old('golongan') === 'III/c' ? 'selected' : '' }}>III/c</option>
                                <option value="III/d" {{ old('golongan') === 'III/d' ? 'selected' : '' }}>III/d</option>
                                <option value="IV/a" {{ old('golongan') === 'IV/a' ? 'selected' : '' }}>IV/a</option>
                                <option value="IV/b" {{ old('golongan') === 'IV/b' ? 'selected' : '' }}>IV/b</option>
                                <option value="IV/c" {{ old('golongan') === 'IV/c' ? 'selected' : '' }}>IV/c</option>
                                <option value="IV/d" {{ old('golongan') === 'IV/d' ? 'selected' : '' }}>IV/d</option>
                                <!-- Add more options as necessary -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="status_pegawai">Status Pegawai<span class="text-danger">*</span></label>
                            <select name="status_pegawai" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
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
                            @error('foto_ijazah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_ktp" class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*" value="{{ old('foto_ktp') }}">
                            @error('foto_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="foto_kk">Foto Kartu Keluarga <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_kk" class="form-control @error('foto_kk') is-invalid @enderror" accept="image/*" value="{{ old('foto_kk') }}">
                            @error('foto_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="foto_akte_kelahiran">Foto Akte Kelahiran <small class="text-danger">*Harus berupa file jpg/jpeg/png & tidak boleh lebih dari 2MB</small></label>
                            <input type="file" name="foto_akte_kelahiran" class="form-control @error('foto_akte_kelahiran') is-invalid @enderror" accept="image/*" value="{{ old('foto_akte_kelahiran') }}">
                            @error('foto_akte_kelahiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Data Password -->
                <div class="row mt-5">
                    <h4 class="col-12">Data Password</h4>
                    <div class="col-md-6">
                        <label for="password">Password <small class="text-danger">*Minimal 6 karakter</small></label>
                        <div class="form-group input-group input-group-merge">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="6" id="password" value="{{ old('password') }}" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="input-group-text cursor-pointer" onclick="togglePassword('password')"><i class="bx bx-hide" id="passwordEye"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="form-group input-group input-group-merge">
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required minlength="6" id="password_confirmation" value="{{ old('password_confirmation') }}" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="input-group-text cursor-pointer" onclick="togglePassword('password_confirmation')"><i class="bx bx-hide" id="passwordConfirmationEye"></i></span>
                        </div>
                    </div>
                </div>
                <script>
                    function togglePassword(id) {
                        const input = document.getElementById(id);
                        const eye = document.getElementById(`${id}Eye`);

                        if (input.type === 'password') {
                            input.type = 'text';
                            eye.classList.remove('bx-hide');
                            eye.classList.add('bx-show');
                        } else {
                            input.type = 'password';
                            eye.classList.remove('bx-show');
                            eye.classList.add('bx-hide');
                        }
                    }
                </script>
            
                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Simpan Data
                        </button>
                    </div>
                </div>            
                <script>
                    const submitBtn = document.getElementById('submitBtn');
                    const spinner = submitBtn.querySelector('.spinner-border');

                    submitBtn.addEventListener('click', function() {
                        spinner.classList.remove('d-none');
                    });
                </script>            
            </form>            
        </div>
    </div>
</div>

@endsection