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
        Schema::create('tbl_pangkat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pangkat'); // Contoh: Guru Pertama, Guru Muda
            $table->string('golongan'); // Contoh: III/a, III/b, dsb.
            $table->string('keterangan')->nullable(); // Keterangan tambahan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pangkat');
    }
};
