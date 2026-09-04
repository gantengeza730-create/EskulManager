<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('attendance_records', 'proof')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                $table->text('proof')->nullable()->after('status');
            });
        }

        DB::statement("ALTER TABLE attendance_records MODIFY status ENUM('hadir', 'sakit_izin', 'tidak_hadir') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE attendance_records MODIFY status ENUM('hadir', 'tidak_hadir') NOT NULL");

        if (Schema::hasColumn('attendance_records', 'proof')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                $table->dropColumn('proof');
            });
        }
    }
};