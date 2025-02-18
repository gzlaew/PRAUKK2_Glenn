<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->bigIncrements('id_jk'); // Primary key benar
            $table->enum('bagian', ['pagi', 'siang', 'malam']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date('shift_date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_jk'); // Foreign key ke jam_kerja
            $table->timestamps();

            $table->foreign('id_jk')->references('id_jk')->on('jam_kerja')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('jam_kerja');
    }
};
