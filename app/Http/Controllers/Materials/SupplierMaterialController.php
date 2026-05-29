<?php

namespace App\Http\Controllers\Materials;

use App\Http\Controllers\Controller;
use App\Models\SupplierMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierMaterialController extends Controller
{
    public function index()
    {
        $suppliers = SupplierMaterial::latest()->paginate(15);
        return view('materials.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => ['required', 'string', 'max:255'],
            'alamat'        => ['nullable', 'string'],
            'pic'           => ['nullable', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'no_hp'         => ['nullable', 'string', 'max:50'],
            'status'        => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        SupplierMaterial::create($request->all());

        return redirect()->route('materials.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, SupplierMaterial $supplier)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => ['required', 'string', 'max:255'],
            'alamat'        => ['nullable', 'string'],
            'pic'           => ['nullable', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'no_hp'         => ['nullable', 'string', 'max:50'],
            'status'        => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('modal', 'edit')->with('edit_id', $supplier->id);
        }

        $supplier->update($request->all());

        return redirect()->route('materials.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(SupplierMaterial $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier berhasil dihapus.');
    }
}
