<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'username',
        'total_harga',
        'alamat',
        'kelurahan',
        'kelurahan_nama',
        'ongkir',
        'status',
        'created_at',
        'updated_at',
        'status_kirim',
        'status_bayar',
        'bukti_pembayaran' // ← tambahkan ini!
    ];
}
