<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ParfumModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kategori extends BaseController
{
    protected KategoriModel $kategoriModel;
    protected ParfumModel $parfumModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->parfumModel   = new ParfumModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $kategori = $this->kategoriModel
            ->select('kategori.*, COUNT(parfum.id_parfum) AS jumlah_produk')
            ->join('parfum', 'parfum.id_kategori = kategori.id_kategori', 'left')
            ->groupBy('kategori.id_kategori')
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->findAll();

        return view('kategori/index', ['kategori' => $kategori]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $this->categoryData();

        if (! $this->validateCategory($data)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->categoryNameExists($data['nama_kategori'])) {
            return redirect()->back()->withInput()->with('errors', [
                'nama_kategori' => 'Nama kategori sudah digunakan.',
            ]);
        }

        $this->kategoriModel->insert($data);

        return redirect()->to('/kategori')->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $kategori = $this->kategoriModel->find($id);

        if (! $kategori) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        return view('kategori/edit', ['kategori' => $kategori]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if (! $this->kategoriModel->find($id)) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        $data = $this->categoryData();

        if (! $this->validateCategory($data)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->categoryNameExists($data['nama_kategori'], $id)) {
            return redirect()->back()->withInput()->with('errors', [
                'nama_kategori' => 'Nama kategori sudah digunakan.',
            ]);
        }

        $this->kategoriModel->update($id, $data);

        return redirect()->to('/kategori')->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if (! $this->kategoriModel->find($id)) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        if ($this->parfumModel->where('id_kategori', $id)->countAllResults() > 0) {
            return redirect()->to('/kategori')->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            );
        }

        $this->kategoriModel->delete($id);

        return redirect()->to('/kategori')->with('sukses', 'Kategori berhasil dihapus.');
    }

    private function categoryData(): array
    {
        return [
            'nama_kategori' => trim((string) $this->request->getPost('nama_kategori')),
            'deskripsi'     => trim((string) $this->request->getPost('deskripsi')),
        ];
    }

    private function validateCategory(array $data): bool
    {
        return $this->validateData($data, [
            'nama_kategori' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama kategori wajib diisi.',
                    'min_length' => 'Nama kategori minimal 3 karakter.',
                    'max_length' => 'Nama kategori maksimal 100 karakter.',
                ],
            ],
            'deskripsi' => 'permit_empty|max_length[1000]',
        ]);
    }

    private function categoryNameExists(string $name, ?int $exceptId = null): bool
    {
        $builder = $this->kategoriModel->where('nama_kategori', $name);

        if ($exceptId !== null) {
            $builder->where('id_kategori !=', $exceptId);
        }

        return $builder->countAllResults() > 0;
    }
}
