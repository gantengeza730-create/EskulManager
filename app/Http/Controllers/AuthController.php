<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:siswa,guru,admin',
            'nis'      => 'nullable|string|max:50',
            'class'    => 'nullable|string|max:50',
        ]);

        // 2. Simpan Data ke Database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => $request->role,
            'nis'      => $request->nis,
            'class'    => $request->class,
        ]);

        // 3. (Opsional) Langsung login-kan user setelah mendaftar
        Auth::login($user);

        // Ganti baris return redirect()->route('dashboard')... dengan kode ini:
    if ($user->role === 'admin') {
    return redirect()->route('dashboard.admin')->with('success', 'Registrasi Berhasil!');
    } elseif ($user->role === 'guru') {
    return redirect()->route('dashboard.guru')->with('success', 'Registrasi Berhasil!');
    }

    return redirect()->route('dashboard.siswa')->with('success', 'Registrasi Berhasil!');
    
}

    public function login(Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Arahkan ke dashboard masing-masing berdasarkan role di database
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'guru') {
            return redirect()->route('dashboard.guru');
        }
        
        return redirect()->route('dashboard.siswa');
    }

    return back()->withErrors([
        'email' => 'Email atau Password salah.',
    ]);
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}