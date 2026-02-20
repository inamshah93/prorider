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
        $table->decimal('delivery_rate', 10, 2)->default(0)->after('total_amount');
        $table->decimal('return_rate', 10, 2)->default(0)->after('delivery_rate');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['delivery_rate', 'return_rate']);
    });
}
};
