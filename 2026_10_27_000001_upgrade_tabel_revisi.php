<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi susulan (tanpa menghapus data): menambahkan tabel/kolom baru dari revisi.
 * Aman dijalankan berkali-kali & aman bila database dibuat dengan migrate:fresh
 * (setiap langkah dicek dulu: hanya dibuat jika belum ada).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('registrations', 'reject_reason')) {
            Schema::table('registrations', fn (Blueprint $t) => $t->text('reject_reason')->nullable()->after('status'));
        }

        if (!Schema::hasColumn('schedules', 'is_fixed')) {
            Schema::table('schedules', function (Blueprint $t) {
                $t->boolean('is_fixed')->default(false);
                $t->string('series')->nullable()->index();
            });
        }

        $addedIsAll = false;
        if (!Schema::hasColumn('announcements', 'is_all')) {
            Schema::table('announcements', fn (Blueprint $t) => $t->boolean('is_all')->default(true));
            $addedIsAll = true;
        }

        if (!Schema::hasTable('announcement_ekskul')) {
            Schema::create('announcement_ekskul', function (Blueprint $t) {
                $t->foreignId('announcement_id')->constrained()->cascadeOnDelete();
                $t->foreignId('ekskul_id')->constrained()->cascadeOnDelete();
                $t->primary(['announcement_id', 'ekskul_id']);
            });
        }

        // Pengumuman lama yang punya satu ekskul tujuan -> pindahkan ke tabel tujuan (checkbox)
        if ($addedIsAll) {
            $old = DB::table('announcements')->where('type', 'pengumuman')->whereNotNull('ekskul_id')->get();
            foreach ($old as $a) {
                DB::table('announcement_ekskul')->insertOrIgnore(['announcement_id' => $a->id, 'ekskul_id' => $a->ekskul_id]);
                DB::table('announcements')->where('id', $a->id)->update(['is_all' => false, 'ekskul_id' => null]);
            }
        }

        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $t) {
                $t->id();
                $t->string('key')->unique();
                $t->text('value')->nullable();
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        // sengaja kosong: perubahan ini hanya menambah struktur
    }
};
