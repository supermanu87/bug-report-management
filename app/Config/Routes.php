<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/api/bugs', 'Bugs::list');
$routes->post('/api/bugs/add', 'Bugs::add');
