<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

/** Presensi/kehadiran kegiatan: pembina memilih sesi lalu menandai kehadiran anggota. */
class AttendanceController extends Controller
{
    public function index()
    {
        $ids = auth()->user()->scopedEkskulIds();
        $schedules = Schedule::with(['ekskul', 'room'])->withCount('attendances')
            ->whereIn('ekskul_id', $ids)->whereDate('date', '<=', today()->addDays(7))
            ->orderByDesc('date')->paginate(12);
        return view('pembina.presensi-index', compact('schedules'));
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
        $data = $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:hadir,izin,sakit,alpha',
        ]);
        $memberIds = $schedule->ekskul->members()->pluck('users.id')->all();

        foreach ($data['status'] as $userId => $status) {
            if (!in_array((int) $userId, $memberIds, true)) continue;
            Attendance::updateOrCreate(['schedule_id' => $schedule->id, 'user_id' => $userId], ['status' => $status]);
        }
        if ($schedule->date->lte(today()) && $schedule->status === 'terjadwal') {
            $schedule->update(['status' => 'selesai']);
        }
        return redirect()->route('pembina.presensi.index')->with('success', 'Presensi tersimpan dan langsung terlihat oleh siswa.');
    }

    private function authorizeSchedule(Schedule $schedule): void
    {
        abort_unless(in_array($schedule->ekskul_id, auth()->user()->scopedEkskulIds(), true), 403);
    }
}
