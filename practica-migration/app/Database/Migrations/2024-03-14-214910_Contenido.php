<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contenido extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'meta_description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'html' => [
                'type' => 'TEXT',
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contenido');
    }

    public function down()
    {
        $this->forge->dropTable('contenido');
    }
}
