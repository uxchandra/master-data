<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Tambah Role</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <div class="h-1 bg-primary"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('user-management.roles.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Role')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" required autofocus placeholder="contoh: admin, editor, viewer" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    @if($permissions->isNotEmpty())
                    <div>
                        <x-input-label :value="__('Permissions')" />
                        <div class="mt-2 space-y-3">
                            @foreach($permissions as $group => $perms)
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ $group }}
                                    </div>
                                    <div class="p-3 grid grid-cols-2 sm:grid-cols-3 gap-2">
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
                        <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                    </div>
                    @endif

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('user-management.roles.index') }}"
                           class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                            Batal
                        </a>
                        <x-primary-button class="bg-primary hover:bg-sage-700">Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
