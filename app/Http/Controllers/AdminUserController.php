<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users for admin management.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Toggle the admin status of a user.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent the logged-in admin from demoting themselves
        if ($user->id === Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak dapat menghapus hak akses admin Anda sendiri!');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? 'ditambahkan sebagai Admin' : 'dihapus dari Admin';

        return redirect()
            ->back()
            ->with('success', "User {$user->name} berhasil {$status}");
    }

    /**
     * Store a newly created user (with option to make Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'birthdate' => ['required', 'date'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'User baru berhasil ditambahkan');
    }
}
