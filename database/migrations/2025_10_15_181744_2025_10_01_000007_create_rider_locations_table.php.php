<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rider_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_id')->constrained('users')->onDelete('cascade');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 11, 8);
            $table->enum('status', ['idle', 'to_pickup', 'to_hub', 'to_delivery', 'returning'])->default('idle');
            $table->decimal('speed_kmh', 6, 2)->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rider_locations');
    }
};
