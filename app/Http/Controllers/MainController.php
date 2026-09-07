<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ekskul;
use App\Models\Registration;
use App\Models\AttendanceRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    // ==========================================
    // 1. LANDING PAGE & JOIN
    // ==========================================
    public function landing()
    {
        $ekskuls = Ekskul::all(); 
        return view('landing', compact('ekskuls'));
    }

    // ==========================================
    // 2. REGISTER (Disesuaikan dengan rute 'register')
    // ==========================================
    public function register(Request $request)
    {
        // Jika form dikirim (POST)
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,guru,siswa'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Auth::login($user);

            // Pengarahan otomatis berdasarkan role setelah Register
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard')->with('success', 'Berhasil mendaftar sebagai Admin!');
            } elseif ($user->role == 'guru') {
                return redirect('/guru/dashboard')->with('success', 'Berhasil mendaftar sebagai Guru!');
            } else {
                return redirect('/dashboard')->with('success', 'Berhasil mendaftar sebagai Siswa!');
            }
        }

        // Jika halaman diakses lewat URL (GET)
        return view('auth.register');
    }

    // ==========================================
    // 3. LOGIN (Disesuaikan dengan rute 'login')
    // ==========================================
    public function login(Request $request)
    {
        // Jika form dikirim (POST)
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                // Pengarahan otomatis berdasarkan role saat Login
                $role = Auth::user()->role;
                if ($role == 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($role == 'guru') {
                    return redirect('/guru/dashboard');
                } else {
                    return redirect('/dashboard');
                }
            }

            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        // Jika halaman diakses lewat URL (GET)
        return view('auth.login');
    }

    // ==========================================
    // 4. DASHBOARD & LOGOUT
    // ==========================================
    public function dashboard()
{
    $user = Auth::user();

    $registrations = Registration::with(['ekskul', 'user'])
        ->where('user_id', $user->id)
        ->whereIn('status', ['diterima', 'aktif'])
        ->latest()
        ->get();
    $ekskulMembers = Registration::with('user')
        ->whereIn('ekskul_id', $registrations->pluck('ekskul_id'))
        ->whereIn('status', ['diterima', 'aktif'])
        ->latest()
        ->get();
    $ekskuls = Ekskul::orderBy('title')->get();
    $attendanceRecords = AttendanceRecord::with('ekskul')
        ->where('user_id', $user->id)
        ->orderByDesc('attendance_date')
        ->orderByDesc('id')
        ->get();

    $currentMonthStart = Carbon::now()->startOfMonth();
    $currentMonthEnd = Carbon::now()->endOfMonth();
    $currentMonthAttendance = $attendanceRecords->filter(function ($attendance) use ($currentMonthStart, $currentMonthEnd) {
        return $attendance->status === 'hadir'
            && $attendance->attendance_date->betweenIncluded($currentMonthStart, $currentMonthEnd);
    });

    $currentMonthDays = collect(range(1, Carbon::now()->daysInMonth))->mapWithKeys(function ($day) {
        $date = Carbon::now()->copy()->startOfMonth()->addDays($day - 1)->toDateString();

        return [$date => 0];
    });

    $monthlyAttendanceByDate = $currentMonthDays->merge(
        $currentMonthAttendance->groupBy(function ($attendance) {
            return $attendance->attendance_date->toDateString();
        })->map->count()
    );

    $attendanceStatsByEkskul = $registrations->map(function ($registration) use ($attendanceRecords, $currentMonthStart, $currentMonthEnd) {
        $ekskulAttendance = $attendanceRecords->where('ekskul_id', $registration->ekskul_id)
            ->filter(function ($attendance) use ($currentMonthStart, $currentMonthEnd) {
                return $attendance->status === 'hadir'
                    && $attendance->attendance_date->betweenIncluded($currentMonthStart, $currentMonthEnd);
            });

        return [
            'registration_id' => $registration->id,
            'ekskul_id' => $registration->ekskul_id,
            'title' => $registration->ekskul->title ?? 'Ekskul',
            'present_count' => $ekskulAttendance->count(),
        ];
    })->values();

    $firstRegistrationDate = $registrations->min('created_at');
    $totalDaysFromFirstJoin = $firstRegistrationDate
        ? max(1, Carbon::parse($firstRegistrationDate)->startOfDay()->diffInDays(Carbon::today()) + 1)
        : 0;
    $presentCount = $attendanceRecords->where('status', 'hadir')->count();
    $attendancePercentage = $totalDaysFromFirstJoin > 0
        ? 100 * round($presentCount / $totalDaysFromFirstJoin)
        : 0;

    $studentEvaluations = \App\Models\EkskulEvaluation::with(['ekskul'])
        ->where('user_id', $user->id)
        ->orderByDesc('evaluation_date')
        ->latest()
        ->get();

    foreach ($studentEvaluations as $evaluation) {
        $evaluation->letter_grade = $this->letterGradeForScore((int) $evaluation->score);
        $evaluation->grade_color = $this->gradeColorForScore((int) $evaluation->score);
    }

    // Kirim kedua variabel ke view dashboard
    return view('dashboard', compact('user', 'registrations', 'ekskulMembers', 'ekskuls', 'attendanceRecords', 'presentCount', 'totalDaysFromFirstJoin', 'attendancePercentage', 'monthlyAttendanceByDate', 'attendanceStatsByEkskul', 'currentMonthStart', 'currentMonthEnd', 'studentEvaluations')); 
}

    public function markAttendance(Request $request, $registrationId)
    {
        $user = Auth::user();
        $registration = Registration::with('ekskul')->where('user_id', $user->id)->findOrFail($registrationId);
        $today = Carbon::today()->toDateString();
        $existingAttendance = AttendanceRecord::where('registration_id', $registration->id)
            ->where('attendance_date', $today)
            ->first();

        $request->validate([
            'status' => 'required|in:hadir,sakit_izin',
            'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($existingAttendance && $existingAttendance->status === 'hadir' && $request->status === 'hadir') {
            return back()->withErrors([
                'attendance' => 'Kamu sudah tercatat hadir hari ini dan tidak bisa hadir lagi sebelum pergantian hari.',
            ]);
        }

        $proofPath = null;

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('attendance-proofs', 'public');
        }

        AttendanceRecord::updateOrCreate(
            [
                'registration_id' => $registration->id,
                'attendance_date' => $today,
            ],
            [
                'user_id' => $user->id,
                'ekskul_id' => $registration->ekskul_id,
                'status' => $request->status,
                'proof' => $proofPath,
            ]
        );

        return back()->with('success', 'Kehadiran hari ini berhasil disimpan.');
    }

    public function autoMarkAbsentForToday(): int
    {
        $today = Carbon::today()->toDateString();

        $registrations = Registration::query()->get();
        $created = 0;

        foreach ($registrations as $registration) {
            $exists = AttendanceRecord::where('registration_id', $registration->id)
                ->where('attendance_date', $today)
                ->exists();

            if ($exists) {
                continue;
            }

            AttendanceRecord::create([
                'registration_id' => $registration->id,
                'user_id' => $registration->user_id,
                'ekskul_id' => $registration->ekskul_id,
                'attendance_date' => $today,
                'status' => 'tidak_hadir',
            ]);

            $created++;
        }

        return $created;
    }

    public function joinEkskul(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mendaftar ekskul.');
        }

        $user = Auth::user();

        if ($user->role !== 'siswa') {
            return back()->withErrors([
                'ekskul' => 'Formulir pendaftaran hanya tersedia untuk murid/student.',
            ]);
        }

        $ekskul = Ekskul::findOrFail($id);

        $existing = Registration::where('user_id', $user->id)
            ->where('ekskul_id', $ekskul->id)
            ->first();

        if ($existing) {
            if ($existing->status === 'pending') {
                return back()->with('success', 'Pendaftaran kamu masih menunggu persetujuan pembina.');
            }

            if (in_array($existing->status, ['diterima', 'aktif'])) {
                return back()->with('success', 'Kamu sudah terdaftar di ekskul ini.');
            }

            $existing->update(['status' => 'pending']);

            return back()->with('success', 'Pendaftaran ekskul dikirim ulang dan menunggu persetujuan.');
        }

        Registration::create([
            'user_id' => $user->id,
            'ekskul_id' => $ekskul->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran ekskul berhasil dikirim dan menunggu persetujuan.');
    }

    public function cancelEkskul(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membatalkan pendaftaran.');
        }

        $user = Auth::user();

        if ($user->role !== 'siswa') {
            return back()->withErrors([
                'ekskul' => 'Pembatalan pendaftaran hanya tersedia untuk murid/student.',
            ]);
        }

        $registration = Registration::where('user_id', $user->id)
            ->where('ekskul_id', $id)
            ->firstOrFail();

        $registration->delete();

        return back()->with('success', 'Pendaftaran ekskul berhasil dibatalkan.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->class_name = $validated['class_name'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->bio = $validated['bio'] ?? null;

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function dashboardGuru()
    {
        $user = Auth::user();

        $ekskuls = Ekskul::where('coach', $user->name)
            ->with(['registrations.user', 'registrations.attendanceRecords'])
            ->orderByDesc('created_at')
            ->get();

        $acceptedRegistrations = Registration::with(['user', 'ekskul'])
            ->whereIn('ekskul_id', $ekskuls->pluck('id'))
            ->whereIn('status', ['diterima', 'aktif'])
            ->latest()
            ->get();

        $pendingRegistrations = Registration::with(['user', 'ekskul'])
            ->whereIn('ekskul_id', $ekskuls->pluck('id'))
            ->where('status', 'pending')
            ->latest()
            ->get();

        $allAttendance = AttendanceRecord::whereIn('registration_id', $acceptedRegistrations->pluck('id'))->get();
        $presentCount = $allAttendance->where('status', 'hadir')->count();
        $averageAttendance = $allAttendance->count() > 0
            ? round(($presentCount / $allAttendance->count()) * 100, 1)
            : 0;

        $evaluations = \App\Models\EkskulEvaluation::with(['user', 'ekskul'])
            ->whereIn('ekskul_id', $ekskuls->pluck('id'))
            ->orderByDesc('evaluation_date')
            ->latest()
            ->get();

        foreach ($evaluations as $evaluation) {
            $evaluation->letter_grade = $this->letterGradeForScore((int) $evaluation->score);
            $evaluation->grade_color = $this->gradeColorForScore((int) $evaluation->score);
        }

        return view('dashboard_guru', compact('user', 'ekskuls', 'acceptedRegistrations', 'pendingRegistrations', 'averageAttendance', 'evaluations'));
    }

    public function acceptRegistration(Registration $registration)
    {
        $user = Auth::user();
        $ekskul = $registration->ekskul;

        if ($user->role !== 'guru' || !$ekskul || $ekskul->coach !== $user->name) {
            return back()->withErrors(['ekskul' => 'Kamu tidak memiliki izin untuk menerima pendaftaran ini.']);
        }

        $registration->update(['status' => 'diterima']);

        return back()->with('success', 'Pendaftaran siswa berhasil diterima.');
    }

    public function rejectRegistration(Registration $registration)
    {
        $user = Auth::user();
        $ekskul = $registration->ekskul;

        if ($user->role !== 'guru' || !$ekskul || $ekskul->coach !== $user->name) {
            return back()->withErrors(['ekskul' => 'Kamu tidak memiliki izin untuk menolak pendaftaran ini.']);
        }

        $registration->update(['status' => 'ditolak']);

        return back()->with('success', 'Pendaftaran siswa berhasil ditolak.');
    }

    public function storeEvaluation(Request $request, Registration $registration)
    {
        $user = Auth::user();
        $ekskul = $registration->ekskul;

        if ($user->role !== 'guru' || !$ekskul || $ekskul->coach !== $user->name) {
            return back()->withErrors(['ekskul' => 'Kamu tidak memiliki izin untuk menilai siswa ini.']);
        }

        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string|max:500',
            'evaluation_date' => 'required|date',
        ]);

        \App\Models\EkskulEvaluation::updateOrCreate(
            [
                'registration_id' => $registration->id,
                'user_id' => $registration->user_id,
                'ekskul_id' => $registration->ekskul_id,
                'evaluation_date' => $validated['evaluation_date'],
            ],
            [
                'score' => $validated['score'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('success', 'Penilaian ekstrakurikuler berhasil disimpan.');
    }

    protected function letterGradeForScore(int $score): string
    {
        if ($score >= 90) {
            return 'A';
        }

        if ($score >= 80) {
            return 'B';
        }

        if ($score >= 70) {
            return 'C';
        }

        if ($score >= 60) {
            return 'D';
        }

        return 'F';
    }

    protected function gradeColorForScore(int $score): string
    {
        if ($score >= 90) {
            return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
        }

        if ($score >= 80) {
            return 'bg-blue-50 text-blue-700 border border-blue-200';
        }

        if ($score >= 70) {
            return 'bg-amber-50 text-amber-700 border border-amber-200';
        }

        if ($score >= 60) {
            return 'bg-orange-50 text-orange-700 border border-orange-200';
        }

        return 'bg-rose-50 text-rose-700 border border-rose-200';
    }

    public function storeEkskul(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'guru') {
            return back()->withErrors([
                'ekskul' => 'Hanya guru yang dapat menambahkan ekskul.',
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ekskul-images', 'public');
        }

        Ekskul::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'coach' => $user->name,
            'description' => $validated['description'] ?? 'Ekskul yang dikelola oleh guru.',
            'image' => $imagePath ?? 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=800&q=80',
        ]);

        return back()->with('success', 'Ekskul berhasil ditambahkan.');
    }

    public function updateEkskul(Request $request, $id)
    {
        $user = Auth::user();
        $ekskul = Ekskul::findOrFail($id);

        if ($user->role !== 'guru' || $ekskul->coach !== $user->name) {
            return back()->withErrors([
                'ekskul' => 'Kamu tidak memiliki izin untuk mengubah ekskul ini.',
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($ekskul->image) && !str_starts_with((string) $ekskul->image, ['http://', 'https://'])) {
                Storage::disk('public')->delete($ekskul->image);
            }

            $validated['image'] = $request->file('image')->store('ekskul-images', 'public');
        }

        $ekskul->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? $ekskul->description,
            'image' => $validated['image'] ?? $ekskul->image,
        ]);

        return back()->with('success', 'Ekskul berhasil diubah.');
    }

    public function deleteEkskul($id)
    {
        $user = Auth::user();
        $ekskul = Ekskul::findOrFail($id);

        if ($user->role !== 'guru' || $ekskul->coach !== $user->name) {
            return back()->withErrors([
                'ekskul' => 'Kamu tidak memiliki izin untuk menghapus ekskul ini.',
            ]);
        }

        if (!empty($ekskul->image) && !str_starts_with((string) $ekskul->image, ['http://', 'https://'])) {
            Storage::disk('public')->delete($ekskul->image);
        }

        $ekskul->delete();

        return back()->with('success', 'Ekskul berhasil dihapus.');
    }

    // Menampilkan Dashboard Admin
    public function dashboardAdmin()
    {
        $user = Auth::user();
        return view('dashboard_admin', compact('user'));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}