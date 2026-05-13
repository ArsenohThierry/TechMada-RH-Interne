<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;

class RHController extends BaseController
{
    public function listeDemandes()
    {
        $congeModel = new CongeModel();
        $tous   = $congeModel->getAllAvecFiltres(); // charger toutes les données pour filtrage JS

        $data = [
            'conges'         => $tous,
            'departements'   => [],
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

        $typeCongeModel = new TypeCongeModel();
        $typeConge = $typeCongeModel->find($typeId);

        if ($typeConge && $typeConge['deductible']) {
            $soldeModel = new SoldeModel();
            $solde = $soldeModel->getSolde($employeId, $typeId);

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
}
