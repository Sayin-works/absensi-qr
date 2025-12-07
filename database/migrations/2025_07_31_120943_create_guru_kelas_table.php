<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('guru_kelas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // guru
        $table->unsignedBigInteger('classroom_id'); // kelas
        $table->timestamps();

        // Relasi
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('classroom_id')->references('id')->on('classes')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('guru_kelas');
}

};
