<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Support\Notifier;
use Illuminate\Http\Request;

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
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'reject_reason' => 'required_if:status,rejected|nullable|string|min:5|max:300',
        ], ['reject_reason.required_if' => 'Alasan penolakan wajib diisi.', 'reject_reason.min' => 'Alasan penolakan minimal 5 karakter.']);

        $ok = $request->status === 'accepted';
        if ($ok && $registration->status !== 'accepted' && $registration->ekskul->memberCount() >= $registration->ekskul->quota) {
            return back()->with('error', 'Kuota ekskul sudah penuh, tidak bisa menerima pendaftar baru.');
        }
        $registration->update(['status' => $request->status, 'decided_at' => now(), 'reject_reason' => $ok ? null : $request->reject_reason]);

        // Siswa SELALU diberi notifikasi, baik diterima maupun ditolak (beserta alasannya)
        Notifier::send($registration->user,
            $ok ? 'Pendaftaran diterima 🎉' : 'Pendaftaran ditolak',
            $ok ? 'Pendaftaran Anda ke ' . $registration->ekskul->name . ' telah diterima.'
                : 'Pendaftaran Anda ke ' . $registration->ekskul->name . ' ditolak. Alasan: ' . $request->reject_reason,
            route('siswa.ekskul.index'));

        return back()->with('success', $registration->user->name . ($ok ? ' diterima.' : ' ditolak dan sudah diberi notifikasi.'));
    }
}
