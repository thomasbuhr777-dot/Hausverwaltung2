<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaintenanceAndServiceProviders extends Migration
{
    public function up()
    {
        // DIENSTLEISTER (Handwerker, Versicherungen, etc.)
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'firma'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'gewerk'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true], // z.B. Sanitär, Elektrik
            'ansprechpartner'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'telefon'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'notfall_nummer'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'strasse'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'plz'               => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'ort'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'bemerkung'         => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dienstleister');

        // TICKETS / SCHADENSMELDUNGEN
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'einheit_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'dienstleister_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'titel'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'beschreibung'      => ['type' => 'TEXT'],
            'status'            => [
                'type'       => 'ENUM', 
                'constraint' => ['neu', 'in_arbeit', 'wartet_auf_ersatzteil', 'erledigt', 'storniert'],
                'default'    => 'neu'
            ],
            'prioritaet'        => [
                'type'       => 'ENUM', 
                'constraint' => ['niedrig', 'normal', 'hoch', 'notfall'],
                'default'    => 'normal'
            ],
            'gemeldet_am'       => ['type' => 'DATETIME'],
            'abgeschlossen_am'  => ['type' => 'DATETIME', 'null' => true],
            'kosten_geschaetzt' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'kosten_ist'        => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('einheit_id', 'einheiten', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dienstleister_id', 'dienstleister', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tickets');

        // KOMMUNIKATIONSLOG (Notizen zu Tickets oder allg. Mieterkommunikation)
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ticket_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'kontakt_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'betreff'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'nachricht'     => ['type' => 'TEXT'],
            'kanal'         => ['type' => 'ENUM', 'constraint' => ['Email', 'Telefon', 'Brief', 'Persoenlich'], 'default' => 'Email'],
            'richtung'      => ['type' => 'ENUM', 'constraint' => ['Eingang', 'Ausgang']],
            'datum'         => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kontakt_id', 'kontakte', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kommunikation');
    }

    public function down()
    {
        $this->forge->dropTable('kommunikation');
        $this->forge->dropTable('tickets');
        $this->forge->dropTable('dienstleister');
    }
}