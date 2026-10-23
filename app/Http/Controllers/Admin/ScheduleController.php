<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Room;
use App\Models\Schedule;
use App\Support\Notifier;
use Illuminate\Http\Request;

/** Manajemen jadwal & alokasi ruangan, dengan pengecekan bentrok. */
class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $ekskulId = $request->query('ekskul');
        $items = Schedule::with(['ekskul', 'room'])
            ->when($ekskulId, fn ($q) => $q->where('ekskul_id', $ekskulId))
            ->orderByDesc('date')->orderBy('start_time')->paginate(15)->withQueryString();
        $ekskuls = Ekskul::orderBy('name')->get();
        return view('admin.jadwal-index', compact('items', 'ekskuls', 'ekskulId'));
    }

    public function create()
    {
        return view('admin.jadwal-form', $this->formData(new Schedule(['type' => 'latihan', 'status' => 'terjadwal'])));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($msg = $this->conflict($data)) return back()->withInput()->with('error', $msg);

        $s = Schedule::create($data);
        Notifier::send($s->ekskul->members, 'Jadwal baru: ' . $s->title,
            $s->ekskul->name . ' · ' . $s->date->translatedFormat('d M Y') . ' · ' . $s->timeRange(), route('jadwal.index'));
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal dibuat dan anggota sudah diberi notifikasi.');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.jadwal-form', $this->formData($schedule));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $this->validated($request);
        if ($msg = $this->conflict($data, $schedule->id)) return back()->withInput()->with('error', $msg);

        $schedule->update($data);
        Notifier::send($schedule->ekskul->members, 'Jadwal diperbarui: ' . $schedule->title,
            $schedule->date->translatedFormat('d M Y') . ' · ' . $schedule->timeRange() . ' · ' . ucfirst($schedule->status), route('jadwal.index'));
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
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
            'room_id' => 'nullable|exists:rooms,id',
            'title' => 'required|string|max:150',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:latihan,uji_tanding,lainnya',
            'status' => 'required|in:terjadwal,selesai,dibatalkan',
            'notes' => 'nullable|string|max:500',
        ]);
    }

    /** Cek apakah ruangan yang sama sudah dipakai pada tanggal & jam yang beririsan. */
    private function conflict(array $d, ?int $ignoreId = null): ?string
    {
        if (empty($d['room_id']) || $d['status'] === 'dibatalkan') return null;
        $clash = Schedule::with('ekskul')->where('room_id', $d['room_id'])->whereDate('date', $d['date'])
            ->where('status', '!=', 'dibatalkan')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('start_time', '<', $d['end_time'])->where('end_time', '>', $d['start_time'])->first();
        return $clash
            ? 'Ruangan bentrok dengan jadwal ' . $clash->ekskul->name . ' (' . $clash->timeRange() . '). Pilih ruangan atau jam lain.'
            : null;
    }
}
