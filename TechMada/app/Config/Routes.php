<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/conge/form', 'CongeController::congeForm');
$routes->post('/conges/send', 'CongeController::envoyerConges');