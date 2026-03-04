<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use App\Services\SollstellungService;

class MietSollstellung extends BaseCommand
{
    protected $group       = 'Hausverwaltung';
    protected $name        = 'miete:sollstellung';
    protected $description = 'Generiert die monatliche Sollstellung für alle aktiven Mietverträge.';

    public function run(array $params)
    {
        $service = new SollstellungService();
        $monat   = date('m');
        $jahr    = date('Y');

        $anzahl = $service->generiereMonatsSoll($monat, $jahr);

        $this->write("Erfolgreich $anzahl Sollstellungen für $monat/$jahr generiert.", 'green');
    }
}