<?php

namespace App\Controllers;

use App\Models\ParfumModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SuroFragrance extends BaseController
{
    protected ParfumModel $parfumModel;
    protected KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->parfumModel   = new ParfumModel();
        $this->kategoriModel = new KategoriModel();
    }

    // ==============================
    // INDEX (READ)
    // ==============================
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }
        $semuaParfum = $this->parfumModel
            ->select('parfum.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->orderBy('parfum.id_parfum', 'ASC')
            ->findAll();

        return view('suro/index', [
            'title' => 'Semua Koleksi Parfum',
            'parfum' => $semuaParfum,
        ]);
    }

    // ==============================
    // CREATE (FORM TAMBAH)
    // ==============================
    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('suro/create', [
            'title' => 'Tambah Parfum',
            'semuaKategori' => $this->kategoriModel->findAll(),
        ]);
    }
    // ==============================
    // STORE (SIMPAN DATA)
    // ==============================
    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $this->request->getPost();

        if (!$this->parfumModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->parfumModel->errors());
        }

        return redirect()->to('/barang')
            ->with('sukses', 'Data berhasil ditambahkan');
    }

    // ==============================
    // EDIT (FORM EDIT)
    // ==============================
    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $parfum = $this->parfumModel->find($id);

        if (!$parfum) {
            throw new PageNotFoundException('Data tidak ditemukan');
        }

        return view('suro/edit', [
            'title' => 'Edit Parfum',
            'parfum' => $parfum,
            'semuaKategori' => $this->kategoriModel->findAll(),
        ]);
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $this->request->getPost();
        $data['id_parfum'] = $id;

        // FIX GAMBAR AGAR TIDAK HILANG / SALAH
        $gambarBaru = $this->request->getPost('gambar');
        $gambarLama = $this->request->getPost('gambar_lama');

        if (empty($gambarBaru)) {
            $data['gambar'] = $gambarLama;
        } else {
            $data['gambar'] = $gambarBaru;
        }

        if (!$this->parfumModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->parfumModel->errors());
        }

        return redirect()->to('/barang')
            ->with('sukses', 'Data berhasil diupdate');
    }

    // ==============================
    // DELETE
    // ==============================
    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->parfumModel->delete($id);

        return redirect()->to('/barang')
            ->with('sukses', 'Data berhasil dihapus');
    }

    // ==============================
    // FILTER KATEGORI (BONUS)
    // ==============================
    public function filterKategori($id_kategori = 1)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $parfumFiltered = $this->parfumModel
            ->select('parfum.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->where('parfum.id_kategori', $id_kategori)
            ->orderBy('parfum.nama_parfum', 'ASC')
            ->findAll();

        return view('suro/filter', [
            'title' => 'Filter Parfum',
            'parfumFiltered' => $parfumFiltered,
            'kategoriDipilih' => $this->kategoriModel->find($id_kategori),
            'semuaKategori' => $this->kategoriModel->findAll(),
            'id_aktif' => $id_kategori,
        ]);
    }

    // ==============================
    // DEMONSTRASI QUERY (BONUS)
    // ==============================
    public function demonstrasi()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }
        $db = \Config\Database::connect();

        $q1 = $db->table('parfum')
            ->select('parfum.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->get()->getResultArray();

        $q2 = $db->table('parfum')
            ->select('parfum.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->where('parfum.id_kategori', 2)
            ->get()->getResultArray();

        $q3 = $db->table('parfum')
            ->select('parfum.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->where('parfum.harga >=', 1000000)
            ->orderBy('parfum.harga', 'DESC')
            ->get()->getResultArray();

        $q4 = $db->table('parfum')
            ->select('kategori.nama_kategori, COUNT(parfum.id_parfum) as jumlah_parfum, SUM(parfum.stok) as total_stok')
            ->join('kategori', 'kategori.id_kategori = parfum.id_kategori')
            ->groupBy('kategori.id_kategori')
            ->get()->getResultArray();

        return view('suro/demonstrasi', [
            'title' => 'Demo Query',
            'q1_semuaParfum' => $q1,
            'q2_extrait' => $q2,
            'q3_premium' => $q3,
            'q4_perKategori' => $q4,
        ]);
    }
}
