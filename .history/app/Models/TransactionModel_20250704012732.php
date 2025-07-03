<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction'; // ✅ Nama tabel sesuai dengan di database
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'alamat',
        'kelurahan',
        'layanan',
        'ongkir',
        'diskon',
        'total_harga',
        'created_at',
        'updated_at',
        'status' // jika ada kolom status
    ];
}
