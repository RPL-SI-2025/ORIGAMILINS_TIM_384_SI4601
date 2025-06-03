<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $query = User::query();

        // Filter by name
        if (request()->has('name') && request('name') != '') {
            $query->where('name', 'like', '%' . request('name') . '%');
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

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'is_active' => 'boolean',
        ]);

        $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);
        $validatedData['is_active'] = $request->has('is_active'); // Handle checkbox

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }
} 