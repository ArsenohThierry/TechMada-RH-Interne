<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
        $this->checkRole();
    }

    /**
     * Vérifier que l'utilisateur a le rôle admin
     */
    protected function checkRole()
    {
        $role = $this->session->get('user_role');
        
        if ($role !== 'admin') {
            throw new \RuntimeException('Accès réservé aux administrateurs');
        }
    }

    /**
     * Dashboard Admin
     */
    public function dashboard(): string
    {
        return view('admin/dashboard');
    }

    /**
     * Gestion des utilisateurs
     */
    public function utilisateurs(): string
    {
        return view('admin/utilisateurs');
    }

    /**
     * Créer un utilisateur
     */
    public function createUtilisateur()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'email'    => 'required|valid_email|is_unique[employes.email]',
            'password' => 'required|min_length[6]',
            'nom'      => 'required|string|min_length[2]|max_length[100]',
            'prenom'   => 'required|string|min_length[2]|max_length[100]',
            'role'     => 'required|in_list[employe,rh,admin]',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Créer l'utilisateur
        return redirect()->to('/admin/utilisateurs')->with('success', 'Utilisateur créé');
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function updateUtilisateur(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'nom'    => 'required|string|min_length[2]|max_length[100]',
            'prenom' => 'required|string|min_length[2]|max_length[100]',
            'role'   => 'required|in_list[employe,rh,admin]',
            'actif'  => 'required|in_list[0,1]',
        ]);

        if (!$validated) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Mettre à jour l'utilisateur
        return redirect()->to('/admin/utilisateurs')->with('success', 'Utilisateur mis à jour');
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUtilisateur(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Supprimer l'utilisateur
        return redirect()->to('/admin/utilisateurs')->with('success', 'Utilisateur supprimé');
    }

    /**
     * Paramètres système
     */
    public function parametres(): string
    {
        return view('admin/parametres');
    }

    /**
     * Mettre à jour les paramètres
     */
    public function updateParametres()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validation CSRF est automatique
        $validated = $this->validate([
            'jours_conges_annuels' => 'required|integer|greater_than[0]',
        ]);

        if (!$validated) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Mettre à jour les paramètres
        return redirect()->to('/admin/parametres')->with('success', 'Paramètres mises à jour');
    }
}
