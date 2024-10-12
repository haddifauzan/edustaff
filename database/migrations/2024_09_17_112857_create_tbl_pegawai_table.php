<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pegawai', function (Blueprint $table) {
            $table->id('id_pegawai'); // Primary key
            $table->string('nik', 16)->unique(); // NIK dengan panjang 16 karakter
            $table->string('nama_pegawai', 100); // Nama pegawai
            $table->enum('jenis_kelamin', ['L', 'P']); // Jenis kelamin (Laki-laki/Perempuan)
            $table->string('tempat_lahir', 100); // Tempat lahir
            $table->date('tanggal_lahir'); // Tanggal lahir
            $table->text('alamat'); // Alamat pegawai
            $table->string('agama', 50); // Agama pegawai
            $table->enum('status_pernikahan', ['Menikah', 'Belum Menikah', 'Cerai']); // Status pernikahan
            $table->string('foto_pegawai')->nullable(); // Foto pegawai (opsional)
            $table->string('nip', 18)->nullable(); // NIP (opsional)
            $table->string('no_sk_pengangkatan', 50); // Nomor SK Pengangkatan
            $table->date('tgl_pengangkatan'); // Tanggal pengangkatan
            $table->enum('status_kepegawaian', ['ASN', 'Non-ASN', 'Honorer']); // Status kepegawaian
            $table->string('pangkat', 50); // Pangkat pegawai
            $table->integer('masa_kerja')->unsigned(); // Masa kerja (tahun)
            $table->string('no_tlp', 15); // Nomor telepon
            $table->string('email')->unique(); // Email pegawai
            $table->string('pendidikan_terakhir', 50); // Pendidikan terakhir
            $table->year('tahun_lulus'); // Tahun lulus pendidikan terakhir
            $table->string('gelar_depan', 50)->nullable(); // Gelar depan (opsional)
            $table->string('gelar_belakang', 50)->nullable(); // Gelar belakang (opsional)
            $table->enum('status_pegawai', ['Aktif', 'Non-Aktif']); // Status pegawai
            $table->string('foto_ijazah')->nullable(); // Foto ijazah (opsional)
            $table->string('foto_ktp')->nullable(); // Foto KTP (opsional)
            $table->string('foto_kk')->nullable(); // Foto Kartu Keluarga (opsional)
            $table->string('foto_akte_kelahiran')->nullable(); // Foto akte kelahiran (opsional)
            $table->foreignId('id_jabatan')->nullable()->constrained('tbl_jabatan', 'id_jabatan')->onDelete('set null'); // Relasi ke tabel jabatan
            $table->softDeletes(); // Soft delete
            $table->timestamp('expired_at')->nullable(); // Jabatan expired (opsional)

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pegawai');
    }
}
