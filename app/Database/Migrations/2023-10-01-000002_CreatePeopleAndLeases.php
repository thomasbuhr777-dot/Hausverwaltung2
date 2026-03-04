<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeopleAndLeases extends Migration
{
    public function up()
    {
        // KONTAKTE
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vorname'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'nachname'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'telefon'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'iban'       => ['type' => 'VARCHAR', 'constraint' => 34, 'null' => true],
            'ist_mieter'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'ist_eigentuemer' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontakte');

        // MIETVERTRÄGE
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'einheit_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'mieter_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'start_datum'    => ['type' => 'DATE'],
            'end_datum'      => ['type' => 'DATE', 'null' => true],
            'kaltmiete'      => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'nebenkosten'    => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'kaution'        => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'aktiv'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('einheit_id', 'einheiten', 'id');
        $this->forge->addForeignKey('mieter_id', 'kontakte', 'id');
        $this->forge->createTable('mietvertraege');
    }

    public function down()
    {
        $this->forge->dropTable('mietvertraege');
        $this->forge->dropTable('kontakte');
    }
}