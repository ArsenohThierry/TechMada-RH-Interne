<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CongeModel;
use App\Models\TypeCongeModel;

class CongeController extends BaseController
{


    public function congeForm()
    {
        $typesCongeModel = new TypeCongeModel();
        $types_conge = $typesCongeModel->getAllTypesConge();
        $data = [
            'types_conge' => $types_conge,
            'error' => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
            'soldes' => [] // TODO: calculer les soldes restants pour l'employé connecté
        ]; 
        return view('demandeConge', $data);
    }

    public function getConges()
    {
        
    }

    public function envoyerConges(){
        $rules = [
            'type_conge' => 'required|is_natural_no_zero',
            'date_debut' => 'required|valid_date[Y-m-d]',
            'date_fin'   => 'required|valid_date[Y-m-d]',
            'commentaire' => 'permit_empty|string',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/conge/form')->with('error', implode(' ', $this->validator->getErrors()));
        }

        $employeId = (int) (session()->get('employe_id') ?? 0);
        if ($employeId <= 0) {
            return redirect()->to('/conge/form')->with('error', 'Vous devez être connecté pour soumettre une demande de congé.');
        }

        $dateDebut = new \DateTimeImmutable($this->request->getPost('date_debut'));
        $dateFin = new \DateTimeImmutable($this->request->getPost('date_fin'));

        if ($dateFin < $dateDebut) {
            return redirect()->to('/conge/form')->with('error', 'La date de fin doit être postérieure ou égale à la date de début.');
        }

        $nbJours = $dateDebut->diff($dateFin)->days + 1;

        $congeModel = new CongeModel();
        $insertId = $congeModel->insertConge([
            'employe_id'    => $employeId,
            'type_conge_id' => (int) $this->request->getPost('type_conge'),
            'date_debut'    => $dateDebut->format('Y-m-d'),
            'date_fin'      => $dateFin->format('Y-m-d'),
            'nb_jours'      => $nbJours,
            'motif'         => trim((string) $this->request->getPost('commentaire')) ?: null,
        ]);

        if ($insertId === false) {
            return redirect()->to('/conge/form')->with('error', 'La demande de congé n’a pas pu être enregistrée.');
        }

        return redirect()->to('/conge/form')->with('success', 'Votre demande de congé a été soumise avec succès.');
    }
}
