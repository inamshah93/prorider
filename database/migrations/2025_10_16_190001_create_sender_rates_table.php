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
    Schema::create('sender_rates', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->decimal('delivery_rate', 10, 2)->default(250);  // delivery charge
        $table->decimal('return_rate', 10, 2)->default(100);    // return order charge
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('sender_rates');
}
};
