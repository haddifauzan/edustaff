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
        Schema::create('tbl_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('user_id')->nullable(); // ID user yang melakukan aksi
            $table->string('action'); // Aksi yang dilakukan (create, update, delete, dsb)
            $table->string('model')->nullable(); // Model yang terpengaruh
            $table->json('data')->nullable(); // Data yang berubah (opsional)
            $table->string('ip_address', 45)->nullable(); // Alamat IP user
            $table->text('user_agent')->nullable(); // User agent (browser, OS)
            $table->timestamps(); // created_at dan updated_at

            // Relasi ke tabel users (jika ada)
            $table->foreign('user_id')->references('id_user')->on('tbl_user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_log');
    }
};