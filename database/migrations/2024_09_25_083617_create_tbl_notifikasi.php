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
        Schema::create('tbl_notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->string('judul');
            $table->text('pesan')->nullable();
            $table->string('link')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamp('tanggal_kirim')->nullable(); 
            $table->unsignedBigInteger('id_user')->nullable(); // Untuk notifikasi ke satu user
            $table->boolean('semua_pegawai')->default(false); // Untuk notifikasi ke semua pegawai

            $table->foreign('id_user')->references('id_user')->on('tbl_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notifikasi');
    }
};
