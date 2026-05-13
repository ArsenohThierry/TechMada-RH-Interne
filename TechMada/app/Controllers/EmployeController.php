<?php

namespace App\Controllers;

class EmployeController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
        $this->checkRole();
    }

    /**
     * Vérifier que l'utilisateur a le rôle employé ou plus
     */
    protected function checkRole()
    {
        $role = $this->session->get('user_role');
        
        if (!in_array($role, ['employe', 'rh', 'admin'])) {
            throw new \RuntimeException('Accès non autorisé');
        }
    }

    /**
     * Dashboard employé
     */
    public function dashboard(): string
    {
        return view('employe/dashboard', [
            'user_id' => $this->session->get('user_id'),
            'user_name' => $this->session->get('user_prenom') . ' ' . $this->session->get('user_nom'),
        ]);
    }

    /**
     * Liste des congés de l'employé
     */
    public function conges(): string
    {
        return view('employe/conges');
    }

    /**
     * Créer une demande de congé
     */
    public function createConge()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'date_debut'   => 'required|valid_date[Y-m-d]',
            'date_fin'     => 'required|valid_date[Y-m-d]',
            'type_conge'   => 'required|integer',
            'motif'        => 'permit_empty|string',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Traiter la création de congé
        return redirect()->to('/employe/conges')->with('success', 'Demande créée');
    }

    /**
     * Profil utilisateur
     */
    public function profil(): string
    {
        return view('employe/profil');
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfil()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'prenom' => 'required|string|min_length[2]|max_length[100]',
            'nom'    => 'required|string|min_length[2]|max_length[100]',
        ]);

        if (!$validated) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Mettre à jour le profil
        return redirect()->to('/employe/profil')->with('success', 'Profil mis à jour');
    }
}
