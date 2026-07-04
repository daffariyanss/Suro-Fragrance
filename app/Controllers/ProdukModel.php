<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'parfum';
    protected $primaryKey = 'id_parfum';

    protected $allowedFields = [
        'nama',
        'brand',
        'harga',
        'stok',
        'kategori',
        'deskripsi',
        'gambar'
    ];
}