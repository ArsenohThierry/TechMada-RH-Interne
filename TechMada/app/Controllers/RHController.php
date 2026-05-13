<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;
use App\Models\DepartementsModel;

class RHController extends BaseController
{
    public function listeDemandes()
    {
        $congeModel = new CongeModel();
        $tous   = $congeModel->getAllAvecFiltres(); // charger toutes les données pour filtrage JS
        // Récupérer la liste des départements pour le filtre
        $departementModel = new DepartementsModel();
        $departements = $departementModel->findAllDepartements();

        $data = [
            'conges'         => $tous,
            'departements'   => $departements,
            'filtre_statut'  => '',
            'filtre_dept'    => '',
            'nb_en_attente'  => count(array_filter($tous, fn($c) => $c['statut'] === 'en_attente')),
            'nb_approuvees'  => count(array_filter($tous, fn($c) => $c['statut'] === 'approuvee')),
            'nb_refusees'    => count(array_filter($tous, fn($c) => $c['statut'] === 'refusee')),
            'nb_total'       => count($tous),
        ];

        return view('listeDemande', $data);
    }

    public function approuverDemande($id_demande)
    {
        $congeModel = new CongeModel();
        $conge = $congeModel->find($id_demande);

        if (! $conge) {
            return redirect()->to('/rh/listeDemandes')->with('error', 'Demande introuvable.');
        }

        if ($conge['statut'] !== 'en_attente') {
            return redirect()->to('/rh/listeDemandes')->with('error', 'La demande n\'est pas en attente.');
        }

        $typeId = (int) $conge['type_conge_id'];
        $employeId = (int) $conge['employe_id'];
        $nbJours = (int) $conge['nb_jours'];
        $anneeDemande = (int) date('Y', strtotime($conge['date_debut']));

        $typeCongeModel = new TypeCongeModel();
        $typeConge = $typeCongeModel->find($typeId);

        if ($typeConge && $typeConge['deductible']) {
            $soldeModel = new SoldeModel();
            $solde = $soldeModel->getSolde($employeId, $typeId, $anneeDemande);

            if (! $solde) {
                return redirect()->to('/rh/listeDemandes')->with('error', 'Solde introuvable pour cet employé et type de congé.');
            }

            if ((int) $solde['jours_pris'] + $nbJours > (int) $solde['jours_attribues']) {
                return redirect()->to('/rh/listeDemandes')->with('error', 'Impossible d\'approuver : le solde serait négatif.');
            }

            // Update via model
            $soldeModel->incrementJoursPris((int) $solde['id'], $nbJours);
        }

        $traitePar = session()->get('employe_id') ? (int) session()->get('employe_id') : null;
        $congeModel->approveConge((int) $id_demande, $traitePar);

        return redirect()->to('/rh/listeDemandes')->with('success', 'Demande approuvée.');
    }

    /**
     * Refuser une demande de congé
     */
    public function refuserDemande($id_demande)
    {
        $congeModel = new CongeModel();
        $conge = $congeModel->find($id_demande);

        if (! $conge) {
            return redirect()->to('/rh/listeDemandes')->with('error', 'Demande introuvable.');
        }

        if ($conge['statut'] !== 'en_attente') {
            return redirect()->to('/rh/listeDemandes')->with('error', 'La demande n\'est pas en attente.');
        }

        $rules = ['commentaire_rh' => 'permit_empty|string|max_length[500]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $commentaireRh = $this->request->getPost('commentaire_rh') ?: null;
        $traitePar = session()->get('employe_id') ? (int) session()->get('employe_id') : null;

        $updateData = [
            'statut' => 'refusee',
            'commentaire_rh' => $commentaireRh,
            'traite_par' => $traitePar,
        ];

        $congeModel->update((int) $id_demande, $updateData);

        return redirect()->to('/rh/listeDemandes')->with('success', 'Demande refusée.');
    }

    /**
     * Annuler une demande approuvée (remboursement du solde)
     */
    public function annulerDemande($id_demande)
    {
        $congeModel = new CongeModel();
        $conge = $congeModel->find($id_demande);

        if (! $conge) {
            return redirect()->to('/rh/listeDemandes')->with('error', 'Demande introuvable.');
        }

        if ($conge['statut'] !== 'approuvee') {
            return redirect()->to('/rh/listeDemandes')->with('error', 'Seules les demandes approuvées peuvent être annulées.');
        }

        $typeId = (int) $conge['type_conge_id'];
        $employeId = (int) $conge['employe_id'];
        $nbJours = (int) $conge['nb_jours'];
        $anneeDemande = (int) date('Y', strtotime($conge['date_debut']));

        $typeCongeModel = new TypeCongeModel();
        $typeConge = $typeCongeModel->find($typeId);

        // If deductible, decrement jours_pris to refund days
        if ($typeConge && $typeConge['deductible']) {
            $soldeModel = new SoldeModel();
            $solde = $soldeModel->getSolde($employeId, $typeId, $anneeDemande);

            if ($solde) {
                // Decrement jours_pris
                $db = \Config\Database::connect();
                $builder = $db->table('soldes');
                $builder->set('jours_pris', "MAX(0, jours_pris - {$nbJours})", false)
                        ->where('id', (int) $solde['id'])
                        ->update();
            }
        }

        $traitePar = session()->get('employe_id') ? (int) session()->get('employe_id') : null;
        $updateData = [
            'statut' => 'annulee',
            'traite_par' => $traitePar,
        ];

        $congeModel->update((int) $id_demande, $updateData);

        return redirect()->to('/rh/listeDemandes')->with('success', 'Demande annulée et solde remboursé.');
    }
}
