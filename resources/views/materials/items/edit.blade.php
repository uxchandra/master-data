<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Item Material</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <div class="h-1 bg-primary"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('materials.items.update', $item) }}" class="space-y-5">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="unique_no" :value="__('Unique No')" />
                            <x-text-input id="unique_no" name="unique_no" type="text" class="mt-1 block w-full font-mono"
                                :value="old('unique_no', $item->unique_no)" required autofocus />
                            <x-input-error :messages="$errors->get('unique_no')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="supplier_id" :value="__('Supplier')" />
                            <select id="supplier_id" name="supplier_id" required
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id', $item->supplier_id) == $supplier->id)>
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="spec" :value="__('Spec')" />
                            <x-text-input id="spec" name="spec" type="text" class="mt-1 block w-full"
                                :value="old('spec', $item->spec)" />
                            <x-input-error :messages="$errors->get('spec')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="shape" :value="__('Shape')" />
                            <x-text-input id="shape" name="shape" type="text" class="mt-1 block w-full"
                                :value="old('shape', $item->shape)" />
                            <x-input-error :messages="$errors->get('shape')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Blank Dimensions -->
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Blank Dimensions</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="blank_thick" :value="__('Thick')" />
                                <x-text-input id="blank_thick" name="blank_thick" type="number" step="0.001" class="mt-1 block w-full" :value="old('blank_thick', $item->blank_thick)" />
                                <x-input-error :messages="$errors->get('blank_thick')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="blank_width" :value="__('Width')" />
                                <x-text-input id="blank_width" name="blank_width" type="number" step="0.001" class="mt-1 block w-full" :value="old('blank_width', $item->blank_width)" />
                                <x-input-error :messages="$errors->get('blank_width')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="blank_pitch" :value="__('Pitch')" />
                                <x-text-input id="blank_pitch" name="blank_pitch" type="number" step="0.001" class="mt-1 block w-full" :value="old('blank_pitch', $item->blank_pitch)" />
                                <x-input-error :messages="$errors->get('blank_pitch')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Cut Dimensions -->
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Cut Dimensions</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cut_thick" :value="__('Thick')" />
                                <x-text-input id="cut_thick" name="cut_thick" type="number" step="0.001" class="mt-1 block w-full" :value="old('cut_thick', $item->cut_thick)" />
                                <x-input-error :messages="$errors->get('cut_thick')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cut_width" :value="__('Width')" />
                                <x-text-input id="cut_width" name="cut_width" type="number" step="0.001" class="mt-1 block w-full" :value="old('cut_width', $item->cut_width)" />
                                <x-input-error :messages="$errors->get('cut_width')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cut_length" :value="__('Length')" />
                                <x-text-input id="cut_length" name="cut_length" type="number" step="0.001" class="mt-1 block w-full" :value="old('cut_length', $item->cut_length)" />
                                <x-input-error :messages="$errors->get('cut_length')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="harga" :value="__('Harga (Rp)')" />
                        <x-text-input id="harga" name="harga" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('harga', $item->harga)" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('materials.items.index') }}"
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
