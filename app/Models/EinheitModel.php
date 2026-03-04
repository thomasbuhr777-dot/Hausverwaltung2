<?php

namespace App\Models;

use CodeIgniter\Model;

class EinheitModel extends Model
{
    protected $table      = 'einheiten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['liegenschaft_id', 'top_nummer', 'flaeche_qm', 'einheit_typ', 'etage'];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    /**
     * Holt die Einheit inklusive der Daten der Liegenschaft (JOIN)
     */
    public function getWithLiegenschaft($id = null)
    {
        $builder = $this->builder();
        $builder->select('einheiten.*, liegenschaften.name as liegenschaft_name');
        $builder->join('liegenschaften', 'liegenschaften.id = einheiten.liegenschaft_id');
        
        if ($id) {
            return $builder->where('einheiten.id', $id)->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}