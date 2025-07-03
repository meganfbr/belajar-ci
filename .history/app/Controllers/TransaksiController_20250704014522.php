<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper(['number', 'form']);
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
        $diskon = session()->get('diskon_nominal') ?? 0;
        $hargaAsli = (int) $this->request->getPost('harga');
        $hargaSetelahDiskon = max(0, $hargaAsli - $diskon);

        $this->cart->insert([
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $hargaSetelahDiskon,
            'name'    => $this->request->getPost('nama'),
            'options' => [
                'foto'        => $this->request->getPost('foto'),
                'harga_asli'  => $hargaAsli,
                'diskon'      => $diskon
            ]
        ]);

        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url('keranjang') . '">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setFlashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update([
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ]);
        }

        session()->setFlashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setFlashdata('success', 'Keranjang Berhasil Dihapus');
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
        $search = $this->request->getGet('search');

        $response = $this->client->request('GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50',
            [
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
        $destination = $this->request->getGet('destination');

        $response = $this->client->request('POST',
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            [
                'multipart' => [
                    ['name' => 'origin', 'contents' => '64999'],
                    ['name' => 'destination', 'contents' => $destination],
                    ['name' => 'weight', 'contents' => '1000'],
                    ['name' => 'courier', 'contents' => 'jne']
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
    // Ambil input dari form checkout
    $username     = $this->request->getPost('username');
    $alamat       = $this->request->getPost('alamat');
    $kelurahan    = $this->request->getPost('kelurahan');
    $layanan      = $this->request->getPost('layanan');
    $ongkir       = (int) $this->request->getPost('ongkir');
    $total_harga  = (int) $this->request->getPost('total_harga');

    // Ambil diskon dari session, jika ada
    $diskon = session()->get('diskon_nominal') ?? 0;
    $total_setelah_diskon = max(0, $total_harga - $diskon);

    // Simpan ke tabel `transaction`
    $data_transaksi = [
        'username'     => $username,
        'alamat'       => $alamat,
        'kelurahan'    => $kelurahan,
        'layanan'      => $layanan,
        'ongkir'       => $ongkir,
        'diskon'       => $diskon,
        'total_harga'  => $total_setelah_diskon,
        'created_at'   => date('Y-m-d H:i:s')
    ];

    $this->transaction->insert($data_transaksi);
    $transaction_id = $this->transaction->insertID(); // Ambil ID transaksi terbaru

    // Ambil isi keranjang
    $items = $this->cart->contents();

    // Simpan ke tabel `transaction_detail`
    foreach ($items as $item) {
        $this->transaction_detail->insert([
            'transaction_id' => $transaction_id,
            'product_id'     => $item['id'],
            'jumlah'         => $item['qty'],
            'harga'          => $item['price'],
            'subtotal_harga' => $item['subtotal'],
            'diskon'         => $item['options']['diskon'] ?? 0,
            'created_at'     => date('Y-m-d H:i:s')
        ]);
    }

    // Hapus isi keranjang
    $this->cart->destroy();

    // Redirect ke halaman sukses
    return redirect()->to('/pesanan/sukses')->with('success', 'Transaksi berhasil disimpan!');
}


}
