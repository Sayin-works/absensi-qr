<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //$table->unsignedBigInteger('walimurid_id')->nullable()->after('qr_code_id');
            //$table->foreign('walimurid_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['walimurid_id']);
            $table->dropColumn('walimurid_id');
        });
    }
};
