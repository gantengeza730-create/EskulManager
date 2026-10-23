<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Support\Notifier;
use Illuminate\Http\Request;

/** Tabel data pendaftar untuk ekskul binaan pembina. */
class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $ids = auth()->user()->scopedEkskulIds();
        $status = $request->query('status');
        $rows = Registration::with(['user', 'ekskul'])->whereIn('ekskul_id', $ids)
            ->when($status, fn ($q) => $q->where('status', $status))->latest()->paginate(15)->withQueryString();
        return view('pembina.pendaftar', compact('rows', 'status'));
    }

    public function update(Request $request, Registration $registration)
    {
        abort_unless(in_array($registration->ekskul_id, auth()->user()->scopedEkskulIds(), true), 403);
        $request->validate(['status' => 'required|in:accepted,rejected']);

        if ($request->status === 'accepted' && $registration->status !== 'accepted'
            && $registration->ekskul->memberCount() >= $registration->ekskul->quota) {
            return back()->with('error', 'Kuota ekskul sudah penuh, tidak bisa menerima pendaftar baru.');
        }

        $registration->update(['status' => $request->status, 'decided_at' => now()]);

        $ok = $request->status === 'accepted';
        Notifier::send($registration->user,
            $ok ? 'Pendaftaran diterima 🎉' : 'Pendaftaran ditolak',
            'Pendaftaran Anda ke ' . $registration->ekskul->name . ($ok ? ' telah diterima.' : ' belum dapat diterima.'),
            route('siswa.ekskul.index'));

        return back()->with('success', $registration->user->name . ($ok ? ' diterima.' : ' ditolak.'));
    }
}
