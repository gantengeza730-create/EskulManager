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

    public function joinEkskul($id)
    {
        // Logika join ekskul yang sudah ada di projek Anda
        return back();
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
    $registrations = Registration::where('user_id', $user->id)->get(); 

    // Kirim kedua variabel ke view dashboard
    return view('dashboard', compact('user', 'registrations')); 
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}