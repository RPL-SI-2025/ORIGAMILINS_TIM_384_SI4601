<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel.
     */
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_event');
            $table->text('deskripsi')->nullable(); 
            $table->date('tanggal_pelaksanaan'); 
            $table->decimal('harga', 10, 2)->default(0); 
            $table->string('lokasi'); 
            $table->string('poster')->nullable();
            $table->integer('kuota')->default(0);
            $table->integer('kuota_terisi')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Mengembalikan perubahan saat rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('event'); 
    }
};
