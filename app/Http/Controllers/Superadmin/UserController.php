<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->query('q'), function ($q, $keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('instansi_opd', 'like', "%{$keyword}%");
            })
            ->when($request->query('role'), function ($q, $role) {
                $q->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        // Pada method store:
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:191|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'instansi_opd' => 'nullable|string|max:150',
            'role' => 'required|in:superadmin,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('superadmin.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:191', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',
            'instansi_opd' => 'nullable|string|max:150',
            'role' => 'required|in:superadmin,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('superadmin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang Anda gunakan saat ini.');
        }

        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}