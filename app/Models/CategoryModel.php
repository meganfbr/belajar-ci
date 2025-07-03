<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'product_category';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori'];
    protected $useTimestamps = true;
    
    public function getAllCategories()
    {
        return $this->orderBy('kategori', 'ASC')->findAll();

    }
    
}