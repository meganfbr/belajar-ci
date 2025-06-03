<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class ProductCategoryController extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new ProductCategoryModel();
    }

    public function index()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('v_productcategory', $data);
    }

    public function create()
    {
        $this->kategoriModel->insert([
            'kategori' => $this->request->getPost('nama')
        ]);
        return redirect()->to('kategori-produk')->with('success', 'Data Berhasil Ditambah');
    }

    public function update($id)
    {
        $data = [
            'kategori' => $this->request->getPost('nama')
        ];

        $this->kategoriModel->update($id, $data);

        return redirect()->to('/kategori-produk')->with('success', 'Kategori berhasil diupdate.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('kategori-produk')->with('success', 'Data Berhasil Dihapus');
    }
}
