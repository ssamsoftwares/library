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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('personal_number')->unique();
            $table->string('emergency_number')->nullable();
            $table->string('dob')->nullable();
            $table->string('course')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('subscription')->nullable();
            $table->string('remark_singnature')->nullable();
            $table->string('hall_number')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('aadhar_number')->unique();
            $table->string('aadhar_front_img')->nullable();
            $table->string('aadhar_back_img')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
