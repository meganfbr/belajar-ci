<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProdukController extends BaseController
{
    protected $product; 

    public function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index()
    {
        $data['product'] = $this->product->findAll();
        return view('v_produk', $data);
    }

    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $dataForm = [
            'nama'       => $this->request->getPost('nama'),
            'harga'      => $this->request->getPost('harga'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        if ($dataFoto && $dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataFoto->move('img/', $fileName);
            $dataForm['foto'] = $fileName;
        }

        $this->product->insert($dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Ditambah');
    } 

    public function edit($id)
    {
        $dataProduk = $this->product->find($id);

        $dataForm = [
            'nama'       => $this->request->getPost('nama'),
            'harga'      => $this->request->getPost('harga'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            if (!empty($dataProduk['foto']) && file_exists("img/" . $dataProduk['foto'])) {
                unlink("img/" . $dataProduk['foto']);
            }

            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto && $dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('img/', $fileName);
                $dataForm['foto'] = $fileName;
            }
        }

        $this->product->update($id, $dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $dataProduk = $this->product->find($id);

        if (!empty($dataProduk['foto']) && file_exists("img/" . $dataProduk['foto'])) {
            unlink("img/" . $dataProduk['foto']);
        }

        $this->product->delete($id);

        return redirect('produk')->with('success', 'Data Berhasil Dihapus');
    }
}
