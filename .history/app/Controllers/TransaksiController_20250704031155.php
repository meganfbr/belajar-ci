<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;


class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apikey;
    protected $trasaction;
    protected $trasaction_detail;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();    


    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
{
    $this->cart->insert([
        'id'      => $this->request->getPost('id'),
        'qty'     => 1,
        'price'   => $this->request->getPost('harga'),
        'name'    => $this->request->getPost('nama'),
        'options' => ['foto' => $this->request->getPost('foto')]
    ]);

    // Perbaikan di sini (setFlashData dengan D besar)
    session()->setFlashData('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url('keranjang') . '">Lihat</a>)');

    return redirect()->to(base_url('/'));
}


    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
    $data['items'] = $this->cart->contents();
    $data['total'] = $this->cart->total();

    return view('v_checkout', $data);
    }

    public function getLocation()
{
		//keyword pencarian yang dikirimkan dari halaman checkout
    $search = $this->request->getGet('search');

    $response = $this->client->request(
        'GET', 
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
        ]
    );

    $body = json_decode($response->getBody(), true); 
    return $this->response->setJSON($body['data']);
}

public function getCost()
{ 
		//ID lokasi yang dikirimkan dari halaman checkout
    $destination = $this->request->getGet('destination');

		//parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
    //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
    $response = $this->client->request(
        'POST', 
        'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'multipart' => [
                [
                    'name' => 'origin',
                    'contents' => '64999'
                ],
                [
                    'name' => 'destination',
                    'contents' => $destination
                ],
                [
                    'name' => 'weight',
                    'contents' => '1000'
                ],
                [
                    'name' => 'courier',
                    'contents' => 'jne'
                ]
            ],
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
        ]

    
    );
    
    $body = json_decode($response->getBody(), true); 
    return $this->response->setJSON($body['data']);
    }

   public function buy()
{
    if ($this->request->getPost()) {
        $dataForm = [
            'username'    => $this->request->getPost('username'),
            'total_harga' => $this->request->getPost('total_harga'),
            'alamat'      => $this->request->getPost('alamat'),
            'ongkir'      => $this->request->getPost('ongkir'),
            'status'      => 0,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => date("Y-m-d H:i:s")
        ];

        $this->transaction->insert($dataForm);
        $last_insert_id = $this->transaction->getInsertID();

        // Ambil diskon dari session
        $diskon = session()->get('diskon_nominal') ?? 0;

        foreach ($this->cart->contents() as $value) {
            $harga_setelah_diskon = max(0, $value['price'] - $diskon); // per produk
            $dataFormDetail = [
                'transaction_id' => $last_insert_id,
                'product_id'     => $value['id'],
                'jumlah'         => $value['qty'],
                'diskon'         => $diskon,
                'harga'          => $value['price'], // simpan harga asli
                'subtotal_harga' => $value['qty'] * $harga_setelah_diskon,
                'created_at'     => date("Y-m-d H:i:s"),
                'updated_at'     => date("Y-m-d H:i:s")
            ];
            $this->transaction_detail->insert($dataFormDetail);
        }

        $this->cart->destroy();
        return redirect()->to(base_url('profile'))->with('success', 'Pesanan berhasil dibuat');
    }
}


public function detailTransaksi($id)
{
    $transactionModel = new TransactionModel();
    $detailModel = new TransactionDetailModel();

    $data['transaksi'] = $transactionModel->find($id);
    $data['details'] = $detailModel->where('transaction_id', $id)->findAll();

    return view('v_detail_transaksi', $data);
}

    
}
