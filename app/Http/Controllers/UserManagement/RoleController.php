<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('permissions', 'users')->latest()->paginate(15);
        $permissions = Permission::orderBy('name')->get()->groupBy(fn($p) => explode(' ', $p->name)[1] ?? 'general');
        return view('user-management.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        $role = Role::create(['name' => $request->name]);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('user-management.roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'max:255', "unique:roles,name,{$role->id}"],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('modal', 'edit')->with('edit_id', $role->id);
        }

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('user-management.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role berhasil dihapus.');
    }
}
