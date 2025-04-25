<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query();

        // Filter by name with partial word matching
        if (request()->has('nama_event') && request('nama_event') != '') {
            $events->where('nama_event', 'like', '%' . request('nama_event') . '%');
        }

        // Filter by location with partial word matching
        if (request()->has('lokasi') && request('lokasi') != '') {
            $events->where('lokasi', 'like', '%' . request('lokasi') . '%');
        }

        // Filter by price range
        if (request()->has('harga_range') && request('harga_range') != '') {
            $range = explode('-', request('harga_range'));
            if (count($range) == 2) {
                $events->whereBetween('harga', [$range[0], $range[1]]);
            }
        }

        // Filter by date range
        if (request()->has('tanggal_awal') && request('tanggal_awal') != '') {
            $events->where('tanggal_pelaksanaan', '>=', request('tanggal_awal'));
        }
        if (request()->has('tanggal_akhir') && request('tanggal_akhir') != '') {
            $events->where('tanggal_pelaksanaan', '<=', request('tanggal_akhir'));
        }

        $events = $events->latest()->get();

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
            $image = $request->file('poster');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['poster'] = '/uploads/' . $imageName;
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

            $image = $request->file('poster');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['poster'] = '/uploads/' . $imageName;
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