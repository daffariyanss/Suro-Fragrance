<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CleanupParfumImageUrls extends Migration
{
    public function up()
    {
        // Update gambar yang menggunakan placeholder eksternal ke NULL
        // Ini akan membuat placeholder SVG lokal dipakai
        $this->db->query("UPDATE parfum SET gambar = NULL WHERE gambar LIKE '%via.placeholder%' OR gambar LIKE '%unsplash%'");
    }

    public function down()
    {
        // Tidak ada rollback, data sudah dibersihkan
    }
}
