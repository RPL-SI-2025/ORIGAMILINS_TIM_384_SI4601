<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('is_public', true)->get();
        return view('user.event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.show', compact('event'));
    }
} 