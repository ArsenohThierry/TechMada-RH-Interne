<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = service('session');
        $this->validation = \Config\Services::validation();
    }

    /**
     * Afficher la page de login
     */
    public function loginView(): string
    {
        return view('auth/login', [
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Traiter le formulaire de login
     */
    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        try {
            // Vérifier les identifiants
            $user = $this->userModel->verifyCredentials($email, $password);

            if (!$user) {
                return redirect()->back()->withInput()
                    ->with('error', 'Email ou mot de passe incorrect');
            }

            // Créer la session (compatibilité avec clés existantes)
            $sessionData = [
                'user_id'     => $user['id'],
                'employe_id'  => $user['id'],
                'user_email'  => $user['email'],
                'user_nom'    => $user['nom'],
                'employe_nom' => $user['nom'],
                'user_prenom' => $user['prenom'],
                'employe_prenom' => $user['prenom'],
                'user_role'   => $user['role'],
                'logged_in'   => true,
            ];

            $this->session->set($sessionData);

            // Redirection selon rôle
            switch ($user['role']) {
                case 'admin':
                    $target = '/admin/dashboard';
                    break;
                case 'rh':
                    $target = '/rh/dashboard';
                    break;
                default:
                    $target = '/employe/dashboard';
            }

            return redirect()->to("/")->with('success', 'Bienvenue ' . $user['prenom']);
        } catch (\Exception $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Erreur lors du login: ' . $e->getMessage());
        }
    }

    /**
     * Afficher la page d'inscription
     */
    public function registerView(): string
    {
        return view('auth/register', [
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Traiter l'inscription
     */
    public function register()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'nom'      => 'required|min_length[2]|max_length[100]',
            'prenom'   => 'required|min_length[2]|max_length[100]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Cet email est déjà utilisé',
                'valid_email' => 'Email invalide',
            ],
            'password' => [
                'min_length' => 'Le mot de passe doit avoir au moins 6 caractères',
            ],
            'password_confirm' => [
                'matches' => 'Les mots de passe ne correspondent pas',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');

        try {
            // Vérifier si l'email existe déjà
            if ($this->userModel->emailExists($email)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Cet email est déjà utilisé');
            }

            if ($this->userModel->createUser($email, $password, $nom, $prenom)) {
                return redirect()->to('/auth/login')->with('success', 
                    'Inscription réussie! Veuillez vous connecter');
            }
        } catch (\Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Erreur lors de l\'inscription: ' . $e->getMessage());
        }

        return redirect()->back()->withInput()
            ->with('error', 'Erreur lors de l\'inscription');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Vous êtes déconnecté');
    }
}
