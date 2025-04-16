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
    Schema::table('user_profiles', function (Blueprint $table) {
        if (!Schema::hasColumn('user_profiles', 'nama_lengkap')) {
            $table->string('nama_lengkap');
        }
        if (!Schema::hasColumn('user_profiles', 'nama_panggilan')) {
            $table->string('nama_panggilan');
        }
        if (!Schema::hasColumn('user_profiles', 'no_hp')) {
            $table->string('no_hp');
        }
        if (!Schema::hasColumn('user_profiles', 'email')) {
            $table->string('email');
        }
        if (!Schema::hasColumn('user_profiles', 'foto')) {
            $table->string('foto')->nullable();
        }
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
