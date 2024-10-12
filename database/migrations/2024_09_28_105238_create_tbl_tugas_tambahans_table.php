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
        Schema::create('tbl_tugas_tambahan', function (Blueprint $table) {
            $table->id('id_tugas_tambahan');
            $table->string('nama_tugas');
            $table->string('deskripsi_tugas');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->unsignedBigInteger('id_pegawai');

            // Foreign key ke tabel pegawai
            $table->foreign('id_pegawai')
                  ->references('id_pegawai')
                  ->on('tbl_pegawai')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_tugas_tambahan');
    }
};