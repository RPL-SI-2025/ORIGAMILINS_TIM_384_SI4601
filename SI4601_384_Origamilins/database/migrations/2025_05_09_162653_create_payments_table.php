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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            // Tambahkan kolom lain yang relevan di sini (misal: user_id, order_id, dll.)
            $table->string('order_id')->nullable(); // Contoh kolom order_id, sesuaikan jika nama kolom berbeda
            $table->string('nama'); // Kolom nama
            $table->decimal('total', 10, 2); // Kolom total
            // ... tambahkan kolom lain sesuai kebutuhan tabel payments
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
