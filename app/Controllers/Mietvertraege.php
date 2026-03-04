<?php

namespace App\Controllers;

use App\Models\MietvertragModel;
use App\Models\EinheitModel;
use App\Models\KontaktModel;
use CodeIgniter\RESTful\ResourceController;

class Mietvertraege extends ResourceController
{
    protected $modelName = 'App\Models\MietvertragModel';
    protected $format    = 'html';

    public function new()
    {
        $einheitModel = new EinheitModel();
        $kontaktModel = new KontaktModel();

        $data = [
            'title'        => 'Neuer Mietvertrag',
            'einheiten'    => $einheitModel->getWithLiegenschaft(), // Alle Einheiten mit Hausnamen
            'mieter'       => $kontaktModel->where('ist_mieter', 1)->findAll(),
            'selected_unit'=> $this->request->getGet('einheit_id') // Vorselektion aus der URL
        ];

        return view('mietvertraege/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        
        // Wichtig: Falls ein neuer Vertrag für eine Einheit erstellt wird, 
        // sollten alte Verträge für diese Einheit auf "aktiv = 0" gesetzt werden.
        if ($this->model->insert($data)) {
            return redirect()->to('/einheiten/' . $data['einheit_id'])
                             ->with('message', 'Mietvertrag erfolgreich erstellt.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }
}