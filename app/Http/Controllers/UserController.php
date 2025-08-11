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
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');

        $query = User::where('role', 'organizer')
            ->withCount('events');

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate($perPage);

        // Mapping ke format yang dibutuhkan frontend
        $data->getCollection()->transform(function ($item) {
            return [
                'user_id' => $item->user_id,
                'name' => $item->name,
                'status' => $item->status,
                'total_events' => $item->events_count
            ];
        });

        return response()->json([
            'total' => $data->total(),
            'data' => $data->items()
        ]);
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
