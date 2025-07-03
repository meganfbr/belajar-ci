<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table = 'transaction_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'transaction_id',
        'product_id',
        'jumlah',
        'harga',
        'diskon',
        'subtotal'
    ];
}
