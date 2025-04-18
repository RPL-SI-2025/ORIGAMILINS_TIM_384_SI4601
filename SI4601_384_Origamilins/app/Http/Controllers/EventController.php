<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Pastikan direktori ada
            $path = public_path('images/events');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $file->move($path, $fileName);
            $data['poster'] = 'images/events/' . $fileName;
        }

        Event::create($data);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        return view('admin.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($event->poster && file_exists(public_path($event->poster))) {
                unlink(public_path($event->poster));
            }

            $file = $request->file('poster');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Pastikan direktori ada
            $path = public_path('images/events');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $file->move($path, $fileName);
            $data['poster'] = 'images/events/' . $fileName;
        }

        $event->update($data);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        // Hapus poster jika ada
        if ($event->poster && file_exists(public_path($event->poster))) {
            unlink(public_path($event->poster));
        }

        $event->delete();

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil dihapus!');
    }
}
