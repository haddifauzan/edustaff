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
        Schema::create('tbl_jurusan', function (Blueprint $table) {
            $table->bigIncrements('id_jurusan');
            $table->string('nama_jurusan', 100);
            $table->string('kode_jurusan', 10);
            $table->text('deskripsi_jurusan')->nullable();
            $table->unsignedBigInteger('kepala_jurusan')->nullable();
            $table->integer('jumlah_siswa')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('kepala_jurusan')
                ->references('id_pegawai')
                ->on('tbl_pegawai')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jurusan');
    }
};
