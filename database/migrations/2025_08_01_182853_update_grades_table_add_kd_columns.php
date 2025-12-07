<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            // Tambahkan kolom KD 1 - KD 8
            for ($i = 1; $i <= 8; $i++) {
                $table->string("kd$i")->nullable()->after('nilai_akhir'); 
            }

            // Pastikan kolom uts, uas tetap ada
            if (!Schema::hasColumn('grades', 'nilai_uts')) {
                $table->integer('nilai_uts')->nullable();
            }
            if (!Schema::hasColumn('grades', 'nilai_uas')) {
                $table->integer('nilai_uas')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            for ($i = 1; $i <= 8; $i++) {
                $table->dropColumn("kd$i");
            }
        });
    }
};
