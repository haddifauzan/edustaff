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
        Schema::create('tbl_mapel_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_mapel_kelas');
            $table->foreignId('id_pelajaran')->constrained('tbl_mapel')->onDelete('cascade');
            $table->foreignId('id_kelas')->constrained('tbl_kelas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mapel_kelas');
    }
};
