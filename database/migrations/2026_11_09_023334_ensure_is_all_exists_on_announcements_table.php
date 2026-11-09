<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('announcements', 'is_all')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->boolean('is_all')->default(true)->after('body');
            });

            // Keep existing records compatible with current announcement targeting logic.
            DB::table('announcements')->update(['is_all' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('announcements', 'is_all')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->dropColumn('is_all');
            });
        }
    }
};
