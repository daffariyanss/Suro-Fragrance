<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParfumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_parfum' => 'Santal 33',
                'brand'       => 'Le Labo',
                'harga'       => 5000000,
                'stok'        => 5,
                'deskripsi'   => 'Aroma kayu cendana, kulit, dan rempah maskulin.',
                'gambar'      => 'https://images.unsplash.com/photo-1600180758890-6c8c96c5b0b0',
                'id_kategori' => 1,
            ],
            [
                'nama_parfum' => 'Au Hasard',
                'brand'       => 'Louis Vuitton',
                'harga'       => 6200000,
                'stok'        => 1,
                'deskripsi'   => 'Aroma kayu cendana, kulit, dan pir yang mewah.',
                'gambar'      => 'https://images.unsplash.com/photo-1615634262419-d9a71b2f1e52',
                'id_kategori' => 1,
            ],
            [
                'nama_parfum' => 'Baies',
                'brand'       => 'Diptyque',
                'harga'       => 1200000,
                'stok'        => 2,
                'deskripsi'   => 'Aroma beri hitam dan mawar.',
                'gambar'      => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad',
                'id_kategori' => 4,
            ],
            [
                'nama_parfum' => 'Libre',
                'brand'       => 'YSL',
                'harga'       => 2900000,
                'stok'        => 2,
                'deskripsi'   => 'Aroma bunga dengan sentuhan vanilla.',
                'gambar'      => 'https://images.unsplash.com/photo-1615634262419-d9a71b2f1e52',
                'id_kategori' => 1,
            ],
        ];

        // Use Query Builder to insert records
        $this->db->table('parfum')->insertBatch($data);
    }
}
