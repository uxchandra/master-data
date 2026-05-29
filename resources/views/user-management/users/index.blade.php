<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Users</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="{
             showCreate: {{ session('modal') === 'create' ? 'true' : 'false' }},
             showEdit: {{ session('modal') === 'edit' ? 'true' : 'false' }},
             editId: {{ session('edit_id', 0) }},
             editName: '{{ old('name', '') }}',
             editUsername: '{{ old('username', '') }}',
             editRoles: {{ json_encode(old('roles', [])) }},
             openEdit(id, name, username, roles) {
                 this.editId = id;
                 this.editName = name;
                 this.editUsername = username;
                 this.editRoles = roles;
                 this.showEdit = true;
             }
         }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar User</h3>
                <p class="text-sm text-slate-500">Total: {{ $users->total() }} user</p>
            </div>
            <button @click="showCreate = true"
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-sage-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600 w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Username</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Roles</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Dibuat</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500">{{ $users->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-sm shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-slate-600">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-slate-400 text-xs">–</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEdit(Number($el.dataset.id), $el.dataset.name, $el.dataset.username, JSON.parse($el.dataset.roles))"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-username="{{ $user->username }}"
                                            data-roles="{{ json_encode($user->roles->pluck('name')->values()->all()) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition">
                                        Edit
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                    <form method="POST" action="{{ route('user-management.users.destroy', $user) }}"
                                          onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>

        {{-- CREATE MODAL --}}
        <div x-show="showCreate" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50" @click="showCreate = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="h-1 bg-primary"></div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-800">Tambah User</h3>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('user-management.users.store') }}" class="px-6 py-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_name" :value="__('Nama Lengkap')" />
                            <x-text-input id="create_name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" autofocus />
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="create_username" :value="__('Username')" />
                            <x-text-input id="create_username" name="username" type="text" class="mt-1 block w-full font-mono"
                                :value="old('username')" />
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_password" :value="__('Password')" />
                            <x-text-input id="create_password" name="password" type="password" class="mt-1 block w-full" />
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="create_password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="create_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>
                    @if($roles->isNotEmpty())
                    <div>
                        <x-input-label :value="__('Roles')" />
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            @foreach($roles as $role)
                                <label class="flex items-center gap-2 p-2 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           class="rounded border-slate-300 text-primary focus:ring-primary"
                                           {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showCreate = false"
                                class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                            Batal
                        </button>
                        <x-primary-button class="bg-primary hover:bg-sage-700">Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div x-show="showEdit" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50" @click="showEdit = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="h-1 bg-primary"></div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-800">Edit User</h3>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="'/user-management/users/' + editId" class="px-6 py-5 space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_name" :value="__('Nama Lengkap')" />
                            <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full"
                                x-model="editName" />
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="edit_username" :value="__('Username')" />
                            <x-text-input id="edit_username" name="username" type="text" class="mt-1 block w-full font-mono"
                                x-model="editUsername" />
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_password" :value="__('Password Baru (opsional)')" />
                            <x-text-input id="edit_password" name="password" type="password" class="mt-1 block w-full"
                                placeholder="Kosongkan jika tidak diganti" />
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="edit_password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="edit_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>
                    @if($roles->isNotEmpty())
                    <div>
                        <x-input-label :value="__('Roles')" />
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            @foreach($roles as $role)
                                <label class="flex items-center gap-2 p-2 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           class="rounded border-slate-300 text-primary focus:ring-primary"
                                           x-model="editRoles">
                                    <span class="text-sm text-slate-700">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showEdit = false"
                                class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                            Batal
                        </button>
                        <x-primary-button class="bg-primary hover:bg-sage-700">Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
