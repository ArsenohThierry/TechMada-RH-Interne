<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CongeModel;

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

    public function approuverDemande(){
        
    }
}
