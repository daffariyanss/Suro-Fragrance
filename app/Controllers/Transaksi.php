<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\PelangganModel;

class Transaksi extends BaseController
{
    private function getActivePelangganId(): int
    {
        $pelangganModel = new PelangganModel();
        $emailLogin = trim((string) session()->get('email'));
        $pelangganAktif = $pelangganModel->where('email', $emailLogin)->first();

        return (int) ($pelangganAktif['id_pelanggan'] ?? 0);
    }

    private function assertOwnTransaction(int $idTransaksi): ?array
    {
        if (session()->get('role') === 'admin') {
            return null;
        }

        $idPelanggan = $this->getActivePelangganId();
        $model = new TransaksiModel();
        $transaksi = $model->find($idTransaksi);

        if (! $transaksi || (int) $transaksi['id_pelanggan'] !== $idPelanggan) {
            return ['error' => 'Transaksi tidak ditemukan.'];
        }

        return $transaksi;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }
        $model = new TransaksiModel();
        $pelanggan = new PelangganModel();

        $data['transaksi'] = $model
            ->select('transaksi.*, pelanggan.nama')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi.id_pelanggan')
            ->orderBy('transaksi.id_transaksi', 'DESC')
            ->findAll();

        return view('transaksi/index', $data);
    }

    public function history()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $model = new TransaksiModel();
        $isAdmin = session()->get('role') === 'admin';
        $pelangganModel = new PelangganModel();

        if ($isAdmin) {
            return redirect()->to('/transaksi');
        }

        $idPelanggan = $this->getActivePelangganId();

        if (! $idPelanggan) {
            return view('transaksi/history', [
                'transaksi' => [],
            ]);
        }

        $data['transaksi'] = $model
            ->select('transaksi.*, pelanggan.nama')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi.id_pelanggan')
            ->where('transaksi.id_pelanggan', $idPelanggan)
            ->orderBy('transaksi.id_transaksi', 'DESC')
            ->findAll();

        return view('transaksi/history', $data);
    }

    public function editHistory(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (session()->get('role') === 'admin') {
            return redirect()->to('/transaksi');
        }

        $transaksi = $this->assertOwnTransaction($id);
        if (isset($transaksi['error'])) {
            return redirect()->to('/riwayat-pembelian')->with('error', $transaksi['error']);
        }

        $detailModel = new DetailTransaksiModel();
        $parfumModel = new \App\Models\ParfumModel();

        $details = $detailModel
            ->where('id_transaksi', $id)
            ->findAll();

        return view('transaksi/edit', [
            'transaksi' => $transaksi,
            'produk' => $parfumModel->findAll(),
            'details' => $details,
        ]);
    }

    public function updateHistory(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (session()->get('role') === 'admin') {
            return redirect()->to('/transaksi');
        }

        $transaksi = $this->assertOwnTransaction($id);
        if (isset($transaksi['error'])) {
            return redirect()->to('/riwayat-pembelian')->with('error', $transaksi['error']);
        }

        $db = \Config\Database::connect();
        $detailModel = new DetailTransaksiModel();
        $parfumModel = new \App\Models\ParfumModel();
        $transaksiModel = new TransaksiModel();

        $produk = (array) $this->request->getPost('produk');
        $qty = (array) $this->request->getPost('qty');
        $items = [];

        foreach ($produk as $i => $p) {
            $idParfum = (int) ($p ?? 0);
            $jumlah = (int) ($qty[$i] ?? 0);
            if ($idParfum > 0 && $jumlah > 0) {
                $items[$idParfum] = ($items[$idParfum] ?? 0) + $jumlah;
            }
        }

        if (empty($items)) {
            return redirect()->back()->with('error', 'Produk belum valid.');
        }

        $db->transStart();

        $existingDetails = $detailModel->where('id_transaksi', $id)->findAll();
        foreach ($existingDetails as $detail) {
            $parfum = $parfumModel->find((int) $detail['id_produk']);
            if ($parfum) {
                $parfumModel->update((int) $detail['id_produk'], [
                    'stok' => ((int) $parfum['stok']) + (int) $detail['qty'],
                ]);
            }
        }
        $detailModel->where('id_transaksi', $id)->delete();

        $total = 0;
        foreach ($items as $idParfum => $jumlah) {
            $parfum = $parfumModel->find($idParfum);
            if (! $parfum) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
            if ((int) $parfum['stok'] < $jumlah) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Stok "' . $parfum['nama_parfum'] . '" tidak cukup.');
            }
            $harga = (int) $parfum['harga'];
            $total += $harga * $jumlah;
            $detailModel->insert([
                'id_transaksi' => $id,
                'id_produk' => $idParfum,
                'qty' => $jumlah,
                'harga' => $harga,
            ]);
            $parfumModel->update($idParfum, [
                'stok' => ((int) $parfum['stok']) - $jumlah,
            ]);
        }

        $transaksiModel->update($id, ['total' => $total]);
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi.');
        }

        return redirect()->to('/riwayat-pembelian')->with('sukses', 'Transaksi berhasil diubah.');
    }

    public function cancelHistory(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (session()->get('role') === 'admin') {
            return redirect()->to('/transaksi');
        }

        $transaksi = $this->assertOwnTransaction($id);
        if (isset($transaksi['error'])) {
            return redirect()->to('/riwayat-pembelian')->with('error', $transaksi['error']);
        }

        $db = \Config\Database::connect();
        $detailModel = new DetailTransaksiModel();
        $parfumModel = new \App\Models\ParfumModel();
        $transaksiModel = new TransaksiModel();

        $db->transStart();
        foreach ($detailModel->where('id_transaksi', $id)->findAll() as $detail) {
            $parfum = $parfumModel->find((int) $detail['id_produk']);
            if ($parfum) {
                $parfumModel->update((int) $detail['id_produk'], [
                    'stok' => ((int) $parfum['stok']) + (int) $detail['qty'],
                ]);
            }
        }
        $detailModel->where('id_transaksi', $id)->delete();
        $transaksiModel->delete($id);
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal membatalkan transaksi.');
        }

        return redirect()->to('/riwayat-pembelian')->with('sukses', 'Transaksi dibatalkan.');
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $pelanggan = new PelangganModel();
        $parfum = new \App\Models\ParfumModel();
        $selectedProduk = (int) ($this->request->getGet('produk') ?? 0);
        $isAdmin = session()->get('role') === 'admin';

        return view('transaksi/create', [
            'pelanggan' => $isAdmin ? $pelanggan->findAll() : [],
            'produk' => $parfum->findAll(), // tetap pakai nama 'produk' di view
            'selectedProduk' => $selectedProduk,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $transaksiModel = new TransaksiModel();
        $detailModel = new DetailTransaksiModel();
        $parfumModel = new \App\Models\ParfumModel();

        $id_pelanggan = $this->request->getPost('id_pelanggan');
        $nama_pelanggan_baru = $this->request->getPost('nama_pelanggan_baru');
        $produk = (array) $this->request->getPost('produk'); // id_parfum[]
        $qty = (array) $this->request->getPost('qty');
        $isAdmin = session()->get('role') === 'admin';

        if (empty($produk) || empty($qty)) {
            return redirect()->back()->with('error', 'Produk/qty belum diisi');
        }

        $items = [];
        foreach ($produk as $i => $p) {
            $idParfum = (int) ($p ?? 0);
            $jumlah = (int) ($qty[$i] ?? 0);

            if ($idParfum <= 0 || $jumlah <= 0) {
                continue;
            }

            if (! isset($items[$idParfum])) {
                $items[$idParfum] = 0;
            }

            $items[$idParfum] += $jumlah;
        }

        if (empty($items)) {
            return redirect()->back()->with('error', 'Produk/qty belum valid');
        }

        $total = 0;

        $db->transStart();

        $pelangganModel = new PelangganModel();

        if ($isAdmin) {
            // If user provided a new customer name, create the pelanggan first
            if (($id_pelanggan === 'new' || empty($id_pelanggan)) && !empty($nama_pelanggan_baru)) {
                $id_pelanggan = $pelangganModel->insert([
                    'nama' => $nama_pelanggan_baru,
                    'email' => null,
                ]);
            }
        } else {
            $emailLogin = (string) session()->get('email');
            $pelangganAktif = $pelangganModel->where('email', $emailLogin)->first();

            if (! $pelangganAktif) {
                $id_pelanggan = $pelangganModel->insert([
                    'nama' => (string) (session()->get('username') ?? 'Pelanggan'),
                    'email' => $emailLogin,
                ]);
            } else {
                $id_pelanggan = $pelangganAktif['id_pelanggan'];
            }
        }

        if (empty($id_pelanggan) || $id_pelanggan === 'new') {
            $db->transRollback();
            return redirect()->back()->with('error', 'Data pelanggan belum dipilih.');
        }

        $id_transaksi = $transaksiModel->insert([
            'id_pelanggan' => $id_pelanggan,
            'total' => 0
        ]);

        foreach ($items as $idParfum => $jumlah) {
            $dataParfum = $parfumModel->find($idParfum);
            if (!$dataParfum) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            if ((int) $dataParfum['stok'] < $jumlah) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Stok produk "' . $dataParfum['nama_parfum'] . '" tidak mencukupi.');
            }

            $harga = (int) $dataParfum['harga'];
            $subtotal = $harga * $jumlah;

            $total += $subtotal;

            $detailModel->insert([
                'id_transaksi' => $id_transaksi,
                'id_produk' => $idParfum,
                'qty' => $jumlah,
                'harga' => $harga
            ]);

            $parfumModel->update($idParfum, [
                'stok' => ((int) $dataParfum['stok']) - $jumlah,
            ]);
        }

        $transaksiModel->update($id_transaksi, ['total' => $total]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }

        return $isAdmin
            ? redirect()->to('/transaksi')
            : redirect()->to('/riwayat-pembelian');
    }
}
