<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\User;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    public function index()
    {
        $items = Ekskul::with('pembina')->withCount(['registrations as members_count' => fn ($q) => $q->where('status', 'accepted')])->orderByDesc('members_count')->orderBy('name')->get();
        return view('admin.ekskul-index', compact('items'));
    }

    public function create()
    {
        return view('admin.ekskul-form', ['ekskul' => new Ekskul(['color' => '#2563EB', 'quota' => 40, 'is_active' => true]), 'pembinas' => $this->pembinas()]);
    }

    public function store(Request $request)
    {
        Ekskul::create($this->validated($request));
        return redirect()->route('admin.ekskul.index')->with('success', 'Ekskul baru berhasil ditambahkan.');
    }

    public function edit(Ekskul $ekskul)
    {
        return view('admin.ekskul-form', ['ekskul' => $ekskul, 'pembinas' => $this->pembinas()]);
    }

    public function update(Request $request, Ekskul $ekskul)
    {
        $ekskul->update($this->validated($request));
        return redirect()->route('admin.ekskul.index')->with('success', 'Data ekskul diperbarui.');
    }

    public function destroy(Ekskul $ekskul)
    {
        $ekskul->delete();
        return redirect()->route('admin.ekskul.index')->with('success', 'Ekskul dihapus beserta data terkait.');
    }

    private function pembinas() { return User::where('role', 'pembina')->orderBy('name')->get(); }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:100',
            'schedule_text' => 'required|string|max:100',
            'quota' => 'required|integer|min:1|max:500',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'pembina_id' => 'required|exists:users,id',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
