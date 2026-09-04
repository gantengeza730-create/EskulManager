<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ekskul_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status', ['hadir', 'sakit_izin', 'tidak_hadir']);
            $table->text('proof')->nullable();
            $table->timestamps();

            $table->unique(['registration_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};