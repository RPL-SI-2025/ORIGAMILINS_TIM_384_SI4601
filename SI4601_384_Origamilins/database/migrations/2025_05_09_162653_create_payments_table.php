<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('nama')->after('order_id');
            $table->decimal('total', 10, 2)->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn(['nama', 'total']);
    });
}
};
