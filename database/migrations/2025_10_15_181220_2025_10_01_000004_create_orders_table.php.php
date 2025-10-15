<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_location_id')->nullable()->constrained('pickup_locations')->nullOnDelete();
            // receiver
            $table->foreignId('receiver_id')->nullable()->constrained('receivers')->nullOnDelete();

            $table->string('tracking_number')->unique()->nullable();
            $table->decimal('cod_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->nullable();
            
            $table->string('pickup_address')->nullable();
            $table->string('delivery_address')->nullable();
            $table->decimal('weight_kg', 8, 2)->nullable();

            // timestamps for analytics
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('hub_received_at')->nullable();
            $table->timestamp('hub_dispatched_at')->nullable();
            $table->timestamp('out_for_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
