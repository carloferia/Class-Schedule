<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('day_of_week')->nullable()->after('category');
            $table->string('room')->nullable()->after('day_of_week');
            $table->time('start_time')->nullable()->after('room');
            $table->time('end_time')->nullable()->after('start_time');
            $table->string('teacher')->nullable()->after('end_time');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['day_of_week', 'room', 'start_time', 'end_time', 'teacher']);
        });
    }
};
