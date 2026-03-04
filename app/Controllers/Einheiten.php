<?php

namespace App\Controllers;

use App\Models\EinheitModel;
use App\Models\LiegenschaftModel;
use CodeIgniter\RESTful\ResourceController;

class Einheiten extends ResourceController
{
    protected $modelName = 'App\Models\EinheitModel';
    protected $format    = 'html';
/**
 * Detailansicht einer Einheit
 */
public function show($id = null)
{
    // Einheit mit Liegenschafts-Name laden (nutzt die Methode aus dem Model-Schritt zuvor)
    $einheit = $this->model->getWithLiegenschaft($id);

    if (!$einheit) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Aktuellen Mieter suchen
    $db = \Config\Database::connect();
    $mieter = $db->table('mietvertraege')
        ->select('kontakte.vorname, kontakte.nachname, mietvertraege.start_datum, mietvertraege.kaltmiete')
        ->join('kontakte', 'kontakte.id = mietvertraege.mieter_id')
        ->where('mietvertraege.einheit_id', $id)
        ->where('mietvertraege.aktiv', 1)
        ->get()
        ->getRowArray();

    // Zählerstände für diese Einheit holen
    $zaehler = $db->table('zaehler')
        ->where('einheit_id', $id)
        ->get()
        ->getResultArray();

    return view('einheiten/show', [
        'title'   => 'Einheit: ' . $einheit['top_nummer'],
        'einheit' => $einheit,
        'mieter'  => $mieter,
        'zaehler' => $zaehler
    ]);
}

    /**
     * Formular für eine neue Einheit
     */
    public function new()
    {
        $liegenschaftModel = new LiegenschaftModel();
        
        $data = [
            'title'           => 'Neue Einheit anlegen',
            'liegenschaften'  => $liegenschaftModel->findAll(),
            // Falls wir von einer Liegenschaft kommen, ID vorselektieren
            'selected_haus'   => $this->request->getGet('liegenschaft_id')
        ];

        return view('einheiten/form', $data);
    }



    /**
     * Speichern
     */
    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/liegenschaften/' . $data['liegenschaft_id'])
                         ->with('message', 'Einheit erfolgreich erstellt.');
    }

    /**
     * Bearbeiten
     */
    public function edit($id = null)
    {
        $einheit = $this->model->find($id);
        if (!$einheit) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $liegenschaftModel = new LiegenschaftModel();

        return view('einheiten/form', [
            'title'          => 'Einheit bearbeiten',
            'einheit'        => $einheit,
            'liegenschaften' => $liegenschaftModel->findAll()
        ]);
    }

    /**
     * Update
     */
    public function update($id = null)
    {
        $data = $this->request->getPost();

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/liegenschaften/' . $data['liegenschaft_id'])
                         ->with('message', 'Einheit aktualisiert.');
    }

    /**
     * Löschen
     */
    public function delete($id = null)
    {
        $einheit = $this->model->find($id);
        $this->model->delete($id);

        return redirect()->to('/liegenschaften/' . $einheit['liegenschaft_id'])
                         ->with('message', 'Einheit gelöscht.');
    }
}