<?php


namespace App\Models;

use CodeIgniter\Model;

class ParfumModel extends Model
{
    // ── Nama tabel di database ──────────────────────────────────
    protected $table = 'parfum';

    // ── Primary Key tabel ───────────────────────────────────────
    protected $primaryKey = 'id_parfum';

    // ── Field yang boleh diisi (mass assignment) ─────────────────
    protected $allowedFields = [
        'nama_parfum',
        'brand',
        'gambar',
        'harga',
        'stok',
        'deskripsi',
        'id_kategori',
    ];

    // ── Tipe return data (array / object) ────────────────────────
    protected $returnType = 'array';

    // ── Timestamps otomatis ──────────────────────────────────────
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ── Validasi bawaan Model ────────────────────────────────────
    protected $validationRules = [
        'nama_parfum' => 'required|min_length[3]|max_length[150]',
        'brand' => 'required|min_length[2]|max_length[100]',
        'harga' => 'required|numeric|greater_than[0]',
        'stok' => 'required|integer|greater_than_equal_to[0]',
        'id_kategori' => 'required|integer',
        'gambar' => 'permit_empty|valid_url',
    ];

    protected $validationMessages = [
        'nama_parfum' => [
            'required' => 'Nama parfum wajib diisi.',
            'min_length' => 'Nama parfum minimal 3 karakter.',
        ],
        'harga' => [
            'required' => 'Harga wajib diisi.',
            'numeric' => 'Harga harus berupa angka.',
            'greater_than' => 'Harga harus lebih dari 0.',
        ],
        'id_kategori' => [
            'required' => 'Kategori wajib dipilih.',
        ],
        'gambar' => [
            'valid_url' => 'Format URL gambar tidak valid.',
        ],
    ];
}