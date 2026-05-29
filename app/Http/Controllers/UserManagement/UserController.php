<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        $roles = Role::orderBy('name')->get();
        return view('user-management.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles'    => ['nullable', 'array'],
            'roles.*'  => ['exists:roles,name'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('user-management.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', "unique:users,username,{$user->id}"],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles'    => ['nullable', 'array'],
            'roles.*'  => ['exists:roles,name'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('modal', 'edit')->with('edit_id', $user->id);
        }

        $data = ['name' => $request->name, 'username' => $request->username];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        $user->syncRoles($request->roles ?? []);

        return redirect()->route('user-management.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
