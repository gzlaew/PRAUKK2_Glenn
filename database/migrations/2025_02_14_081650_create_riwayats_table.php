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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id('id_riwayat'); // Primary Key
            $table->unsignedBigInteger('sparepart_id');
            $table->unsignedBigInteger('user_id');
            $table->string('aksi'); // Tambah, Edit, Hapus
            $table->text('data_lama')->nullable(); // JSON perubahan sebelum edit
            $table->text('data_baru')->nullable(); // JSON perubahan setelah edit
            $table->string('perubahan')->nullable(); // Deskripsi perubahan
            $table->timestamps();

            // Foreign Key
            $table->foreign('sparepart_id')->references('id_sparepart')->on('spareparts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
