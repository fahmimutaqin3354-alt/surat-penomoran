<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna sistem.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(4)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|in:Admin,Operator,Verifikator,Viewer',
            'unit_kerja' => 'nullable|string|max:255',
            'status'     => 'nullable|in:Aktif,Nonaktif',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = $validated['status'] ?? 'Aktif';

        User::create($validated);

        return redirect()->route('pengaturan.users')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Tampilkan form edit user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Perbarui data user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'password'   => 'nullable|string|min:8|confirmed',
            'role'       => 'required|in:Admin,Operator,Verifikator,Viewer',
            'unit_kerja' => 'nullable|string|max:255',
            'status'     => 'required|in:Aktif,Nonaktif',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('pengaturan.users')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Aktifkan / nonaktifkan user (tombol toggle di dropdown aksi).
     */
    public function toggle($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => $user->status === 'Aktif' ? 'Nonaktif' : 'Aktif',
        ]);

        return redirect()->route('pengaturan.users')->with('success', 'Status user berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah admin menghapus akun miliknya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->route('pengaturan.users')->with('success', 'User berhasil dihapus.');
    }
}