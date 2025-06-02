<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter berdasarkan Nama Event
        if ($request->filled('nama')) {
            $query->where('nama_event', 'like', '%' . $request->input('nama') . '%');
        }

        // Filter berdasarkan Lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->input('lokasi') . '%');
        }

        // Filter berdasarkan Tanggal Pelaksanaan
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pelaksanaan', '>=', $request->input('tanggal_mulai'));
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pelaksanaan', '<=', $request->input('tanggal_akhir'));
        }

        // Filter berdasarkan Rentang Harga
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->input('harga_min'));
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->input('harga_max'));
        }

        // Ambil event yang sudah difilter
        $events = $query->orderBy('tanggal_pelaksanaan')->get(); // Urutkan berdasarkan tanggal

        // Teruskan request filter ke view untuk mempertahankan nilai di form
        return view('user.event.index', ['events' => $events, 'request' => $request]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.show', compact('event'));
    }
} 