<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMaterial extends Model
{
    protected $fillable = [
        'supplier_id',
        'unique_no',
        'spec',
        'shape',
        'blank_thick',
        'blank_width',
        'blank_pitch',
        'cut_thick',
        'cut_width',
        'cut_length',
        'harga',
    ];

    public function supplier()
    {
        return $this->belongsTo(SupplierMaterial::class, 'supplier_id');
    }
}
