<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use CodeIgniter\Controller;

class TransaksiController extends BaseController
{
    protected $cart;

    public function __construct()
    {
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        helper('number');
        $data['cartItems'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
{
    $id = $this->request->getPost('id');
    $nama = $this->request->getPost('nama');
    $harga = $this->request->getPost('harga');
    $diskon = session()->get('diskon_nominal') ?? 0;

    $this->cart->insert([
        'id'    => $id,
        'qty'   => 1,
        'price' => max(0, $harga - $diskon), // harga setelah diskon
        'name'  => $nama,
        'options' => ['diskon' => $diskon]
    ]);

    session()->setFlashdata('success', 'Produk ditambahkan ke keranjang!');
    return redirect()->to('/keranjang');
}


public function buy()
{
    $transactionModel = new \App\Models\TransactionModel();
    $detailModel = new \App\Models\TransactionDetailModel();

    $username = session()->get('username');
    $items = $this->cart->contents();
    $total = $this->cart->total();
    $ongkir = $this->request->getPost('ongkir');
    $grand_total = $total + $ongkir;

    // Simpan transaksi
    $transactionModel->insert([
        'username'     => $username,
        'total'        => $total,
        'ongkir'       => $ongkir,
        'grand_total'  => $grand_total,
        'created_at'   => date('Y-m-d H:i:s'),
    ]);

    $transId = $transactionModel->getInsertID();

    // Simpan detail per produk
    foreach ($items as $item) {
        $detailModel->insert([
            'transaction_id' => $transId,
            'product_id'     => $item['id'],
            'jumlah'         => $item['qty'],
            'harga'          => $item['options']['harga_awal'],
            'diskon'         => $item['options']['diskon'],
            'subtotal'       => $item['subtotal'],
        ]);
    }

    $this->cart->destroy();
    session()->setFlashdata('success', 'Pesanan berhasil dibuat.');
    return redirect()->to('/');
}


    public function cart_edit()
    {
        $this->cart->update([
            'rowid' => $this->request->getPost('rowid'),
            'qty'   => $this->request->getPost('qty')
        ]);

        session()->setFlashdata('success', 'Keranjang diperbarui!');
        return redirect()->to('/keranjang');
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        return redirect()->to('/keranjang');
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        return redirect()->to('/keranjang');
    }

    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_checkout', $data);
    }
}