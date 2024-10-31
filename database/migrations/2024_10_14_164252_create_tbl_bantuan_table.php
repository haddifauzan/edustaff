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
        Schema::create('tbl_bantuan', function (Blueprint $table) {
            $table->integer('id_bantuan')->primary();
            $table->timestamp('waktu_permintaan');
            $table->enum('kategori', ['teknis', 'akses', 'lainnya']);
            $table->text('isi_bantuan')->nullable(); 
            $table->string('foto_masalah'); 
            $table->enum('status_bantuan', ['menunggu', 'diproses', 'selesai']);
            $table->text('respons')->nullable();
            $table->time('waktu_respons')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_operator')->nullable();

            // Menambahkan foreign key constraints jika diperlukan
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tbl_pegawai');
            $table->foreign('id_operator')->references('id_user')->on('tbl_user'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bantuan');
    }
};
