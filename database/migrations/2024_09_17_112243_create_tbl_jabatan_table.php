<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jabatan', function (Blueprint $table) {
            $table->id('id_jabatan'); // Primary key
            $table->string('nama_jabatan', 100); // Nama jabatan, max 100 karakter
            $table->text('deskripsi_jabatan')->nullable(); // Deskripsi jabatan, opsional
            $table->string('golongan', 50); // Golongan jabatan
            $table->integer('level_jabatan'); // Level jabatan (misalnya: 1 untuk yang terendah)
            $table->softDeletes(); // Kolom deleted_at untuk soft delete
            $table->timestamp('expired_at')->nullable(); // Kolom untuk expired date jika jabatan memiliki batas waktu
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_jabatan');
    }
}
