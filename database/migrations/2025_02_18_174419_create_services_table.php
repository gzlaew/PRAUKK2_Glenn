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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor');
            $table->string('nama_customer');
            $table->text('keluhan');
            $table->string('nomor_hp');
            $table->json('spareparts');
            $table->decimal('harga_sparepart', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['Waiting', 'Proses', 'Selesai'])->default('Waiting');
            $table->foreignId('user_id')->constrained('users');
            $table->string('estimasi_selesai'); // Perubahan dari timestamp ke string biasa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
