<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthEmployeFilter implements FilterInterface
{
    /**
     * Vérifier que l'utilisateur est authentifié et a le rôle employé
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('warning', 'Vous devez être connecté pour accéder à cette page');
        }

        $role = $session->get('user_role');
        if (!in_array($role, ['employe', 'rh', 'admin'])) {
            return redirect()->to('/')->with('error', 'Accès non autorisé');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
