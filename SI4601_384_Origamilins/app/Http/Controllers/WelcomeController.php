<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class WelcomeController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('tanggal_pelaksanaan', 'asc')->take(4)->get();
        return view('welcome', compact('events'));
    }
}