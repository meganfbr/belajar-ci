<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $this->db->query('DELETE FROM product_category');
        $this->db->query('ALTER TABLE product_category AUTO_INCREMENT = 1');

        $data = [
             [
                'kategori' => 'Electronics',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kategori' => 'Laptops',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kategori' => 'Printers',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kategori' => 'Keyboards',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kategori' => 'Furniture',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Gunakan ignore(true) untuk melewati error duplikat (jika ada)
        $this->db->table('product_category')->ignore(true)->insertBatch($data);
    }
}