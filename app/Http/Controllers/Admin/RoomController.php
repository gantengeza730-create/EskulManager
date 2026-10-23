<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Master data ruangan/tempat latihan (dipakai untuk alokasi jadwal). */
class RoomController extends Controller
{
    public function index()
    {
        $items = Room::withCount('schedules')->orderBy('name')->get();
        return view('admin.rooms', ['items' => $items, 'editing' => null]);
    }

    public function store(Request $request)
    {
        Room::create($request->validate(['name' => 'required|string|max:80|unique:rooms,name', 'capacity' => 'required|integer|min:1']));
        return back()->with('success', 'Ruangan ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms', ['items' => Room::withCount('schedules')->orderBy('name')->get(), 'editing' => $room]);
    }

    public function update(Request $request, Room $room)
    {
        $room->update($request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('rooms', 'name')->ignore($room->id)],
            'capacity' => 'required|integer|min:1',
        ]));
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return back()->with('success', 'Ruangan dihapus (jadwal terkait menjadi tanpa ruangan).');
    }
}
