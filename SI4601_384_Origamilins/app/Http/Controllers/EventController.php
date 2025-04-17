<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Menampilkan semua event
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    // Menampilkan form untuk membuat event baru
    public function create()
    {
        return view('events.create');
    }

    // Menyimpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric',
            'lokasi' => 'required|string',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index');
    }

    // Menampilkan event tertentu
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Menampilkan form untuk mengedit event
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Memperbarui event
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama_event' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric',
            'lokasi' => 'required|string',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index');
    }

    // Menghapus event
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
}
