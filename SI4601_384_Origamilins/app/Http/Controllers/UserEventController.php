<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('nama')) {
            $query->where('nama_event', 'like', '%' . $request->input('nama') . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->input('lokasi') . '%');
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pelaksanaan', '>=', $request->input('tanggal_mulai'));
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pelaksanaan', '<=', $request->input('tanggal_akhir'));
        }

        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->input('harga_min'));
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->input('harga_max'));
        }

        $events = $query->orderBy('tanggal_pelaksanaan')->get();

        return view('user.event.index', ['events' => $events, 'request' => $request]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.show', compact('event'));
    }
}