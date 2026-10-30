<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /** Daftar sesi (yang sudah berlangsung/hari ini) dengan filter tanggal presensi. */
    public function index(Request $request)
    {
        $ids = auth()->user()->scopedEkskulIds();
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');
        $schedules = Schedule::with(['ekskul', 'room'])->withCount('attendances')
            ->whereIn('ekskul_id', $ids)->where('status', '!=', 'dibatalkan')->whereDate('date', '<=', today())
            ->when($dari, fn ($q) => $q->whereDate('date', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('date', '<=', $sampai))
            ->orderByDesc('date')->paginate(12)->withQueryString();
        return view('pembina.presensi-index', compact('schedules', 'dari', 'sampai'));
    }

    public function edit(Schedule $schedule)
    {
        $this->authorizeSchedule($schedule);
        $members = $schedule->ekskul->members()->orderBy('name')->get();
        $current = $schedule->attendances()->pluck('status', 'user_id');
        return view('pembina.presensi-edit', compact('schedule', 'members', 'current'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($schedule);
        $data = $request->validate(['status' => 'required|array', 'status.*' => 'required|in:hadir,izin,sakit,alpha']);
        $memberIds = $schedule->ekskul->members()->pluck('users.id')->all();
        foreach ($data['status'] as $userId => $status) {
            if (!in_array((int) $userId, $memberIds, true)) continue;
            Attendance::updateOrCreate(['schedule_id' => $schedule->id, 'user_id' => $userId], ['status' => $status]);
        }
        if ($schedule->date->lte(today()) && $schedule->status === 'terjadwal') $schedule->update(['status' => 'selesai']);
        return redirect()->route('pembina.presensi.index')->with('success', 'Presensi tersimpan dan langsung terlihat oleh siswa.');
    }

    private function authorizeSchedule(Schedule $schedule): void
    {
        abort_unless(in_array($schedule->ekskul_id, auth()->user()->scopedEkskulIds(), true), 403);
    }
}
