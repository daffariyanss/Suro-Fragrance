<?php

namespace App\Controllers;

use App\Models\ParfumModel;
use App\Models\KategoriModel;
use App\Models\PelangganModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $parfumModel = new ParfumModel();
        $kategoriModel = new KategoriModel();
        $pelangganModel = new PelangganModel();
        $transaksiModel = new TransaksiModel();

        return view('dashboard', [
            'title' => 'Dashboard',
            'total' => $parfumModel->countAll(),
            'total_kategori' => $kategoriModel->countAll(),
            'total_pelanggan' => $pelangganModel->countAll(),
            'total_penjualan' => $transaksiModel->countAll(),
        ]);
    }
}
