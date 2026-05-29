<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Supplier Materials</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="{
             showCreate: {{ session('modal') === 'create' ? 'true' : 'false' }},
             showEdit: {{ session('modal') === 'edit' ? 'true' : 'false' }},
             editId: {{ session('edit_id', 0) }},
             editData: {
                 nama_supplier: '{{ old('nama_supplier', '') }}',
                 alamat: '{{ old('alamat', '') }}',
                 pic: '{{ old('pic', '') }}',
                 email: '{{ old('email', '') }}',
                 no_hp: '{{ old('no_hp', '') }}',
                 status: '{{ old('status', 'active') }}'
             },
             openEdit(id, data) {
                 this.editId = id;
                 this.editData = data;
                 this.showEdit = true;
             }
         }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar Supplier</h3>
                <p class="text-sm text-slate-500">Total: {{ $suppliers->total() }} supplier</p>
            </div>
            <button @click="showCreate = true"
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-sage-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Supplier
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600 w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama Supplier</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">PIC</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">No. HP</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500">{{ $suppliers->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $supplier->nama_supplier }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $supplier->pic ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $supplier->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $supplier->no_hp ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $supplier->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $supplier->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEdit(Number($el.dataset.id), JSON.parse($el.dataset.edit))"
                                            data-id="{{ $supplier->id }}"
                                            data-edit="{{ json_encode(['nama_supplier' => $supplier->nama_supplier, 'alamat' => $supplier->alamat ?? '', 'pic' => $supplier->pic ?? '', 'email' => $supplier->email ?? '', 'no_hp' => $supplier->no_hp ?? '', 'status' => $supplier->status]) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('materials.suppliers.destroy', $supplier) }}"
                                          onsubmit="return confirm('Hapus supplier ini?')">
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
                            <td colspan="7" class="px-4 py-10 text-center text-slate-400">Belum ada data supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $suppliers->links() }}</div>

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
                    <h3 class="text-base font-semibold text-slate-800">Tambah Supplier</h3>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('materials.suppliers.store') }}" class="px-6 py-5 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="create_nama_supplier" :value="__('Nama Supplier')" />
                        <x-text-input id="create_nama_supplier" name="nama_supplier" type="text" class="mt-1 block w-full"
                            :value="old('nama_supplier')" autofocus />
                        @if(session('modal') === 'create')
                            <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                        @endif
                    </div>
                    <div>
                        <x-input-label for="create_alamat" :value="__('Alamat')" />
                        <textarea id="create_alamat" name="alamat" rows="2"
                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_pic" :value="__('PIC')" />
                            <x-text-input id="create_pic" name="pic" type="text" class="mt-1 block w-full"
                                :value="old('pic')" />
                        </div>
                        <div>
                            <x-input-label for="create_no_hp" :value="__('No. HP')" />
                            <x-text-input id="create_no_hp" name="no_hp" type="text" class="mt-1 block w-full"
                                :value="old('no_hp')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_email" :value="__('Email')" />
                            <x-text-input id="create_email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" />
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="create_status" :value="__('Status')" />
                            <select id="create_status" name="status"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
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
                    <h3 class="text-base font-semibold text-slate-800">Edit Supplier</h3>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="'/materials/suppliers/' + editId" class="px-6 py-5 space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label for="edit_nama_supplier" :value="__('Nama Supplier')" />
                        <x-text-input id="edit_nama_supplier" name="nama_supplier" type="text" class="mt-1 block w-full"
                            x-model="editData.nama_supplier" />
                        @if(session('modal') === 'edit')
                            <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                        @endif
                    </div>
                    <div>
                        <x-input-label for="edit_alamat" :value="__('Alamat')" />
                        <textarea id="edit_alamat" name="alamat" rows="2" x-model="editData.alamat"
                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_pic" :value="__('PIC')" />
                            <x-text-input id="edit_pic" name="pic" type="text" class="mt-1 block w-full"
                                x-model="editData.pic" />
                        </div>
                        <div>
                            <x-input-label for="edit_no_hp" :value="__('No. HP')" />
                            <x-text-input id="edit_no_hp" name="no_hp" type="text" class="mt-1 block w-full"
                                x-model="editData.no_hp" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_email" :value="__('Email')" />
                            <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full"
                                x-model="editData.email" />
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="edit_status" :value="__('Status')" />
                            <select id="edit_status" name="status" x-model="editData.status"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
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
