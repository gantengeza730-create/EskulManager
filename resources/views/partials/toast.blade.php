{{-- Notifikasi singkat yang muncul lalu hilang sendiri (dipakai di landing page). --}}
@if (session('success'))
<div class="toast-wrap" role="status" aria-live="polite">
    <div class="toast-pill">
        <span class="ti">{{ \Illuminate\Support\Str::contains(strtolower(session('success')), 'keluar') ? '👋' : '✅' }}</span>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif
