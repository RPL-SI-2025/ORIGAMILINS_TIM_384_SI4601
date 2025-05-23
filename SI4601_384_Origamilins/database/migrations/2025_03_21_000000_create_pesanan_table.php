<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('pengrajin_id')->nullable()->constrained('pengrajin')->onDelete('set null');
            $table->integer('jumlah');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', [
                'Rencana',
                'Dalam Proses',
                'Siap Dikirim',
                'Dikirim',
                'Selesai',
                'Dibatalkan'
            ])->default('Rencana');
            $table->string('ekspedisi')->nullable();
            $table->string('nomor_resi')->nullable();
            $table->text('alamat_pengiriman');
            $table->string('nomor_telepon');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_pesanan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
}; 