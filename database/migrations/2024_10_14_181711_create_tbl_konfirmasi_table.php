<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_konfirmasi', function (Blueprint $table) {
            $table->bigIncrements('id_konfirmasi');
            $table->json('kolom_diubah');
            $table->enum('status_konfirmasi', ['menunggu', 'ditolak', 'disetujui']);
            $table->timestamp('waktu_pengajuan');
            $table->timestamp('waktu_respon')->nullable();
            $table->text('pesan_operator')->nullable();
            $table->bigInteger('id_operator')->unsigned();
            $table->bigInteger('id_pegawai')->unsigned();

            // Menambahkan foreign key constraints
            $table->foreign('id_operator')->references('id_user')->on('tbl_user');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tbl_pegawai'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_konfirmasi');
    }
};
