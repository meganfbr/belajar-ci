<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

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
        $produk = $this->product->findAll();

        // Kirim dengan 2 nama variabel agar tidak error di view
        return view('v_home', [
            'produk' => $produk,
            'product' => $produk
        ]);
    }

     public function profile()
{
    $username = session()->get('username');

    $transactionModel = new \App\Models\TransactionModel();
    $transactionDetailModel = new \App\Models\TransactionDetailModel();
    $productModel = new \App\Models\ProductModel();

    $buy = $transactionModel
        ->where('username', $username)
        ->orderBy('created_at', 'desc')
        ->findAll();

    $details = $transactionDetailModel
        ->select('transaction_detail.*, product.nama, product.harga, product.foto')
        ->join('product', 'product.id = transaction_detail.product_id')
        ->findAll();

    // Grouping by transaction_id
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
