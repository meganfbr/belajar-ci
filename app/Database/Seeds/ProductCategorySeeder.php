<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kategori' => 'Laptop', 'created_at' => date("Y-m-d H:i:s")],
            ['kategori' => 'Smartphone', 'created_at' => date("Y-m-d H:i:s")],
            ['kategori' => 'Alat Tulis', 'created_at' => date("Y-m-d H:i:s")],
            ['kategori' => 'Buku', 'created_at' => date("Y-m-d H:i:s")],
            ['kategori' => 'Elektronik', 'created_at' => date("Y-m-d H:i:s")],
        ];

        foreach ($data as $item) {
            $this->db->table('product_category')->insert($item);
        }
    }
}
