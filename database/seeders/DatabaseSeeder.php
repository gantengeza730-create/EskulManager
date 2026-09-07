<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('attendance_records')->delete();
        DB::table('registrations')->delete();
        DB::table('ekskuls')->delete();
    }
}