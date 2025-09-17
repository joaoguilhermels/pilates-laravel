<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:system_admin,studio_owner');
    }

    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $users = User::with('roles')->get();
        
        return view('roles.index', compact('roles', 'users'));
    }

    /**
     * Show users with specific role.
     */
    public function show(Role $role)
    {
        $users = User::role($role->name)->with('roles')->get();
        
        return view('roles.show', compact('role', 'users'));
    }

    /**
     * Assign role to user.
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Função atribuída com sucesso!');
    }

    /**
     * Remove role from user.
     */
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->removeRole($request->role);

        return redirect()->back()->with('success', 'Função removida com sucesso!');
    }
}
