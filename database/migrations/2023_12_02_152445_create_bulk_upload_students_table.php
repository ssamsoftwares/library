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
        Schema::create('bulk_upload_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string('name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('course')->nullable();
            $table->string('graduation')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_upload_students');
    }
};
