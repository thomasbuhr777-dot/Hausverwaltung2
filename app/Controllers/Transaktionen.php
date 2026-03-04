<?php

namespace App\Controllers;

use App\Models\TransaktionModel;

class Transaktionen extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new TransaktionModel();
    }

    public function index()
    {
        $statusFilter = $this->request->getGet('status') ?: 'offen';
        
        $data = [
            'title'         => 'Zahlungseingänge / Offene Posten',
            'transaktionen' => $this->model->getDetailliert($statusFilter),
            'currentStatus' => $statusFilter
        ];

        return view('transaktionen/index', $data);
    }

    public function markAsPaid($id)
    {
        $this->model->update($id, ['status' => 'bezahlt']);
        return redirect()->back()->with('message', 'Zahlung wurde erfolgreich verbucht.');
    }
}