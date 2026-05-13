<?php

namespace App\Controllers;

class RhController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
        $this->checkRole();
    }

    /**
     * Vérifier que l'utilisateur a le rôle RH ou admin
     */
    protected function checkRole()
    {
        $role = $this->session->get('user_role');
        
        if (!in_array($role, ['rh', 'admin'])) {
            throw new \RuntimeException('Accès réservé à la RH et administrateurs');
        }
    }

    /**
     * Dashboard RH
     */
    public function dashboard(): string
    {
        return view('rh/dashboard');
    }

    /**
     * Liste des demandes de congé
     */
    public function demandes(): string
    {
        return view('rh/demandes');
    }

    /**
     * Approver une demande
     */
    public function approverDemande(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'commentaire' => 'permit_empty|string',
        ]);

        if (!$validated) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Approver la demande
        return redirect()->to('/rh/demandes')->with('success', 'Demande approuvée');
    }

    /**
     * Refuser une demande
     */
    public function refuserDemande(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'motif_refus' => 'required|string|min_length[10]',
        ]);

        if (!$validated) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Refuser la demande
        return redirect()->to('/rh/demandes')->with('success', 'Demande refusée');
    }

    /**
     * Liste des employés
     */
    public function employes(): string
    {
        return view('rh/employes');
    }

    /**
     * Rapport de congés
     */
    public function rapports(): string
    {
        return view('rh/rapports');
    }
}
