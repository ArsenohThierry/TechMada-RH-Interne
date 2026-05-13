<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/conge/form', 'CongeController::congeForm');
$routes->post('/conges/send', 'CongeController::envoyerConges');

$routes->get('/rh/listeDemandes', 'RHController::listeDemandes');
$routes->get('/rh/home', 'RHController::listeDemandes'); // alias

// RH actions: approbation / refus / annulation des congés
$routes->get('/rh/conges/approuver/(:num)', 'RHController::approuverDemande/$1');
$routes->post('/rh/conges/approuver/(:num)', 'RHController::approuverDemande/$1');
$routes->post('/rh/conges/refuser/(:num)', 'RHController::refuserDemande/$1');
$routes->post('/rh/conges/annuler/(:num)', 'RHController::annulerDemande/$1');
$routes->get('/rh/conges/approuver/(:num)', 'RHController::approuverDemande');
$routes->get('/rh/conges/refuser/(:num)', 'RHController::refuserDemande');