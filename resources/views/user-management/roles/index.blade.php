<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Roles</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="{
             showCreate: {{ session('modal') === 'create' ? 'true' : 'false' }},
             showEdit: {{ session('modal') === 'edit' ? 'true' : 'false' }},
             editId: {{ session('edit_id', 0) }},
             editName: '{{ old('name', '') }}',
             editPermissions: {{ json_encode(old('permissions', [])) }},
             openEdit(id, name, permissions) {
                 this.editId = id;
                 this.editName = name;
                 this.editPermissions = permissions;
                 this.showEdit = true;
             }
         }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar Role</h3>
                <p class="text-sm text-slate-500">Total: {{ $roles->total() }} role</p>
            </div>
            <button @click="showCreate = true"
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-sage-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Role
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600 w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama Role</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Permissions</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Users</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($roles as $role)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500">{{ $roles->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $role->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    {{ $role->permissions_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEdit(Number($el.dataset.id), $el.dataset.name, JSON.parse($el.dataset.perms))"
                                            data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}"
                                            data-perms="{{ json_encode($role->permissions->pluck('name')->values()->all()) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('user-management.roles.destroy', $role) }}"
                                          onsubmit="return confirm('Hapus role ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $roles->links() }}</div>

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
                    <h3 class="text-base font-semibold text-slate-800">Tambah Role</h3>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('user-management.roles.store') }}" class="px-6 py-5 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="create_name" :value="__('Nama Role')" />
                        <x-text-input id="create_name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" autofocus />
                        @if(session('modal') === 'create')
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @endif
                    </div>
                    @if($permissions->isNotEmpty())
                    <div>
                        <x-input-label :value="__('Permissions')" />
                        <div class="mt-2 space-y-3 max-h-60 overflow-y-auto pr-1">
                            @foreach($permissions as $resource => $perms)
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                        {{ $resource }}
                                    </div>
                                    <div class="p-3 grid grid-cols-2 gap-y-1.5 gap-x-3">
                                        @foreach($perms as $permission)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                       class="rounded border-slate-300 text-primary focus:ring-primary"
                                                       {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                <span class="text-sm text-slate-700">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
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
                    <h3 class="text-base font-semibold text-slate-800">Edit Role</h3>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="'/user-management/roles/' + editId" class="px-6 py-5 space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label for="edit_name" :value="__('Nama Role')" />
                        <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full"
                            x-model="editName" />
                        @if(session('modal') === 'edit')
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @endif
                    </div>
                    @if($permissions->isNotEmpty())
                    <div>
                        <x-input-label :value="__('Permissions')" />
                        <div class="mt-2 space-y-3 max-h-60 overflow-y-auto pr-1">
                            @foreach($permissions as $resource => $perms)
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                        {{ $resource }}
                                    </div>
                                    <div class="p-3 grid grid-cols-2 gap-y-1.5 gap-x-3">
                                        @foreach($perms as $permission)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                       class="rounded border-slate-300 text-primary focus:ring-primary"
                                                       x-model="editPermissions">
                                                <span class="text-sm text-slate-700">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
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
