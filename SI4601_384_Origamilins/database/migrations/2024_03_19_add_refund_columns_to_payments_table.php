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
        Schema::table('payments', function (Blueprint $table) {
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('payments', 'status')) {
                $table->string('status')->default('pending')->after('total');
            }
            
            // Add refund-related columns
            $table->string('refund_reason')->nullable()->after('status');
            $table->timestamp('refunded_at')->nullable()->after('refund_reason');
            $table->timestamp('refund_rejected_at')->nullable()->after('refunded_at');
            $table->json('refund_metadata')->nullable()->after('refund_rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'refund_reason',
                'refunded_at',
                'refund_rejected_at',
                'refund_metadata'
            ]);
        });
    }
}; 