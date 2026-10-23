<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Ekskul;
use App\Support\Notifier;
use Illuminate\Http\Request;

/** Tabel penilaian/evaluasi anggota ekskul. */
class AssessmentController extends Controller
{
    public function index(?Ekskul $ekskul = null)
    {
        $mine = auth()->user()->ekskulsBina;
        $ekskul = $ekskul ?: $mine->first();
        if ($ekskul) abort_unless($mine->contains('id', $ekskul->id), 403);

        $members = $ekskul ? $ekskul->members()->orderBy('name')->get() : collect();
        $scores = $ekskul ? Assessment::where('ekskul_id', $ekskul->id)->get()->keyBy('user_id') : collect();
        return view('pembina.penilaian', compact('mine', 'ekskul', 'members', 'scores'));
    }

    public function update(Request $request, Ekskul $ekskul)
    {
        abort_unless(auth()->user()->ekskulsBina->contains('id', $ekskul->id), 403);
        $data = $request->validate([
            'scores' => 'required|array',
            'scores.*.technique' => 'required|integer|min:0|max:100',
            'scores.*.discipline' => 'required|integer|min:0|max:100',
            'scores.*.teamwork' => 'required|integer|min:0|max:100',
            'scores.*.attitude' => 'required|integer|min:0|max:100',
            'scores.*.notes' => 'nullable|string|max:500',
        ]);
        $memberIds = $ekskul->members()->pluck('users.id')->all();

        foreach ($data['scores'] as $userId => $row) {
            if (!in_array((int) $userId, $memberIds, true)) continue;
            $a = Assessment::updateOrCreate(
                ['ekskul_id' => $ekskul->id, 'user_id' => $userId],
                $row + ['assessed_by' => auth()->id()]
            );
            if ($a->wasRecentlyCreated || $a->wasChanged()) {
                Notifier::send(\App\Models\User::find($userId), 'Nilai evaluasi diperbarui',
                    'Pembina memperbarui penilaian Anda di ' . $ekskul->name . '.', route('siswa.nilai'));
            }
        }
        return back()->with('success', 'Penilaian tersimpan dan langsung terlihat oleh siswa.');
    }
}
