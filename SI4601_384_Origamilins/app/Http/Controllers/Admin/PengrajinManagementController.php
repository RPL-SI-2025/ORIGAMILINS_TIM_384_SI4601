<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengrajin;
use Illuminate\Http\Request;

class PengrajinManagementController extends Controller
{
    public function index()
    {
        $query = Pengrajin::query();

        // Filter by name
        if (request()->has('nama') && request('nama') != '') {
            $query->where('name', 'like', '%' . request('nama') . '%');
        }

        // Filter by email
        if (request()->has('email') && request('email') != '') {
            $query->where('email', 'like', '%' . request('email') . '%');
        }

        // Filter by status
        if (request()->has('status') && request('status') != '') {
            $query->where('is_active', request('status'));
        }

        $pengrajin = $query->get();

        // Jika request AJAX, return partial view
        if (request()->ajax()) {
            return response()->json([
                'html' => view('admin.pengrajin._user_table', compact('pengrajin'))->render()
            ]);
        }

        return view('admin.pengrajin.index', compact('pengrajin'));
    }

    public function toggleStatus(Pengrajin $pengrajin)
{
    $pengrajin->is_active = !$pengrajin->is_active; 
    $pengrajin->save();

    return response()->json([
        'success' => true,
        'message' => 'Status pengrajin berhasil diubah',
        'new_status' => $pengrajin->is_active
    ]);
}
} 