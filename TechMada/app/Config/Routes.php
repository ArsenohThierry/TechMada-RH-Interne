<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// Public Routes (no filter)
// ============================================================
$routes->get('/', 'Home::index');

// ============================================================
// Authentication Routes (no login required)
// ============================================================
$routes->get('/auth/login', 'AuthController::loginView', ['filter' => 'noauth']);
$routes->post('/auth/login', 'AuthController::login', ['filter' => 'noauth']);
$routes->get('/auth/register', 'AuthController::registerView', ['filter' => 'noauth']);
$routes->post('/auth/register', 'AuthController::register', ['filter' => 'noauth']);
$routes->get('/auth/logout', 'AuthController::logout');


$routes->group('/employe', ['filter' => 'auth_employe'], static function ($routes) {
    $routes->get('dashboard', 'EmployeController::dashboard');
    $routes->get('conges', 'EmployeController::conges');
    $routes->get('conges/form', 'CongeController::congeForm');
    $routes->post('conges/send', 'CongeController::envoyerConges');
    $routes->post('conges/create', 'EmployeController::createConge');
    $routes->get('profil', 'EmployeController::profil');
    $routes->post('profil/update', 'EmployeController::updateProfil');
});

// ============================================================
// Routes RH (/rh) - Requires auth_rh filter
// ============================================================
$routes->group('/rh', ['filter' => 'auth_rh'], static function ($routes) {
    $routes->get('dashboard', 'RhController::dashboard');
    $routes->get('demandes', 'RhController::demandes');
    $routes->get('listeDemandes', 'RHController::listeDemandes');
    $routes->get('home', 'RHController::listeDemandes'); // alias
    
    // RH leave actions (approval/rejection/cancellation)
    $routes->get('conges/approuver/(:num)', 'RHController::approuverDemande/$1');
    $routes->post('conges/approuver/(:num)', 'RHController::approuverDemande/$1');
    $routes->post('conges/refuser/(:num)', 'RHController::refuserDemande/$1');
    $routes->post('conges/annuler/(:num)', 'RHController::annulerDemande/$1');
    
    // Legacy routes (may be deprecated)
    $routes->post('demandes/approver/(:num)', 'RhController::approverDemande/$1');
    $routes->post('demandes/refuser/(:num)', 'RhController::refuserDemande/$1');
    
    $routes->get('employes', 'RhController::employes');
    $routes->get('rapports', 'RhController::rapports');
});

// ============================================================
// Routes Admin (/admin)
// ============================================================
$routes->group('/admin', ['filter' => 'auth_admin'], static function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('utilisateurs', 'AdminController::utilisateurs');
    $routes->post('utilisateurs/create', 'AdminController::createUtilisateur');
    $routes->post('utilisateurs/(:num)/update', 'AdminController::updateUtilisateur/$1');
    $routes->post('utilisateurs/(:num)/delete', 'AdminController::deleteUtilisateur/$1');
    $routes->get('parametres', 'AdminController::parametres');
    $routes->post('parametres/update', 'AdminController::updateParametres');
});