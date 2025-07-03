<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\DiskonModel; // <- INI penting

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index(): string
    {   
    //  Logika diskon disisipkan di sini
    $diskonModel = new \App\Models\DiskonModel();
    $hariIni = date('Y-m-d');
    $diskonHariIni = $diskonModel->where('tanggal', $hariIni)->first();

    if ($diskonHariIni) {
        session()->set('diskon_nominal', $diskonHariIni['nominal']);
    } else {
        session()->set('diskon_nominal', '250000');
    }

    $produk = $this->product->findAll();

    return view('v_home', [
        'produk' => $produk,
        'product' => $produk
    ]);
    }


    public function profile()
    {
        $username = session()->get('username');

        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();

        $buy = $transactionModel
            ->where('username', $username)
            ->orderBy('created_at', 'desc')
            ->findAll();

        $details = $transactionDetailModel
            ->select('transaction_detail.*, product.nama, product.harga, product.foto')
            ->join('product', 'product.id = transaction_detail.product_id')
            ->findAll();

        $grouped = [];
        foreach ($details as $item) {
            $grouped[$item['transaction_id']][] = $item;
        }

        return view('v_profile', [
            'username' => $username,
            'buy' => $buy,
            'product' => $grouped
        ]);
    }
}
