<?php

namespace Database\Seeders;

use App\Models\ItemMaterial;
use App\Models\SupplierMaterial;
use Illuminate\Database\Seeder;

class ItemMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $supplierIds = SupplierMaterial::pluck('id')->toArray();

        $items = [
            ['unique_no' => 'ITM-001', 'spec' => 'SPCC-1D',  'shape' => 'Flat',   'blank_thick' => 1.200, 'blank_width' => 200.000, 'blank_pitch' => 150.000, 'cut_thick' => 1.200, 'cut_width' => 195.000, 'cut_length' => 145.000, 'harga' => 125000.00],
            ['unique_no' => 'ITM-002', 'spec' => 'SPCC-SD',  'shape' => 'Flat',   'blank_thick' => 1.600, 'blank_width' => 250.000, 'blank_pitch' => 180.000, 'cut_thick' => 1.600, 'cut_width' => 245.000, 'cut_length' => 175.000, 'harga' => 175000.00],
            ['unique_no' => 'ITM-003', 'spec' => 'SPHC',     'shape' => 'Coil',   'blank_thick' => 2.000, 'blank_width' => 300.000, 'blank_pitch' => 200.000, 'cut_thick' => 2.000, 'cut_width' => 295.000, 'cut_length' => 195.000, 'harga' => 210000.00],
            ['unique_no' => 'ITM-004', 'spec' => 'SECC',     'shape' => 'Flat',   'blank_thick' => 0.800, 'blank_width' => 150.000, 'blank_pitch' => 120.000, 'cut_thick' => 0.800, 'cut_width' => 148.000, 'cut_length' => 118.000, 'harga' => 98000.00],
            ['unique_no' => 'ITM-005', 'spec' => 'SUS304',   'shape' => 'Sheet',  'blank_thick' => 1.000, 'blank_width' => 180.000, 'blank_pitch' => 130.000, 'cut_thick' => 1.000, 'cut_width' => 178.000, 'cut_length' => 128.000, 'harga' => 385000.00],
            ['unique_no' => 'ITM-006', 'spec' => 'SPCD',     'shape' => 'Flat',   'blank_thick' => 1.400, 'blank_width' => 220.000, 'blank_pitch' => 160.000, 'cut_thick' => 1.400, 'cut_width' => 218.000, 'cut_length' => 158.000, 'harga' => 145000.00],
            ['unique_no' => 'ITM-007', 'spec' => 'SPHD',     'shape' => 'Coil',   'blank_thick' => 2.300, 'blank_width' => 320.000, 'blank_pitch' => 220.000, 'cut_thick' => 2.300, 'cut_width' => 318.000, 'cut_length' => 218.000, 'harga' => 230000.00],
            ['unique_no' => 'ITM-008', 'spec' => 'SGCC',     'shape' => 'Sheet',  'blank_thick' => 0.600, 'blank_width' => 120.000, 'blank_pitch' => 100.000, 'cut_thick' => 0.600, 'cut_width' => 118.000, 'cut_length' => 98.000,  'harga' => 87000.00],
            ['unique_no' => 'ITM-009', 'spec' => 'SUS430',   'shape' => 'Flat',   'blank_thick' => 1.500, 'blank_width' => 240.000, 'blank_pitch' => 170.000, 'cut_thick' => 1.500, 'cut_width' => 238.000, 'cut_length' => 168.000, 'harga' => 320000.00],
            ['unique_no' => 'ITM-010', 'spec' => 'SPCC-2B',  'shape' => 'Coil',   'blank_thick' => 1.800, 'blank_width' => 280.000, 'blank_pitch' => 190.000, 'cut_thick' => 1.800, 'cut_width' => 278.000, 'cut_length' => 188.000, 'harga' => 195000.00],
        ];

        foreach ($items as $index => $item) {
            ItemMaterial::create(array_merge($item, [
                'supplier_id' => $supplierIds[$index % count($supplierIds)],
            ]));
        }
    }
}
