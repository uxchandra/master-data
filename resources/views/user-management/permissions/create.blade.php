<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Tambah Permission</h2>
    </x-slot>

    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <div class="h-1 bg-primary"></div>
            <div class="p-6">
                <p class="text-sm text-slate-500 mb-5">
                    Gunakan konvensi <code class="bg-slate-100 px-1 rounded text-xs">action resource</code>,
                    contoh: <code class="bg-slate-100 px-1 rounded text-xs">view users</code>,
                    <code class="bg-slate-100 px-1 rounded text-xs">create materials</code>.
                </p>
                <form method="POST" action="{{ route('user-management.permissions.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Permission')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full font-mono"
                            :value="old('name')" required autofocus placeholder="contoh: view users" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('user-management.permissions.index') }}"
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
