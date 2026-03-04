<?php

namespace App\Controllers;

use App\Models\LiegenschaftModel;
use App\Models\EinheitModel;
use App\Models\MietvertragModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Statistiken berechnen
        $data = [
            'title'             => 'Verwaltungs-Dashboard',
            'anzahl_objekte'    => (new LiegenschaftModel())->countAll(),
            'anzahl_einheiten'  => (new EinheitModel())->countAll(),
            
            // Leerstand berechnen (Einheiten ohne aktiven Mietvertrag)
            'leerstand'         => $db->table('einheiten')
                                     ->join('mietvertraege', 'mietvertraege.einheit_id = einheiten.id AND mietvertraege.aktiv = 1', 'left')
                                     ->where('mietvertraege.id', null)
                                     ->where('einheiten.deleted_at', null)
                                     ->countAllResults(),

            // Offene Mieten diesen Monat (Status 'offen')
            'offene_posten'     => $db->table('transaktionen')
                                     ->selectSum('betrag')
                                     ->where('status', 'offen')
                                     ->get()->getRow()->betrag ?? 0,

            // Die 5 neuesten Tickets (Instandhaltung)
            'neueste_tickets'   => $db->table('tickets')
                                     ->select('tickets.*, einheiten.top_nummer')
                                     ->join('einheiten', 'einheiten.id = tickets.einheit_id')
                                     ->orderBy('tickets.created_at', 'DESC')
                                     ->limit(5)
                                     ->get()->getResultArray(),
        ];

        return view('dashboard/index', $data);
    }

    public function runSollstellung()
    {
    $service = new \App\Services\SollstellungService();
    $anzahl = $service->generiereMonatsSoll(date('m'), date('Y'));

    return redirect()->to('/')->with('message', "$anzahl Sollstellungen generiert.");
    }
}