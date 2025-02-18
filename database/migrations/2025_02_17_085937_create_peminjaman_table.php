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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id');
            $table->enum('jenis_barang', ['alat', 'sparepart']);
            $table->integer('jumlah');
            $table->boolean('dikembalikan')->default(false);
            $table->timestamps();

            // Pastikan foreign key benar
            $table->foreign('barang_id')->references('id_sparepart')->on('spareparts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
