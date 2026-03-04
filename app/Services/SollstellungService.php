<?php

namespace App\Services;

use App\Models\MietvertragModel;
use Config\Database;

class SollstellungService
{
    public function generiereMonatsSoll($monat, $jahr)
    {
        $db = Database::connect();
        $mietvertragModel = new MietvertragModel();

        // 1. Alle aktiven Mietverträge holen
        $vertraege = $mietvertragModel->where('aktiv', 1)->findAll();
        
        $erstellt = 0;
        $datum = "$jahr-$monat-01"; // Fälligkeitstag

        foreach ($vertraege as $v) {
            // Prüfen, ob für diesen Vertrag/Monat/Jahr bereits eine Sollstellung existiert
            // (Um Dubletten bei mehrfachem Aufruf zu vermeiden)
            $existiert = $db->table('transaktionen')
                ->where('mietvertrag_id', $v['id'])
                ->where('typ', 'Miete')
                ->where('MONTH(datum)', $monat)
                ->where('YEAR(datum)', $jahr)
                ->countAllResults();

            if ($existiert == 0) {
                // Transaktion für Kaltmiete + Nebenkosten anlegen
                $db->table('transaktionen')->insert([
                    'mietvertrag_id' => $v['id'],
                    'datum'          => $datum,
                    'betrag'         => $v['kaltmiete'] + $v['nebenkosten'],
                    'typ'            => 'Miete',
                    'status'         => 'offen',
                    'beschreibung'   => "Sollstellung Miete $monat/$jahr"
                ]);
                $erstellt++;
            }
        }

        return $erstellt;
    }
}