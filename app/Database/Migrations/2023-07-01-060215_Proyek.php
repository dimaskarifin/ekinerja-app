<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Proyek extends Migration
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
            'no_proyek' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'nama_proyek' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'pelaksana_id' => [
                'type' => 'BIGINT',
                'constraint' => 20
            ],
            'mandor_id' => [
                'type' => 'BIGINT',
                'constraint' => 20
            ],
            'tukang_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'null' => true,
                'default' => '0',
            ],
            'kegiatan_id' => [
                'type' => 'BIGINT',
                'constraint' => 20
            ],
            'target' => [
                'type' => 'BIGINT',
                'constraint' => 20,
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'output' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => '-'
            ],
            'tanggal_pelaksanaan' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai_pelaksanaan' => [
                'type' => 'DATE',
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime default null'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('proyek');
    }

    public function down()
    {
        return $this->forge->dropTable('proyek');
    }
}
