<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(10);
        $roles = Role::all();
        $ticketCategories = TicketCategory::all();
        return view('pages.admin.user-management.index', compact('user', 'roles', 'ticketCategories'));
    }

    public function show()
    {
        $users = User::with(['role'])
            ->withCount(['tickets as tiket_ditangani' => function ($query) {
                $query->where('status', '!=', 'closed');
            }])
            ->get()
            ->map(function ($user) {
                $status = !$user->deleted_at ? 'Aktif' : 'Nonaktif';

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'phone' => $user->phone,
                    'departemen' => '-',
                    'wilayah' => '-',
                    'status' => $status,
                    'tiket_ditangani' => $user->role?->id === 2 ? $user->tiket_ditangani : '-',
                    'terakhir_login' => optional($user->last_seen)->diffForHumans() ?? '-',
                    'email' => $user->email,
                ];
            });

        return response()->json(['data' => $users]);
    }

    public function create()
    {
        return view('pages.admin.user-management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'role_id' => 'required|integer',
            'phone' => 'required|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('settings.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'role_id' => 'required|integer',
            'phone' => 'required|string',
        ]);

        $user->update($request->only('name', 'email', 'role_id', 'phone'));

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui!',
            'data' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus!'
        ]);
    }
}
