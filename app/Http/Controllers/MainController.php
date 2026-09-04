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
    
    // Ambil data pendaftaran ekskul berdasarkan user yang sedang login
    $registrations = Registration::with(['ekskul', 'user'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();
    $ekskulMembers = Registration::with('user')
        ->whereIn('ekskul_id', $registrations->pluck('ekskul_id'))
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

    // Kirim kedua variabel ke view dashboard
    return view('dashboard', compact('user', 'registrations', 'ekskulMembers', 'ekskuls', 'attendanceRecords', 'presentCount', 'totalDaysFromFirstJoin', 'attendancePercentage', 'monthlyAttendanceByDate', 'attendanceStatsByEkskul', 'currentMonthStart', 'currentMonthEnd')); 
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
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            return back()->withErrors([
                'ekskul' => 'Formulir pendaftaran hanya tersedia untuk murid/student.',
            ]);
        }

        $ekskul = Ekskul::findOrFail($id);

        $exists = Registration::where('user_id', $user->id)
            ->where('ekskul_id', $ekskul->id)
            ->exists();

        if ($exists) {
            return back()->with('success', 'Kamu sudah terdaftar di ekskul ini.');
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
        return view('dashboard_guru', compact('user'));
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