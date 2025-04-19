<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $query = User::query();

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

        $users = $query->get();

        // Jika request AJAX, return partial view
        if (request()->ajax()) {
            return response()->json([
                'html' => view('admin.users._user_table', compact('users'))->render()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diubah',
            'new_status' => $user->is_active
        ]);
    }
} 