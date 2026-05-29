<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Supplier</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <div class="h-1 bg-primary"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('materials.suppliers.update', $supplier) }}" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <x-input-label for="nama_supplier" :value="__('Nama Supplier')" />
                        <x-text-input id="nama_supplier" name="nama_supplier" type="text" class="mt-1 block w-full"
                            :value="old('nama_supplier', $supplier->nama_supplier)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <textarea id="alamat" name="alamat" rows="3"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">{{ old('alamat', $supplier->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="pic" :value="__('PIC')" />
                            <x-text-input id="pic" name="pic" type="text" class="mt-1 block w-full"
                                :value="old('pic', $supplier->pic)" />
                            <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="no_hp" :value="__('No. HP')" />
                            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full"
                                :value="old('no_hp', $supplier->no_hp)" />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $supplier->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="active" @selected(old('status', $supplier->status) === 'active')>Active</option>
                                <option value="inactive" @selected(old('status', $supplier->status) === 'inactive')>Inactive</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('materials.suppliers.index') }}"
                           class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                            Batal
                        </a>
                        <x-primary-button class="bg-primary hover:bg-sage-700">Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
