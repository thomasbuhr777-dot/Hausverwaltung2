<?php

namespace App\Models;

use CodeIgniter\Model;

class LiegenschaftModel extends Model
{
    protected $table      = 'liegenschaften';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Oder 'object' / Entity
    protected $useSoftDeletes   = true;

    protected $allowedFields = ['name', 'strasse', 'plz', 'ort', 'baujahr'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validierung
    protected $validationRules = [
        'name'    => 'required|min_length[3]|max_length[255]',
        'plz'     => 'required|max_length[10]',
        'ort'     => 'required|max_length[100]',
        'baujahr' => 'permit_empty|integer|exact_length[4]',
    ];

    /**
     * Hilfsmethode: Holt alle Einheiten dieser Liegenschaft
     */
    public function getEinheiten($id)
    {
        return $this->db->table('einheiten')
                        ->where('liegenschaft_id', $id)
                        ->get()
                        ->getResultArray();
    }
}