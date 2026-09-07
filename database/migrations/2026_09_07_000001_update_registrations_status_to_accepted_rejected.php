<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });

            DB::table('registrations')
                ->whereIn('status', ['aktif', 'diterima', 'ditolak'])
                ->update(['status' => 'diterima']);

            DB::table('registrations')
                ->whereNull('status')
                ->update(['status' => 'pending']);

            return;
        }

        DB::statement("ALTER TABLE registrations MODIFY status ENUM('pending','diterima','ditolak') NOT NULL DEFAULT 'pending'");

        DB::table('registrations')
            ->where('status', 'aktif')
            ->update(['status' => 'diterima']);
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE registrations MODIFY status ENUM('aktif','pending') NOT NULL DEFAULT 'aktif'");
    }
};
