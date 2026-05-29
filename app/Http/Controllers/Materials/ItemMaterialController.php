<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Models\ItemMaterial;
use App\Models\SupplierMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemMaterialController extends Controller
{
    public function index()
    {
        $items = ItemMaterial::with('supplier')->latest()->paginate(15);
        $suppliers = SupplierMaterial::where('status', 'active')->orderBy('nama_supplier')->get();
        return view('materials.items.index', compact('items', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => ['required', 'exists:supplier_materials,id'],
            'unique_no'   => ['required', 'string', 'max:255', 'unique:item_materials'],
            'spec'        => ['nullable', 'string'],
            'shape'       => ['nullable', 'string', 'max:255'],
            'blank_thick' => ['nullable', 'numeric'],
            'blank_width' => ['nullable', 'numeric'],
            'blank_pitch' => ['nullable', 'numeric'],
            'cut_thick'   => ['nullable', 'numeric'],
            'cut_width'   => ['nullable', 'numeric'],
            'cut_length'  => ['nullable', 'numeric'],
            'harga'       => ['nullable', 'numeric'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        ItemMaterial::create($request->all());

        return redirect()->route('materials.items.index')
            ->with('success', 'Item material berhasil ditambahkan.');
    }

    public function update(Request $request, ItemMaterial $item)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => ['required', 'exists:supplier_materials,id'],
            'unique_no'   => ['required', 'string', 'max:255', "unique:item_materials,unique_no,{$item->id}"],
            'spec'        => ['nullable', 'string'],
            'shape'       => ['nullable', 'string', 'max:255'],
            'blank_thick' => ['nullable', 'numeric'],
            'blank_width' => ['nullable', 'numeric'],
            'blank_pitch' => ['nullable', 'numeric'],
            'cut_thick'   => ['nullable', 'numeric'],
            'cut_width'   => ['nullable', 'numeric'],
            'cut_length'  => ['nullable', 'numeric'],
            'harga'       => ['nullable', 'numeric'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('modal', 'edit')->with('edit_id', $item->id);
        }

        $item->update($request->all());

        return redirect()->route('materials.items.index')
            ->with('success', 'Item material berhasil diperbarui.');
    }

    public function destroy(ItemMaterial $item)
    {
        $item->delete();
        return back()->with('success', 'Item material berhasil dihapus.');
    }
}
