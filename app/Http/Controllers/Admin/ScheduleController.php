<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Room;
use App\Models\Schedule;
use App\Support\Notifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/** Jadwal & alokasi ruangan, termasuk Jadwal Tetap (berulang tiap minggu) dan pengecekan bentrok. */
class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $ekskulId = $request->query('ekskul');
        $tipe = $request->query('tipe'); // tetap | sekali
        $items = Schedule::with(['ekskul', 'room'])
            ->when($ekskulId, fn ($q) => $q->where('ekskul_id', $ekskulId))
            ->when($tipe === 'tetap', fn ($q) => $q->where('is_fixed', true))
            ->when($tipe === 'sekali', fn ($q) => $q->where('is_fixed', false))
            ->orderByDesc('date')->orderBy('start_time')->paginate(15)->withQueryString();
        return view('admin.jadwal-index', ['items' => $items, 'ekskuls' => Ekskul::orderBy('name')->get(), 'ekskulId' => $ekskulId, 'tipe' => $tipe]);
    }

    public function create()
    {
        return view('admin.jadwal-form', $this->formData(new Schedule(['type' => 'latihan', 'status' => 'terjadwal', 'is_fixed' => false])));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $fixed = $request->boolean('is_fixed');
        if ($fixed) $request->validate(['repeat_until' => 'required|date|after:date']);

        $dates = [Carbon::parse($data['date'])];
        if ($fixed) {
            $d = Carbon::parse($data['date'])->addWeek();
            $until = Carbon::parse($request->input('repeat_until'));
            while ($d->lte($until) && count($dates) < 60) { $dates[] = $d->copy(); $d->addWeek(); }
        }
        foreach ($dates as $d) {
            if ($msg = $this->conflict(array_merge($data, ['date' => $d->toDateString()]))) {
                return back()->withInput()->with('error', $d->translatedFormat('d M Y') . ': ' . $msg);
            }
        }
        $series = $fixed ? (string) Str::uuid() : null;
        $first = null;
        foreach ($dates as $d) {
            $s = Schedule::create(array_merge($data, ['date' => $d->toDateString(), 'is_fixed' => $fixed, 'series' => $series]));
            $first = $first ?: $s;
        }
        $msg = $fixed ? 'Jadwal tetap tiap ' . $dates[0]->translatedFormat('l') . ' · ' . $first->timeRange() . ' (' . count($dates) . ' sesi, s.d. ' . end($dates)->translatedFormat('d M Y') . ')'
                      : $first->date->translatedFormat('d M Y') . ' · ' . $first->timeRange();
        Notifier::send($first->ekskul->members, ($fixed ? 'Jadwal tetap baru: ' : 'Jadwal baru: ') . $first->title, $first->ekskul->name . ' · ' . $msg, route('jadwal.index'));
        return redirect()->route('admin.jadwal.index')->with('success', ($fixed ? count($dates) . ' sesi jadwal tetap dibuat' : 'Jadwal dibuat') . ' dan anggota sudah diberi notifikasi.');
    }

    public function edit(Schedule $schedule) { return view('admin.jadwal-form', $this->formData($schedule)); }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $this->validated($request);
        if ($msg = $this->conflict($data, $schedule->id)) return back()->withInput()->with('error', $msg);
        $schedule->update($data);
        Notifier::send($schedule->ekskul->members, 'Jadwal diperbarui: ' . $schedule->title,
            $schedule->date->translatedFormat('d M Y') . ' · ' . $schedule->timeRange() . ' · ' . ucfirst($schedule->status), route('jadwal.index'));
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Request $request, Schedule $schedule)
    {
        if ($request->boolean('seri') && $schedule->series) {
            $n = Schedule::where('series', $schedule->series)->delete();
            return back()->with('success', "Seluruh jadwal tetap ($n sesi) dihapus.");
        }
        $schedule->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }

    private function formData(Schedule $schedule): array
    {
        return ['schedule' => $schedule, 'ekskuls' => Ekskul::orderBy('name')->get(), 'rooms' => Room::orderBy('name')->get()];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'ekskul_id' => 'required|exists:ekskuls,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:150',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:latihan,uji_tanding,lainnya',
            'status' => 'required|in:terjadwal,selesai,dibatalkan',
            'notes' => 'required|string|max:500',
        ], ['end_time.after' => 'Jam selesai harus setelah jam mulai.']);
    }

    private function conflict(array $d, ?int $ignoreId = null): ?string
    {
        if (empty($d['room_id']) || $d['status'] === 'dibatalkan') return null;
        $clash = Schedule::with('ekskul')->where('room_id', $d['room_id'])->whereDate('date', $d['date'])
            ->where('status', '!=', 'dibatalkan')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('start_time', '<', $d['end_time'])->where('end_time', '>', $d['start_time'])->first();
        return $clash ? 'Ruangan bentrok dengan jadwal ' . $clash->ekskul->name . ' (' . $clash->timeRange() . '). Pilih ruangan atau jam lain.' : null;
    }
}
