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
    Schema::create('sensor_readings', function (Blueprint $table) {
        $table->id();
        $table->decimal('ph_level', 5, 2)->nullable();      // e.g. 7.24
        $table->decimal('turbidity', 8, 2)->nullable();    // NTU
        $table->decimal('tds', 8, 2)->nullable();         // ppm
        $table->string('status')->default('normal');       // normal / warning / danger
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
