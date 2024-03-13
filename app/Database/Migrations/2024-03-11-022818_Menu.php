<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_menu' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
                'null'           => false

            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => true
            ],
            'priority' => [
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
        $this->forge->addKey('id_menu', true);
        $this->forge->createTable('menu');
    }

    public function down()
    {
        //
    }
}
