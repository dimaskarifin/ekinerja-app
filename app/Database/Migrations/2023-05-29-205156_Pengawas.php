<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengawas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_pengawas' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime default null'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengawas');
    }

    public function down()
    {
        $this->forge->dropTable('pengawas');
    }
}
