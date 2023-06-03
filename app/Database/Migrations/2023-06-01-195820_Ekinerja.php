<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ekinerja extends Migration
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
            'id_users' => [
                'type' => 'BIGINT',
                'constraint' => 20
            ],
            'id_kegiatan' => [
                'type' => 'BIGINT',
                'constraint' => 20
            ],
            'output' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'waktu_mulai' => [
                'type' => 'DATE',
            ],
            'waktu_selesai' => [
                'type' => 'DATE',
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime default null'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ekinerja');
    }

    public function down()
    {
        $this->forge->dropTable('ekinerja');
    }
}
