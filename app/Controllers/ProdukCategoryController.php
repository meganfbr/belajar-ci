<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;  

class ProdukCategoryController extends BaseController
{
    protected $model;
    
    public function __construct()
    {
        $this->model = new CategoryModel();
    }
    
    public function index()
    {
        $data = [
            'productcategory' => $this->model->getAllCategories(),
            'title' => 'Kategori Produk'
        ];
        return view('v_produkCategory', $data);
    }
    
    public function store()
    {
        $rules = [
            'kategori' => 'required|min_length[3]|max_length[100]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->getErrors());
        }
        
        $data = [
            'kategori' => $this->request->getPost('kategori'),
        ];
        
        if ($this->model->save($data)) {
            return redirect()->to('product-category')->with('success', 'Kategori berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('failed', 'Gagal menambahkan kategori');
        }
    }
    
    public function edit($id)
    {
        $rules = [
            'kategori' => 'required|min_length[3]|max_length[100]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->getErrors());
        }
        
        $data = [
            'kategori' => $this->request->getPost('kategori'),
        ];
        
        if ($this->model->update($id, $data)) {
            return redirect()->to('product-category')->with('success', 'Kategori berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('failed', 'Gagal memperbarui kategori');
        }
    }
    
    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('product-category')->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus kategori');
        }
    }
}