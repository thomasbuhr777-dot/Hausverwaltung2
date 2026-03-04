<?php

namespace App\Controllers;

use App\Models\LiegenschaftModel;
use CodeIgniter\RESTful\ResourceController;

class Liegenschaften extends ResourceController
{
    protected $modelName = 'App\Models\LiegenschaftModel';
    protected $format    = 'html';

    /**
     * Liste aller Liegenschaften
     */
public function index()
{
    $search = $this->request->getGet('search');
    $ort    = $this->request->getGet('ort');

    $builder = $this->model;

    if ($search) {
        $builder->groupStart()
                ->like('name', $search)
                ->orLike('strasse', $search)
                ->groupEnd();
    }

    if ($ort) {
        $builder->where('ort', $ort);
    }

    $data = [
        'title'          => 'Liegenschaften Übersicht',
        // Wir nutzen Pagination, falls die Liste lang wird
        'liegenschaften' => $builder->paginate(10, 'group1'),
        'pager'          => $this->model->pager,
        'search'         => $search,
        'selected_ort'   => $ort,
        // Alle Orte für den Filter-Dropdown holen
        'orte'           => $this->model->select('ort')->distinct()->findAll()
    ];

    return view('liegenschaften/index', $data);
}

    /**
     * Formular für eine neue Liegenschaft
     */
    public function new()
    {
        return view('liegenschaften/form', ['title' => 'Neue Liegenschaft anlegen']);
    }

    /**
     * Speichern der neuen Liegenschaft
     */
    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/liegenschaften')->with('message', 'Liegenschaft erfolgreich erstellt.');
    }

    /**
     * Formular zum Bearbeiten
     */
    public function edit($id = null)
    {
        $liegenschaft = $this->model->find($id);

        if (!$liegenschaft) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('liegenschaften/form', [
            'title' => 'Liegenschaft bearbeiten',
            'liegenschaft' => $liegenschaft
        ]);
    }

    /**
     * Update in der Datenbank
     */
    public function update($id = null)
    {
        $data = $this->request->getPost();

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/liegenschaften')->with('message', 'Änderungen gespeichert.');
    }

    public function show($id = null)
{
    // 1. Basis-Daten der Liegenschaft holen
    $liegenschaft = $this->model->find($id);

    if (!$liegenschaft) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // 2. Alle Einheiten dieser Liegenschaft inklusive aktuellem Mieter laden
    // Wir nutzen hier den Query Builder für einen sauberen Join
    $db = \Config\Database::connect();
    $einheiten = $db->table('einheiten')
        ->select('einheiten.*, kontakte.vorname, kontakte.nachname, mietvertraege.id as vertrag_id')
        ->join('mietvertraege', 'mietvertraege.einheit_id = einheiten.id AND mietvertraege.aktiv = 1', 'left')
        ->join('kontakte', 'kontakte.id = mietvertraege.mieter_id', 'left')
        ->where('einheiten.liegenschaft_id', $id)
        ->where('einheiten.deleted_at', null)
        ->get()
        ->getResultArray();

    $data = [
        'title'        => 'Objektdetails: ' . $liegenschaft['name'],
        'liegenschaft' => $liegenschaft,
        'einheiten'    => $einheiten
    ];

    return view('liegenschaften/show', $data);
}

    /**
     * Löschen (Soft Delete)
     */
    public function delete($id = null)
    {   // Die and Dump
        //dd($id);

        $this->model->delete($id);
        return redirect()->to('/liegenschaften')->with('message', 'Liegenschaft gelöscht.');
    }
}