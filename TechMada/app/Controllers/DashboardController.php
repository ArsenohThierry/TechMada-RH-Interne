<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    /**
     * Afficher le dashboard
     */
    public function index(): string
    {
        return view('dashboard');
    }
}
