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
        Schema::create('tbl_prestasi_pegawai', function (Blueprint $table) {
            $table->integer('id_prestasi')->primary();
            $table->string('nama_prestasi');
            $table->string('deskripsi_prestasi');
            $table->date('tgl_dicapai');
            $table->string('foto_sertifikat');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak']);
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at
            $table->timestamp('expired_at')->nullable();
            $table->unsignedBigInteger('id_pegawai')->unsigned();

            // Menambahkan foreign key constraints
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tbl_pegawai'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_prestasi_pegawai');
    }
};
