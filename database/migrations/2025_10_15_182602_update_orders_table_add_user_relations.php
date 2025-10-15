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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'sender_id')) {
                $table->foreignId('sender_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('orders', 'rider_id')) {
                $table->foreignId('rider_id')->nullable()->after('sender_id')->constrained('users')->onDelete('set null');
            }


            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', ['created',
                'picked_up',
                'hub_received',
                'hub_dispatched',
                'out_for_delivery',
                'delivered',
                'returned',
                'cancelled'])->default('created')->after('total_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['rider_id']);
            $table->dropColumn(['sender_id', 'rider_id', 'status']);
        });
    }
};
