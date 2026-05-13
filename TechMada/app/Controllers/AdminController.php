<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementsModel;

class AdminController extends BaseController
{
    protected $session;
    protected $employeModel;
    protected $departementModel;

    public function __construct()
    {
        $this->session = session();
        $this->employeModel = new EmployeModel();
        $this->departementModel = new DepartementsModel();
    }

    // ============================================================
    // DASHBOARD
    // ============================================================
    public function dashboard(): string
    {
        return view('admin/dashboard', [
            'total_employes' => $this->employeModel->countAllResults(),
            'total_departements' => $this->departementModel->countAllResults(),
        ]);
    }

    // ============================================================
    // EMPLOYÉS
    // ============================================================

    public function employes(): string
    {
        return view('admin/employes/index', [
            'employes' => $this->employeModel->getEmployesWithDepartement(),
        ]);
    }

    public function createEmployeForm(): string
    {
        return view('admin/employes/form', [
            'departements' => $this->departementModel->findAll(),
            'employe' => null,
            'action' => 'create',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function createEmploye()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/employe/form');
        }

        $validated = $this->validate([
            'nom'            => 'required|min_length[2]|max_length[100]',
            'prenom'         => 'required|min_length[2]|max_length[100]',
            'email'          => 'required|valid_email|is_unique[employes.email]',
            'password'       => 'required|min_length[6]',
            'role'           => 'required|in_list[employe,rh,admin]',
            'departement_id' => 'permit_empty|numeric',
            'date_embauche'  => 'required|valid_date[Y-m-d]',
        ]);

        if (!$validated) {
            return redirect()->to('/admin/employe/form')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'password'       => $this->request->getPost('password'),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id') ?: null,
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => 1,
        ];

        if ($this->employeModel->createEmploye($data)) {
            return redirect()->to('/admin/employes')->with('success', 'Employé créé');
        }

        return redirect()->to('/admin/employe/form')->with('error', 'Erreur création employé');
    }

    public function editEmployeForm($id): string
    {
        $employe = $this->employeModel->find($id);

        if (!$employe) {
            return redirect()->to('/admin/employes')->with('error', 'Employé introuvable');
        }

        return view('admin/employes/form', [
            'departements' => $this->departementModel->findAll(),
            'employe' => $employe,
            'action' => 'edit',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function updateEmploye($id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/employes');
        }

        $rules = [
            'nom'            => 'required|min_length[2]|max_length[100]',
            'prenom'         => 'required|min_length[2]|max_length[100]',
            'email'          => 'required|valid_email|is_unique[employes.email,id,' . $id . ']',
            'role'           => 'required|in_list[employe,rh,admin]',
            'departement_id' => 'permit_empty|numeric',
            'date_embauche'  => 'required|valid_date[Y-m-d]',
            'actif'          => 'required|in_list[0,1]',
        ];

        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/employe/' . $id . '/edit')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id') ?: null,
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => $this->request->getPost('actif'),
        ];

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password');
        }

        $this->employeModel->updateEmploye($id, $data);

        return redirect()->to('/admin/employes')->with('success', 'Employé mis à jour');
    }

    public function deleteEmploye($id)
    {
        $this->employeModel->deactivateEmploye($id);
        return redirect()->to('/admin/employes')->with('success', 'Employé désactivé');
    }

    // ============================================================
    // DÉPARTEMENTS
    // ============================================================

    public function departements(): string
    {
        return view('admin/departements/index', [
            'departements' => $this->departementModel->findAll(),
        ]);
    }

    public function createDepartementForm(): string
    {
        return view('admin/departements/form', [
            'departement' => null,
            'action' => 'create',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function createDepartement()
    {
        $validated = $this->validate([
            'nom'         => 'required|min_length[2]|max_length[100]|is_unique[departements.nom]',
            'description' => 'permit_empty|max_length[500]',
        ]);

        if (!$validated) {
            return redirect()->to('/admin/departement/form')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->departementModel->insert([
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département créé');
    }

    public function updateDepartement($id)
    {
        $validated = $this->validate([
            'nom'         => 'required|min_length[2]|max_length[100]|is_unique[departements.nom,id,' . $id . ']',
            'description' => 'permit_empty|max_length[500]',
        ]);

        if (!$validated) {
            return redirect()->to('/admin/departement/' . $id . '/edit')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->departementModel->update($id, [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département mis à jour');
    }

    public function deleteDepartement($id)
    {
        $employes = $this->employeModel->where('departement_id', $id)->findAll();

        if (!empty($employes)) {
            return redirect()->to('/admin/departements')->with('error', 'Département utilisé');
        }

        $this->departementModel->delete($id);

        return redirect()->to('/admin/departements')->with('success', 'Département supprimé');
    }
}