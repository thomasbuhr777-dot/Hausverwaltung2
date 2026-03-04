<?php

namespace App\Models;

use CodeIgniter\Model;

class KontaktModel extends Model
{
    protected $table            = 'kontakte';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Wichtig für die Historie

    protected $allowedFields = [
        'vorname', 
        'nachname', 
        'email', 
        'telefon', 
        'iban', 
        'ist_mieter', 
        'ist_eigentuemer'
    ];

    protected $useTimestamps = false; // Falls in Migration nicht definiert
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'vorname'  => 'required|min_length[2]',
        'nachname' => 'required|min_length[2]',
        'email'    => 'permit_empty|valid_email',
    ];

    /**
     * Holt nur Personen, die als Mieter markiert sind
     */
    public function getMieter()
    {
        return $this->where('ist_mieter', 1)->findAll();
    }
}