<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaktionModel extends Model
{
    protected $table            = 'transaktionen';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['mietvertrag_id', 'datum', 'betrag', 'typ', 'status', 'beschreibung'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Holt Transaktionen inklusive Mieter- und Einheitsnamen
     */
    public function getDetailliert($status = null)
    {
        $builder = $this->select('transaktionen.*, kontakte.vorname, kontakte.nachname, einheiten.top_nummer, liegenschaften.name as haus_name')
            ->join('mietvertraege', 'mietvertraege.id = transaktionen.mietvertrag_id')
            ->join('kontakte', 'kontakte.id = mietvertraege.mieter_id')
            ->join('einheiten', 'einheiten.id = mietvertraege.einheit_id')
            ->join('liegenschaften', 'liegenschaften.id = einheiten.liegenschaft_id');

        if ($status) {
            $builder->where('transaktionen.status', $status);
        }

        return $builder->orderBy('transaktionen.datum', 'DESC')->findAll();
    }
}