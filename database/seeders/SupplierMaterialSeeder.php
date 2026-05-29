<?php

namespace Database\Seeders;

use App\Models\SupplierMaterial;
use Illuminate\Database\Seeder;

class SupplierMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['nama_supplier' => 'PT Baja Nusantara',      'alamat' => 'Jl. Industri No. 1, Bekasi',         'pic' => 'Budi Santoso',   'email' => 'budi@bajanusantara.co.id',   'no_hp' => '081234567890', 'status' => 'active'],
            ['nama_supplier' => 'CV Logam Sejati',         'alamat' => 'Jl. Raya Cibitung No. 45, Bekasi',   'pic' => 'Siti Rahayu',    'email' => 'siti@logamsejati.co.id',     'no_hp' => '082345678901', 'status' => 'active'],
            ['nama_supplier' => 'PT Steel Prima',          'alamat' => 'Jl. Gatot Subroto No. 12, Jakarta',  'pic' => 'Ahmad Fauzi',    'email' => 'ahmad@steelprima.com',       'no_hp' => '083456789012', 'status' => 'active'],
            ['nama_supplier' => 'PT Metal Karya Utama',   'alamat' => 'Jl. Jababeka Blok C No. 7, Cikarang', 'pic' => 'Dewi Lestari',   'email' => 'dewi@metalkarya.co.id',      'no_hp' => '084567890123', 'status' => 'active'],
            ['nama_supplier' => 'CV Sumber Besi',          'alamat' => 'Jl. Rungkut Industri No. 23, Surabaya', 'pic' => 'Rudi Hartono', 'email' => 'rudi@sumberbesi.co.id',    'no_hp' => '085678901234', 'status' => 'active'],
            ['nama_supplier' => 'PT Nippon Steel Indonesia', 'alamat' => 'Jl. MM2100 Blok A, Cikarang',     'pic' => 'Kenji Tanaka',   'email' => 'kenji@nippon-id.co.id',      'no_hp' => '086789012345', 'status' => 'active'],
            ['nama_supplier' => 'PT Krakatau Steel',       'alamat' => 'Jl. Industri No. 5, Cilegon',       'pic' => 'Hendra Wijaya',  'email' => 'hendra@krakatausteel.co.id', 'no_hp' => '087890123456', 'status' => 'active'],
            ['nama_supplier' => 'CV Maju Bersama Metal',  'alamat' => 'Jl. Narogong Km. 7, Bogor',          'pic' => 'Rina Susanti',   'email' => 'rina@majubersama.co.id',     'no_hp' => '088901234567', 'status' => 'inactive'],
            ['nama_supplier' => 'PT Tirta Logam',          'alamat' => 'Jl. Daan Mogot No. 88, Tangerang',  'pic' => 'Agus Pramono',   'email' => 'agus@tirtalogam.co.id',      'no_hp' => '089012345678', 'status' => 'active'],
            ['nama_supplier' => 'PT Global Steel Asia',   'alamat' => 'Jl. Margomulyo No. 34, Surabaya',    'pic' => 'Lisa Permata',   'email' => 'lisa@globalsteel.co.id',     'no_hp' => '081123456789', 'status' => 'active'],
        ];

        foreach ($suppliers as $supplier) {
            SupplierMaterial::create($supplier);
        }
    }
}
