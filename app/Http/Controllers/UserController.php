<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Hanya Admin yang bisa mengakses halaman tambah user
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:Admin,Supervisor,Petugas,User',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Admin bisa edit semua user, Supervisor bisa edit semua kecuali Admin, lainnya hanya bisa edit diri sendiri
        if (Auth::user()->role === 'Admin' || (Auth::user()->role === 'Supervisor' && $user->role !== 'Admin') || Auth::id() === $user->id) {
            return view('users.edit', compact('user'));
        }

        abort(403, 'Anda tidak memiliki izin untuk mengedit user ini.');
    }

    public function update(Request $request, User $user)
    {
        // Admin bisa mengedit semua user, Supervisor bisa edit semua kecuali Admin, lainnya hanya bisa edit diri sendiri
        if (!(Auth::user()->role === 'Admin' || (Auth::user()->role === 'Supervisor' && $user->role !== 'Admin') || Auth::id() === $user->id)) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit user ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        // Supervisor dan User tidak bisa mengubah role user lain
        if (Auth::user()->role === 'Admin') {
            $request->validate([
                'role' => 'required|string|in:Admin,Supervisor,Petugas,User',
            ]);
            $user->role = $request->role;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Hanya Admin yang bisa menghapus user
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus user.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
