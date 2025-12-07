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
Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->foreignId('class_id')->constrained()->onDelete('cascade');
    $table->string('semester');
    
    // JSON untuk menyimpan semua nilai tugas
    $table->json('nilai_tugas')->nullable();

    // Nilai UTS, UAS, dan Nilai Akhir
    $table->integer('nilai_uts')->nullable();
    $table->integer('nilai_uas')->nullable();
    $table->integer('nilai_akhir')->nullable();
    
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
