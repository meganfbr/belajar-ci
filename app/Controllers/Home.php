<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\ProducCategorytModel; 

class Home extends BaseController
{
     protected $product;

     function __construct()
     {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
     }
    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home', $data);
    }
}
