<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class UserNotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->latest()->get();
        return view('user.notifikasi', compact('notifications'));
    }

    public function read($id)
    {
        $notif = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notif->is_read = true;
        $notif->save();
        return back();
    }
}

$userId = \Auth::id();