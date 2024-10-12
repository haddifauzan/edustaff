<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_riwayat_jabatan', function (Blueprint $table) {
            $table->id('id_riwayat_jabatan'); 
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable(); 
            $table->softDeletes(); 
            $table->timestamps(); 
            $table->unsignedBigInteger('id_pegawai'); 
            $table->unsignedBigInteger('id_jabatan'); 

            $table->foreign('id_pegawai')->references('id_pegawai')->on('tbl_pegawai')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('tbl_jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_riwayat_jabatan');
    }
};