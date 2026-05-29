<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::withCount('roles')->latest()->paginate(15);
        return view('user-management.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        Permission::create(['name' => $request->name]);

        return redirect()->route('user-management.permissions.index')
            ->with('success', 'Permission berhasil dibuat.');
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', "unique:permissions,name,{$permission->id}"],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('modal', 'edit')->with('edit_id', $permission->id);
        }

        $permission->update(['name' => $request->name]);

        return redirect()->route('user-management.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission berhasil dihapus.');
    }
}
