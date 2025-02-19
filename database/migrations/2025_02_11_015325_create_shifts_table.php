<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();                         // primary key
            $table->foreignId('user_id')          // kolom user_id
                ->constrained('users')          // referensi ke tabel users
                ->onDelete('cascade');          // opsi jika user dihapus

            // shift_date bisa menggunakan tipe 'date'
            // atau 'datetime' tergantung kebutuhan Anda.
            $table->date('shift_date');

            // id_jk merujuk ke kolom id_jk di tabel jam_kerjas
            // jika Anda ingin menambahkan constraint foreign key:
            $table->unsignedBigInteger('id_jk');
            $table->foreign('id_jk')
                ->references('id_jk')
                ->on('jam_kerjas')
                ->onDelete('cascade');

            $table->timestamps();                 // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
