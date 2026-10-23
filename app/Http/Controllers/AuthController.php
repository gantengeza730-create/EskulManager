<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'as' => 'required|in:siswa,pembina,admin',
        ]);

        // Siswa boleh login memakai email atau NIS
        $field = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';
        $user = User::where($field, $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withInput($request->only('email', 'as'))->withErrors(['email' => 'Email/NIS atau kata sandi salah.']);
        }
        if ($user->role !== $data['as']) {
            return back()->withInput($request->only('email', 'as'))
                ->withErrors(['email' => 'Akun ini bukan akun ' . ucfirst($data['as']) . '. Pilih tab peran yang sesuai.']);
        }
        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda dinonaktifkan. Hubungi admin sekolah.']);
        }
        if (!$user->email_verified_at) {
            return redirect()->route('verify')->with('email', $user->email)
                ->with('status', 'Akun belum diverifikasi. Masukkan kode verifikasi yang dikirim ke email Anda.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'nis' => 'required|string|max:30|unique:users,nis',
            'kelas' => 'required|string|max:30',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $code = (string) random_int(100000, 999999);
        $user = User::create($data + ['role' => 'siswa', 'verification_code' => $code]);
        $this->sendCode($user);

        return redirect()->route('verify')->with('email', $user->email)
            ->with('status', 'Akun dibuat. Kami mengirim kode 6 digit ke email Anda.');
    }

    public function showVerify(Request $request)
    {
        $email = session('email', old('email', $request->query('email')));
        $devCode = null;
        // Hanya untuk mode pengembangan: tampilkan kode agar mudah diuji tanpa SMTP
        if (config('app.debug') && $email) {
            $devCode = User::where('email', $email)->value('verification_code');
        }
        return view('auth.verify', compact('email', 'devCode'));
    }

    public function verify(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'code' => 'required|digits:6']);
        $user = User::where('email', $data['email'])->first();

        if (!$user || $user->verification_code !== $data['code']) {
            return back()->withInput()->withErrors(['code' => 'Kode verifikasi salah.']);
        }
        $user->update(['email_verified_at' => now(), 'verification_code' => null]);
        return redirect()->route('login')->with('status', 'Akun berhasil diverifikasi. Silakan masuk.');
    }

    public function resend(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        $user = User::where('email', $data['email'])->whereNull('email_verified_at')->first();
        if ($user) {
            $user->update(['verification_code' => (string) random_int(100000, 999999)]);
            $this->sendCode($user);
        }
        return redirect()->route('verify')->with('email', $data['email'])->with('status', 'Kode baru telah dikirim.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Setelah keluar, langsung kembali ke landing page (tanpa halaman login perantara)
        return redirect()->route('home')->with('success', 'Anda telah keluar dari akun.');
    }

    private function sendCode(User $user): void
    {
        // Dengan MAIL_MAILER=log, isi email tercatat di storage/logs/laravel.log
        Mail::raw("Kode verifikasi akun Ekskul SMK Anda: {$user->verification_code}", function ($m) use ($user) {
            $m->to($user->email)->subject('Kode Verifikasi Ekskul SMK');
        });
    }
}
