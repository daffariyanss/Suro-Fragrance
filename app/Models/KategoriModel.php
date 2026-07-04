<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    // ── Nama tabel di database ──────────────────────────────────
    protected $table      = 'kategori';

    // ── Primary Key tabel ───────────────────────────────────────
    protected $primaryKey = 'id_kategori';

    // ── Field yang boleh diisi (mass assignment) ─────────────────
    protected $allowedFields = [
        'nama_kategori',
        'deskripsi',
    ];

    // ── Tipe return data (array / object) ────────────────────────
    protected $returnType = 'array';

    // ── Timestamps otomatis ──────────────────────────────────────
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}