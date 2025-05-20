<?php

namespace App\Database\Seeds; 

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'All furniture products',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Living Room',
                'slug' => 'living-room',
                'description' => 'Living room furniture',
                'parent_id' => 1, // Assuming Furniture is ID 1
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bedroom',
                'slug' => 'bedroom',
                'description' => 'Bedroom furniture',
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dining Room',
                'slug' => 'dining-room',
                'description' => 'Dining room furniture',
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Office',
                'slug' => 'office',
                'description' => 'Office furniture',
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sofas',
                'slug' => 'sofas',
                'description' => 'Comfortable sofas for your living room',
                'parent_id' => 2, // Living Room
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Beds',
                'slug' => 'beds',
                'description' => 'Comfortable beds for your bedroom',
                'parent_id' => 3, // Bedroom
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('product_categories')->insertBatch($data);
    }
}