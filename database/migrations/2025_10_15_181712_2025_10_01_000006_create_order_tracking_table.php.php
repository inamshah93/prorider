<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // who scanned / updated
            $table->enum('event', ['created','picked_up','hub_received','hub_dispatched','out_for_delivery','delivered','returned','cancelled']);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->string('device_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('event_time')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_tracking');
    }
};
