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
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // sender reference
            $table->string('name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete(); // optional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};
