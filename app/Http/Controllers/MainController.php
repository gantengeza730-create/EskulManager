<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ekskul;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 

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
    $registrations = Registration::with('ekskul')
        ->where('user_id', $user->id)
        ->latest()
        ->get();
    $ekskulMembers = Registration::with('user')
        ->whereIn('ekskul_id', $registrations->pluck('ekskul_id'))
        ->latest()
        ->get();
    $ekskuls = Ekskul::orderBy('title')->get();

    // Kirim kedua variabel ke view dashboard
    return view('dashboard', compact('user', 'registrations', 'ekskulMembers', 'ekskuls')); 
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
        return view('dashboard_guru', compact('user'));
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