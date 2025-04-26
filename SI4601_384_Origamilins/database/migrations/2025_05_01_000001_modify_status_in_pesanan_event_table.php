<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan_event', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pesanan_event', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Belum Berjalan',
                'Sedang Berjalan',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu')->after('nama_event');
        });
    }

    public function down()
    {
        Schema::table('pesanan_event', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pesanan_event', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Dikonfirmasi', 'Selesai', 'Dibatalkan'])
                ->default('Menunggu')
                ->after('nama_event');
        });
    }
}; 