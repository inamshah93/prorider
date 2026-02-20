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
        Schema::create('sender_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('business_name')->nullable();
            $table->string('contact_person')->nullable();

            // Default pickup location (nullable, since not all senders may have one initially)
            $table->foreignId('default_pickup_location_id')
                ->nullable()
                ->constrained('pickup_locations')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sender_profiles');
    }
};
