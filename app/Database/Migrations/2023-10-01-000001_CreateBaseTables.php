<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaseTables extends Migration
{
    public function up()
    {
        // LIEGENSCHAFTEN
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'strasse'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'plz'         => ['type' => 'VARCHAR', 'constraint' => 10],
            'ort'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'baujahr'     => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('liegenschaften');

        // EINHEITEN
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'liegenschaft_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'top_nummer'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'flaeche_qm'      => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'einheit_typ'     => ['type' => 'ENUM', 'constraint' => ['Wohnung', 'Gewerbe', 'Garage', 'Keller']],
            'etage'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('liegenschaft_id', 'liegenschaften', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('einheiten');
    }

    public function down()
    {
        $this->forge->dropTable('einheiten');
        $this->forge->dropTable('liegenschaften');
    }
}