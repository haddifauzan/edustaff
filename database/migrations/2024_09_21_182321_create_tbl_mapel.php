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
        Schema::create('tbl_mapel', function (Blueprint $table) {
            $table->id('id_pelajaran');
            $table->string('nama_pelajaran');
            $table->string('kode_pelajaran');
            $table->text('deskripsi')->nullable();
            $table->string('kelas');
            $table->string('jurusan');
            $table->softDeletes();  // For deleted_at
            $table->timestamp('expired_at')->nullable();
            $table->unsignedBigInteger('id_pegawai')->nullable();
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tbl_pegawai')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mapel');
    }
};
