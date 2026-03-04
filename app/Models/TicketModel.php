<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table      = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'einheit_id', 'dienstleister_id', 'titel', 'beschreibung', 
        'status', 'prioritaet', 'gemeldet_am', 'abgeschlossen_am', 
        'kosten_geschaetzt', 'kosten_ist'
    ];

    protected $useTimestamps = true;

    /**
     * Holt alle offenen Notfall-Tickets
     */
    public function getUrgentTickets()
    {
        return $this->where('prioritaet', 'notfall')
                    ->whereNotIn('status', ['erledigt', 'storniert'])
                    ->findAll();
    }

    /**
     * Verknüpft Ticket mit Einheit und Mieter für die Übersicht
     */
    public function getFullTicketDetails($id)
    {
        return $this->select('tickets.*, einheiten.top_nummer, liegenschaften.name as haus, kontakte.nachname as mieter')
                    ->join('einheiten', 'einheiten.id = tickets.einheit_id')
                    ->join('liegenschaften', 'liegenschaften.id = einheiten.liegenschaft_id')
                    ->join('mietvertraege', 'mietvertraege.einheit_id = einheiten.id', 'left')
                    ->join('kontakte', 'kontakte.id = mietvertraege.mieter_id', 'left')
                    ->where('tickets.id', $id)
                    ->first();
    }
}