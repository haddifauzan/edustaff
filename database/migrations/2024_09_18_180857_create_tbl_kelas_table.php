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
            $table->id();
            $table->string('nama_kelas'); // Contoh: X IPA 1, XI IPS 2
            $table->string('tingkat'); // Contoh: X, XI, XII
            $table->unsignedBigInteger('id_walikelas')->nullable(); // ID walikelas dari pegawai (opsional)
            $table->timestamps();

            // Foreign key untuk wali kelas (berhubungan dengan tabel pegawai)
            $table->foreign('id_walikelas')->references('id')->on('tbl_pegawai')->onDelete('set null');
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
