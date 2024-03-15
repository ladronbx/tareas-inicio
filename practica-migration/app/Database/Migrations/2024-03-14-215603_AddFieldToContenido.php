<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldToContenido extends Migration
{
    public function up()
    {
        $fields = [
            'nuevo_campo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ];

        $this->forge->addColumn('contenido', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('contenido', 'nuevo_campo');
    }
}
