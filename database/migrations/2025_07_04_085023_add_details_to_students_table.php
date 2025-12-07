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
            Schema::table('students', function (Blueprint $table) {
        $table->string('nisn')->unique()->nullable();
        $table->enum('gender', ['L', 'P'])->nullable();
        $table->string('birth_place')->nullable();
        $table->date('birth_date')->nullable();
        $table->text('address')->nullable();
        $table->string('religion')->nullable();
        $table->string('phone')->nullable();
        $table->enum('status', ['aktif', 'lulus', 'keluar'])->default('aktif');
        $table->string('photo')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
