<?php

namespace App\Models;
use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = ['id_transaksi','id_produk','qty','harga'];
}