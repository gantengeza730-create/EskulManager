<?php

namespace App\Support;

use App\Models\Setting;

/** Identitas sekolah — dibagikan ke semua view sebagai $school. Diubah lewat menu Pengaturan Sekolah. */
class School
{
    public function name(): string      { return Setting::get('school_name', 'SMKN 1 Binong'); }
    public function address(): string   { return Setting::get('school_address', 'Jl. Pendidikan No. 10'); }
    public function principal(): string { return Setting::get('principal_name', 'Nama Kepala Sekolah'); }
    public function principalNip(): string { return Setting::get('principal_nip', '-'); }
    public function bigMin(): int       { return (int) Setting::get('ekskul_besar_min', 30); }
    public function logo(): ?string
    {
        $p = Setting::get('school_logo');
        return $p ? asset('storage/' . $p) : null;
    }
}
