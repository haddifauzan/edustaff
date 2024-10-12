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
        Schema::create('tbl_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_kelas');
            $table->string('nama_kelas');
            $table->integer('tingkat');
            $table->unsignedBigInteger('id_walikelas')->nullable(); // Sesuaikan tipe data
            $table->foreign('id_walikelas')->references('id_pegawai')->on('tbl_pegawai')->onDelete('set null');
            $table->softDeletes(); // Tambahkan soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kelas');
    }
};
