<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'customer_id',
        'sold_by',
        'quantity',
        'total_price',
        'created_at'
    ];
}