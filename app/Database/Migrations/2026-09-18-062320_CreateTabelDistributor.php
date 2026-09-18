<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDistributorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_distributor' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nama_distributor' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'alamat_distributor' => [
                'type' => 'TEXT',
            ],

            'latitude' => [
                'type' => 'DOUBLE PRECISION',
            ],

            'longitude' => [
                'type' => 'DOUBLE PRECISION',
            ],
        ]);

        $this->forge->addKey('id_distributor', true);

        $this->forge->createTable('distributor');
    }

    public function down()
    {
        $this->forge->dropTable('distributor');
    }
}