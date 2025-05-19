<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengrajin;
use Illuminate\Http\Request;

class PengrajinManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengrajin::query();
    
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
    
        $pengrajin = $query->get();
    
        return view('admin.pengrajin.index', compact('pengrajin'));
    }

    public function create()
    {
        return view('admin.pengrajin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengrajin,email',
            'is_active' => 'required|boolean',
        ]);
        Pengrajin::create($validated);
        return redirect()->route('admin.pengrajin.pengrajin.index')->with('success', 'Pengrajin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengrajin = Pengrajin::findOrFail($id);
        return view('admin.pengrajin.edit', compact('pengrajin'));
    }

    public function update(Request $request, $id)
    {
        $pengrajin = Pengrajin::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengrajin,email,' . $pengrajin->id,
            'is_active' => 'required|boolean',
        ]);
        $pengrajin->update($validated);
        return redirect()->route('admin.pengrajin.pengrajin.index')->with('success', 'Pengrajin berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pengrajin = Pengrajin::findOrFail($id);
        $pengrajin->delete();
        return redirect()->route('admin.pengrajin.pengrajin.index')->with('success', 'Pengrajin berhasil dihapus!');
    }
}