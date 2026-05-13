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
$routes->get('/rh/approuver', 'RHController::approuverDemande');
$routes->get('/rh/refuser', 'RHController::refuserDemande');