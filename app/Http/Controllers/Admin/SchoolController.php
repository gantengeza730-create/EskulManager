<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Pengaturan identitas sekolah: nama sekolah, nama kepala sekolah, logo, batas ekskul besar. */
class SchoolController extends Controller
{
    public function edit() { return view('admin.sekolah'); }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name' => 'required|string|max:150',
            'school_address' => 'required|string|max:200',
            'principal_name' => 'required|string|max:100',
            'principal_nip' => 'required|string|max:40',
            'ekskul_besar_min' => 'required|integer|min:1|max:500',
            'school_logo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('school_logo')) {
            if ($old = Setting::get('school_logo')) Storage::disk('public')->delete($old);
            $data['school_logo'] = $request->file('school_logo')->store('logo', 'public');
        } else {
            unset($data['school_logo']);
        }
        Setting::put($data);
        return back()->with('success', 'Pengaturan sekolah disimpan.');
    }
}
