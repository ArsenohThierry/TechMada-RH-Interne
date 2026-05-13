<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NotAuthFilter implements FilterInterface
{
    /**
     * Rediriger les utilisateurs connectés loin du login
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if ($session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
