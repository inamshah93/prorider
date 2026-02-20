<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // insert defaults
        DB::table('settings')->insert([
            ['key' => 'rider_commission_percent', 'value' => '60'],
            ['key' => 'default_delivery_rate', 'value' => '150'],
            ['key' => 'default_return_rate', 'value' => '100'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
