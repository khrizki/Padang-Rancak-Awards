<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');
        $perPage = $request->input('per_page', 10);

        $query = User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('name', $roleFilter);
                });
            })
            ->orderBy('created_at', 'desc');

        $users = $query->paginate($perPage)->withQueryString();

        $roles = Role::all()->pluck('name');

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => [
                'search' => $search,
                'role' => $roleFilter,
                'per_page' => $perPage,
            ],
            'availableRoles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $roles = Role::all()->pluck('name');

        return Inertia::render('Users/Create', [
            'availableRoles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        $user->load('roles');
        $roles = Role::all()->pluck('name');

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'availableRoles' => $roles,
            'userRoles' => $user->roles->pluck('name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
