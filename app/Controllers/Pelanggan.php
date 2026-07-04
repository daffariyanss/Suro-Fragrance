<?php

namespace App\Controllers;

use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    protected $pelanggan;

    public function __construct()
    {
        $this->pelanggan = new PelangganModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data['pelanggan'] = $this->pelanggan->findAll();
        return view('pelanggan/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('pelanggan/create');
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->pelanggan->save([
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pelanggan');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $model = new PelangganModel();

        $data['pelanggan'] = $model->find($id);

        return view('pelanggan/edit', $data);
    }

    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $model = new PelangganModel();

        $model->update($id, [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pelanggan');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->pelanggan->delete($id);
        return redirect()->to('/pelanggan');
    }
}
