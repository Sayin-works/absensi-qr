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
            $table->string('qr_code_id')->unique();

            // Relasi ke classrooms
            $table->unsignedBigInteger('class_id')->nullable(); // pakai 'class_id' untuk konsisten dengan model
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');

            // Relasi ke user (walimurid)
            $table->unsignedBigInteger('walimurid_id')->nullable();
            $table->foreign('walimurid_id')->references('id')->on('users')->onDelete('set null');

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
