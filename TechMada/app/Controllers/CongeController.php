<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CongeModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;

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
        $id_employe = 1; // TODO: À récupérer de la session de l'utilisateur connecté
        $id_type_conge = (int) $this->request->getPost('type_conge');
        $date_debut = $this->request->getPost('date_debut');
        $date_fin = $this->request->getPost('date_fin');
        $commentaire = $this->request->getPost('commentaire');

        // Validation des dates
        if (strtotime($date_fin) < strtotime($date_debut)) {
            return redirect()->to('/conge/form')
                           ->with('error', 'La date de fin doit être postérieure ou égale à la date de début.');
        }

        // Récupérer le type de congé
        $typeCongeModel = new TypeCongeModel();
        $typeConge = $typeCongeModel->find($id_type_conge);
        
        if (!$typeConge) {
            return redirect()->to('/conge/form')
                           ->with('error', 'Le type de congé sélectionné n\'existe pas.');
        }

        // Calculer le nombre de jours
        $nb_jours = (strtotime($date_fin) - strtotime($date_debut)) / (60 * 60 * 24) + 1;

        // Vérifier si le type est déductible
        if ($typeConge['deductible']) {
            $soldeModel = new SoldeModel();
            $joursRestants = $soldeModel->getJoursRestants($id_employe, $id_type_conge);

            if ($joursRestants <= 0) {
                return redirect()->to('/conge/form')
                               ->with('error', 'Vous n\'avez pas de solde disponible pour ce type de congé.');
            }

            if ($nb_jours > $joursRestants) {
                return redirect()->to('/conge/form')
                               ->with('error', "Vous n'avez que {$joursRestants} jour(s) restant(s) pour ce type de congé. Vous en demandez {$nb_jours}.");
            }
        }

        // Insérer la demande de congé
        $congeModel = new CongeModel();
        $data = [
            'employe_id' => $id_employe,
            'type_conge_id' => $id_type_conge,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'nb_jours' => (int) $nb_jours,
            'motif' => $commentaire ?: null,
            'statut' => 'en_attente'
        ];

        if (!$congeModel->insert($data)) {
            return redirect()->to('/conge/form')
                           ->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre demande.');
        }

        return redirect()->to('/conge/form')
                       ->with('success', 'Votre demande de congé a été envoyée avec succès.');
    }
}
