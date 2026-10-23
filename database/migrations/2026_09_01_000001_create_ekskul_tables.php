<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambah kolom peran & data siswa pada tabel users bawaan Laravel
        Schema::table('users', function (Blueprint $t) {
            $t->string('role')->default('siswa')->after('password'); // admin | pembina | siswa
            $t->string('nis')->nullable()->unique()->after('role');
            $t->string('kelas')->nullable()->after('nis');
            $t->string('phone')->nullable()->after('kelas');
            $t->boolean('is_active')->default(true)->after('phone');
            $t->string('verification_code', 6)->nullable()->after('is_active');
        });

        Schema::create('ekskuls', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('category')->default('Olahraga');
            $t->text('description')->nullable();
            $t->text('requirements')->nullable();      // satu syarat per baris
            $t->string('location')->nullable();
            $t->string('schedule_text')->nullable();   // contoh: Selasa & Kamis, 15.00-17.30
            $t->unsignedInteger('quota')->default(40);
            $t->string('color', 9)->default('#2563EB');
            $t->foreignId('pembina_id')->nullable()->constrained('users')->nullOnDelete();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('registrations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('ekskul_id')->constrained()->cascadeOnDelete();
            $t->text('reason')->nullable();
            $t->string('status')->default('pending');  // pending | accepted | rejected
            $t->timestamp('decided_at')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'ekskul_id']);
        });

        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->unsignedInteger('capacity')->default(30);
            $t->timestamps();
        });

        Schema::create('schedules', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ekskul_id')->constrained()->cascadeOnDelete();
            $t->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->date('date');
            $t->time('start_time');
            $t->time('end_time');
            $t->string('type')->default('latihan');    // latihan | uji_tanding | lainnya
            $t->string('status')->default('terjadwal'); // terjadwal | selesai | dibatalkan
            $t->text('notes')->nullable();
            $t->timestamps();
        });

        Schema::create('attendances', function (Blueprint $t) {
            $t->id();
            $t->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('status')->default('hadir');    // hadir | izin | sakit | alpha
            $t->timestamps();
            $t->unique(['schedule_id', 'user_id']);
        });

        Schema::create('assessments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ekskul_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->unsignedTinyInteger('technique')->default(0);
            $t->unsignedTinyInteger('discipline')->default(0);
            $t->unsignedTinyInteger('teamwork')->default(0);
            $t->unsignedTinyInteger('attitude')->default(0);
            $t->text('notes')->nullable();
            $t->foreignId('assessed_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->unique(['ekskul_id', 'user_id']);
        });

        Schema::create('announcements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('ekskul_id')->nullable()->constrained()->nullOnDelete();
            $t->string('type')->default('pengumuman'); // pengumuman | berita
            $t->string('title');
            $t->text('body');
            $t->timestamps();
        });

        Schema::create('galleries', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('ekskul_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->text('description')->nullable();
            $t->string('image_path');
            $t->timestamps();
        });

        Schema::create('certificates', function (Blueprint $t) {
            $t->id();
            $t->string('number')->unique();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('ekskul_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->date('issued_at');
            $t->timestamps();
        });

        Schema::create('app_notifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('message')->nullable();
            $t->string('url')->nullable();
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['app_notifications','certificates','galleries','announcements','assessments','attendances','schedules','rooms','registrations','ekskuls'] as $tbl) {
            Schema::dropIfExists($tbl);
        }
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['role','nis','kelas','phone','is_active','verification_code']);
        });
    }
};
