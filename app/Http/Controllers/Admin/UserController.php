<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Manajemen data pengguna: admin mengelola siswa & pembina. */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('peran');
        $q = trim((string) $request->query('cari'));
        $items = User::query()
            ->when($role, fn ($x) => $x->where('role', $role))
            ->when($q, fn ($x) => $x->where(fn ($y) => $y->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%")->orWhere('nis', 'like', "%$q%")))
            ->orderBy('role')->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.users-index', compact('items', 'role', 'q'));
    }

    public function create()
    {
        return view('admin.users-form', ['user' => new User(['role' => 'siswa', 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['email_verified_at'] = now(); // dibuat admin -> dianggap terverifikasi
        User::create($data);
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users-form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user);
        if (empty($data['password'])) unset($data['password']);
        if ($user->id === auth()->id()) { unset($data['role']); $data['is_active'] = true; } // cegah admin mengunci dirinya
        $user->update($data);
        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => 'required|in:admin,pembina,siswa',
            'nis' => ['nullable', 'string', 'max:30', Rule::unique('users', 'nis')->ignore($user?->id)],
            'kelas' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
