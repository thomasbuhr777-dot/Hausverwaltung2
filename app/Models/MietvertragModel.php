<?php

namespace App\Models;

use CodeIgniter\Model;

class MietvertragModel extends Model
{
    protected $table            = 'mietvertraege';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Mietverträge werden meist eher deaktiviert als gelöscht

    // Diese Felder dürfen über Formulare/Controller befüllt werden
    protected $allowedFields    = [
        'einheit_id', 
        'mieter_id', 
        'start_datum', 
        'end_datum', 
        'kaltmiete', 
        'nebenkosten', 
        'kaution', 
        'aktiv'
    ];

    // Automatische Zeitstempel (falls du diese in der Migration hinzugefügt hast)
    protected $useTimestamps = false; 

    // Validierungsregeln, um sicherzustellen, dass nur korrekte Daten in die DB kommen
    protected $validationRules = [
        'einheit_id'  => 'required|integer',
        'mieter_id'   => 'required|integer',
        'start_datum' => 'required|valid_date',
        'kaltmiete'   => 'required|decimal',
        'nebenkosten' => 'required|decimal',
        'kaution'     => 'permit_empty|decimal',
    ];

    protected $validationMessages = [
        'einheit_id' => [
            'required' => 'Bitte wählen Sie eine Einheit aus.',
        ],
        'mieter_id' => [
            'required' => 'Bitte wählen Sie einen Mieter aus.',
        ],
    ];

    /**
     * Hilfsmethode: Deaktiviert alle alten Verträge einer Einheit,
     * wenn ein neuer Vertrag aktiviert wird.
     */
    public function deactivateOldContracts(int $einheitId)
    {
        return $this->where('einheit_id', $einheitId)
                    ->set(['aktiv' => 0])
                    ->update();
    }
}