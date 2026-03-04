<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinanceAndMeters extends Migration
{
    public function up()
    {
        // TRANSAKTIONEN
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mietvertrag_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'datum'           => ['type' => 'DATE'],
            'betrag'          => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'typ'             => ['type' => 'ENUM', 'constraint' => ['Miete', 'Nebenkosten', 'Instandhaltung', 'Kaution', 'Sonstiges']],
            'status'          => ['type' => 'ENUM', 'constraint' => ['offen', 'bezahlt', 'storniert'], 'default' => 'offen'],
            'beschreibung'    => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mietvertrag_id', 'mietvertraege', 'id');
        $this->forge->createTable('transaktionen');

        // ZÄHLER
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'einheit_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'typ'         => ['type' => 'ENUM', 'constraint' => ['Wasser_Kalt', 'Wasser_Warm', 'Strom', 'Heizung', 'Gas']],
            'zaehler_nr'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'letzter_wert'=> ['type' => 'DECIMAL', 'constraint' => '12,4'],
            'ablesedatum' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('einheit_id', 'einheiten', 'id');
        $this->forge->createTable('zaehler');
    }

    public function down()
    {
        $this->forge->dropTable('zaehler');
        $this->forge->dropTable('transaktionen');
    }
}