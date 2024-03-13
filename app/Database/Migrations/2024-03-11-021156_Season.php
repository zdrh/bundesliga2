<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Season extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_season' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
                'null'           => false

            ],
            'start' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'finish' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'start' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'created_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'updated_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'deleted_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true
            ]
           
        ]);
        $this->forge->addKey('id_season', true);
        $this->forge->createTable('season');
    }

    public function down()
    {
        //
    }
}
