<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateParfumTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_parfum'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_parfum' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'brand'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'harga'       => [
                'type'       => 'INT',
            ],
            'stok'        => [
                'type'       => 'INT',
            ],
            'deskripsi'   => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar'      => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_kategori' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'created_at'  => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at'  => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_parfum', true);
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->createTable('parfum');
    }

    public function down()
    {
        $this->forge->dropTable('parfum', true);
    }
}