<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukCategorySeeder extends Seeder
{
    public function run()
    {
        $this->db->table('product_categories')->truncate();

        $data = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'All electronic products',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Various laptop models',
                'parent_id' => 1, // Anak dari Electronics
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Printers',
                'slug' => 'printers',
                'description' => 'All printer types',
                'parent_id' => 1, // Anak dari Electronics
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Keyboards',
                'slug' => 'keyboards',
                'description' => 'Computer keyboards',
                'parent_id' => 1, // Anak dari Electronics
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'Office and home furniture',
                'parent_id' => null, // Kategori utama
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
 
        ];

        // Gunakan ignore(true) untuk melewati error duplikat (jika ada)
        $this->db->table('product_categories')->ignore(true)->insertBatch($data);
    }
}