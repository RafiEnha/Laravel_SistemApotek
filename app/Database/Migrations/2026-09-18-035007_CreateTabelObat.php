<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_obat' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_obat' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
            ],
            'nama_obat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'satuan_obat' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
            ],
            'harga_obat' => [
                'type' => 'DOUBLE PRECISION',
            ],
            'stock_obat' => [
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_obat', true);

        $this->forge->createTable('obat');
    }

    public function down()
    {
        $this->forge->dropTable('obat');
    }
}