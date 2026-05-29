<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Item Materials</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="{
             showCreate: {{ session('modal') === 'create' ? 'true' : 'false' }},
             showEdit: {{ session('modal') === 'edit' ? 'true' : 'false' }},
             editId: {{ session('edit_id', 0) }},
             editData: {
                 supplier_id: '{{ old('supplier_id', '') }}',
                 unique_no: '{{ old('unique_no', '') }}',
                 spec: '{{ old('spec', '') }}',
                 shape: '{{ old('shape', '') }}',
                 blank_thick: '{{ old('blank_thick', '') }}',
                 blank_width: '{{ old('blank_width', '') }}',
                 blank_pitch: '{{ old('blank_pitch', '') }}',
                 cut_thick: '{{ old('cut_thick', '') }}',
                 cut_width: '{{ old('cut_width', '') }}',
                 cut_length: '{{ old('cut_length', '') }}',
                 harga: '{{ old('harga', '') }}'
             },
             openEdit(id, data) {
                 this.editId = id;
                 this.editData = data;
                 this.showEdit = true;
             }
         }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-700">Daftar Item</h3>
                <p class="text-sm text-slate-500">Total: {{ $items->total() }} item</p>
            </div>
            <button @click="showCreate = true"
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-sage-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Item
            </button>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600 w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Unique No</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Supplier</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Spec</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Shape</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Blank (T×W×P)</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Cut (T×W×L)</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Harga</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500">{{ $items->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-mono font-medium text-slate-800">{{ $item->unique_no }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->supplier?->nama_supplier ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600 max-w-xs truncate">{{ $item->spec ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->shape ?? '-' }}</td>
                            <td class="px-4 py-3 text-right text-slate-600 font-mono text-xs">
                                {{ $item->blank_thick ?? '-' }} × {{ $item->blank_width ?? '-' }} × {{ $item->blank_pitch ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-600 font-mono text-xs">
                                {{ $item->cut_thick ?? '-' }} × {{ $item->cut_width ?? '-' }} × {{ $item->cut_length ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-700 font-medium">
                                {{ $item->harga ? 'Rp ' . number_format($item->harga, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEdit(Number($el.dataset.id), JSON.parse($el.dataset.edit))"
                                            data-id="{{ $item->id }}"
                                            data-edit="{{ json_encode(['supplier_id' => $item->supplier_id, 'unique_no' => $item->unique_no, 'spec' => $item->spec ?? '', 'shape' => $item->shape ?? '', 'blank_thick' => $item->blank_thick ?? '', 'blank_width' => $item->blank_width ?? '', 'blank_pitch' => $item->blank_pitch ?? '', 'cut_thick' => $item->cut_thick ?? '', 'cut_width' => $item->cut_width ?? '', 'cut_length' => $item->cut_length ?? '', 'harga' => $item->harga ?? '']) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('materials.items.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus item ini?')">
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
                            <td colspan="9" class="px-4 py-10 text-center text-slate-400">Belum ada data item material.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $items->links() }}</div>

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
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="h-1 bg-primary"></div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-800">Tambah Item Material</h3>
                    <button @click="showCreate = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('materials.items.store') }}" class="px-6 py-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_supplier_id" :value="__('Supplier')" />
                            <select id="create_supplier_id" name="supplier_id"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="create_unique_no" :value="__('Unique No')" />
                            <x-text-input id="create_unique_no" name="unique_no" type="text" class="mt-1 block w-full font-mono"
                                :value="old('unique_no')" autofocus />
                            @if(session('modal') === 'create')
                                <x-input-error :messages="$errors->get('unique_no')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="create_spec" :value="__('Spec')" />
                            <x-text-input id="create_spec" name="spec" type="text" class="mt-1 block w-full"
                                :value="old('spec')" />
                        </div>
                        <div>
                            <x-input-label for="create_shape" :value="__('Shape')" />
                            <x-text-input id="create_shape" name="shape" type="text" class="mt-1 block w-full"
                                :value="old('shape')" />
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Blank Size</p>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="create_blank_thick" :value="__('Thick')" />
                                <x-text-input id="create_blank_thick" name="blank_thick" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('blank_thick')" />
                            </div>
                            <div>
                                <x-input-label for="create_blank_width" :value="__('Width')" />
                                <x-text-input id="create_blank_width" name="blank_width" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('blank_width')" />
                            </div>
                            <div>
                                <x-input-label for="create_blank_pitch" :value="__('Pitch')" />
                                <x-text-input id="create_blank_pitch" name="blank_pitch" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('blank_pitch')" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Cut Size</p>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="create_cut_thick" :value="__('Thick')" />
                                <x-text-input id="create_cut_thick" name="cut_thick" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('cut_thick')" />
                            </div>
                            <div>
                                <x-input-label for="create_cut_width" :value="__('Width')" />
                                <x-text-input id="create_cut_width" name="cut_width" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('cut_width')" />
                            </div>
                            <div>
                                <x-input-label for="create_cut_length" :value="__('Length')" />
                                <x-text-input id="create_cut_length" name="cut_length" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    :value="old('cut_length')" />
                            </div>
                        </div>
                    </div>
                    <div class="max-w-xs">
                        <x-input-label for="create_harga" :value="__('Harga (Rp)')" />
                        <x-text-input id="create_harga" name="harga" type="number" step="1" class="mt-1 block w-full font-mono"
                            :value="old('harga')" />
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
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="h-1 bg-primary"></div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-800">Edit Item Material</h3>
                    <button @click="showEdit = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="'/materials/items/' + editId" class="px-6 py-5 space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_supplier_id" :value="__('Supplier')" />
                            <select id="edit_supplier_id" name="supplier_id" x-model="editData.supplier_id"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="edit_unique_no" :value="__('Unique No')" />
                            <x-text-input id="edit_unique_no" name="unique_no" type="text" class="mt-1 block w-full font-mono"
                                x-model="editData.unique_no" />
                            @if(session('modal') === 'edit')
                                <x-input-error :messages="$errors->get('unique_no')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_spec" :value="__('Spec')" />
                            <x-text-input id="edit_spec" name="spec" type="text" class="mt-1 block w-full"
                                x-model="editData.spec" />
                        </div>
                        <div>
                            <x-input-label for="edit_shape" :value="__('Shape')" />
                            <x-text-input id="edit_shape" name="shape" type="text" class="mt-1 block w-full"
                                x-model="editData.shape" />
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Blank Size</p>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="edit_blank_thick" :value="__('Thick')" />
                                <x-text-input id="edit_blank_thick" name="blank_thick" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.blank_thick" />
                            </div>
                            <div>
                                <x-input-label for="edit_blank_width" :value="__('Width')" />
                                <x-text-input id="edit_blank_width" name="blank_width" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.blank_width" />
                            </div>
                            <div>
                                <x-input-label for="edit_blank_pitch" :value="__('Pitch')" />
                                <x-text-input id="edit_blank_pitch" name="blank_pitch" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.blank_pitch" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Cut Size</p>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="edit_cut_thick" :value="__('Thick')" />
                                <x-text-input id="edit_cut_thick" name="cut_thick" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.cut_thick" />
                            </div>
                            <div>
                                <x-input-label for="edit_cut_width" :value="__('Width')" />
                                <x-text-input id="edit_cut_width" name="cut_width" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.cut_width" />
                            </div>
                            <div>
                                <x-input-label for="edit_cut_length" :value="__('Length')" />
                                <x-text-input id="edit_cut_length" name="cut_length" type="number" step="0.001" class="mt-1 block w-full font-mono"
                                    x-model="editData.cut_length" />
                            </div>
                        </div>
                    </div>
                    <div class="max-w-xs">
                        <x-input-label for="edit_harga" :value="__('Harga (Rp)')" />
                        <x-text-input id="edit_harga" name="harga" type="number" step="1" class="mt-1 block w-full font-mono"
                            x-model="editData.harga" />
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
