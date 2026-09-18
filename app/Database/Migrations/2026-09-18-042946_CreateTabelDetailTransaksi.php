<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'id_obat' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'jumlah' => [
                'type' => 'INT',
            ],
            'harga' => [
                'type' => 'NUMERIC',
            ],
            'subtotal' => [
                'type' => 'NUMERIC',
            ],
        ]);

        $this->forge->addKey('id_detail', true);

        $this->forge->addForeignKey(
            'id_transaksi',
            'transaksi',
            'id_transaksi',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_obat',
            'obat',
            'id_obat',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi');
    }
}