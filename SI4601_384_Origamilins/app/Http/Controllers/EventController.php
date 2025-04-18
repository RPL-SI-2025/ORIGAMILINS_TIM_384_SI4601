<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::all();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_pelaksanaan' => 'required|date',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Event::create([
            'nama_event' => $request->nama_event,
            'deskripsi' => $request->deskripsi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
        ]);

        // Redirect ke halaman daftar event
        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    // Method lain (edit, update, delete) bisa ditambahkan nanti sesuai kebutuhan
}
