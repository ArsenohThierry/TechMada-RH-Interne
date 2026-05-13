<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Vérifier que l'utilisateur est authentifié
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('warning', 'Vous devez être connecté pour accéder à cette page');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
