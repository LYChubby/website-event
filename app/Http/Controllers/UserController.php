<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', '!=', 'admin');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $users = $query->latest()->paginate($perPage);

        return response()->json([
            'data' => $users->items(),
            'total' => $users->total(),
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
        ]);
    }

    public function organizer(Request $request)
    {
        // Dapatkan user yang sedang login
        $currentUser = Auth::user();

        // Validasi: hanya user dengan role 'user' yang bisa akses
        if ($currentUser->role !== 'user') {
            return $request->expectsJson()
                ? response()->json(['error' => 'Unauthorized'], 403)
                : abort(403);
        }

        // Query untuk mendapatkan organizer
        $query = User::where('role', 'organizer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->per_page ?? 10;
        $organizers = $query->latest()->paginate($perPage);

        // Response JSON untuk API
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'organizers' => $organizers->items(),
                'meta' => [
                    'total' => $organizers->total(),
                    'current_page' => $organizers->currentPage(),
                    'per_page' => $organizers->perPage()
                ]
            ]);
        }

        // Response untuk Web
        return view('organizer-list', compact('organizers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,organizer,user',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|string|in:Aktif,Non-Aktif' // Only validate status
        ]);

        $user->update([
            'status' => $request->status // Only update status
        ]);

        logActivity(
            'user',
            'Status User Diperbarui',
            $user->name . ' telah diperbarui oleh ' . Auth::user()->name . ' menjadi ' . $user->status
        );

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diperbarui',
            'data' => $user->refresh()
        ]);
    }


    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun sendiri'
            ], 403);
        }

        $user->delete();

        logActivity('user', 'User Dihapus', $user->name . ' telah dihapus oleh ' . Auth::user()->name);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
