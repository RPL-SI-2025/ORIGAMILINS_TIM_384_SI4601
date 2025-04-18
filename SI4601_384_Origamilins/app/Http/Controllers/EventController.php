<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        // Jika admin, tampilkan view admin
        if (request()->is('admin/*')) {
            return view('admin.event.index', compact('events'));
        }

        // Jika user biasa
        return view('event.melihat_event', compact('events'));
    }

    public function create()
    {
        // Jika admin, tampilkan view admin
        if (request()->is('admin/*')) {
            return view('admin.event.create');
        }
        return view('event.tambah_event');
    }

    public function store(Request $request)
    {
        // Validasi input
        $eventData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Event::create($eventData);

        // Redirect sesuai role
        if (request()->is('admin/*')) {
            return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan!');
        }
        return redirect()->route('event.melihat_event')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Validasi input
        $eventData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        // Update data event
        $event->update($eventData);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dihapus!');
    }
}
