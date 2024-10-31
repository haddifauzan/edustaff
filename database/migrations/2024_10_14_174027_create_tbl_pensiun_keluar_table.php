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
        Schema::create('tbl_pensiun_keluar', function (Blueprint $table) {
            $table->bigIncrements('id_pensiun_keluar');
            $table->date('tgl_pengajuan');
            $table->date('tgl_berlaku');
            $table->enum('jenis_keluar', ['pensiun', 'resign', 'diberhentikan', 'dipindahkan']);
            $table->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak'])->nullable();
            $table->text('alasan');
            $table->enum('pengaju', ['pegawai', 'operator']);
            $table->string('keterangan_tambahan')->nullable();
            $table->unsignedBigInteger('id_operator')->nullable();
            $table->unsignedBigInteger('id_pegawai');
            $table->timestamps(); // created_at dan updated_at

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
        Schema::dropIfExists('tbl_pensiun_keluar');
    }
};
