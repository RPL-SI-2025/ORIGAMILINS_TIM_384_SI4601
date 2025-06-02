<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');
            $table->integer('jumlah_tiket');
            $table->string('metode_pembayaran');
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_registrations');
    }
}