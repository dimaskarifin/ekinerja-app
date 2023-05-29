<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'nik' => [
                'type' => 'CHAR',
                'constraint' => 20
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'pengawas_id' => [
                'type' => 'BIGINT',
                'constraint' => 10
            ],
            'jabatan_id' => [
                'type' => 'BIGINT',
                'constraint' => 10
            ],
            'bidang_id' => [
                'type' => 'BIGINT',
                'constraint' => 10
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime default null'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
