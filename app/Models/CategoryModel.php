<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'description', 'parent_id', 'is_active'];
    protected $useTimestamps = true;
    
    public function getAllCategories()
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }
    
}