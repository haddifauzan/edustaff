<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->id('id_user'); // Primary key
            $table->string('nama_user', 100); // Nama lengkap user
            $table->string('email')->unique(); // Email user yang harus unik
            $table->string('password'); // Password untuk login
            $table->enum('role', ['Admin', 'Operator', 'Pegawai']); // Peran user
            $table->enum('status_akun', ['Aktif', 'Non-Aktif']); // Status akun
            $table->string('no_hp', 15); // Nomor telepon
            $table->string('foto_profil')->nullable(); // Foto profil user (opsional)
            $table->timestamp('last_login')->nullable(); // Waktu login terakhir (opsional)
            $table->foreignId('id_pegawai')->nullable()->constrained('tbl_pegawai', 'id_pegawai')->onDelete('set null'); // Relasi ke tabel pegawai (null jika bukan pegawai)

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
        Schema::dropIfExists('tbl_user');
    }
}

