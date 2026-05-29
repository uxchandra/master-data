<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierMaterial extends Model
{
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'pic',
        'email',
        'no_hp',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(ItemMaterial::class, 'supplier_id');
    }
}
