<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->post('dashboard/runSollstellung', 'Dashboard::runSollstellung');

$routes->resource('liegenschaften');

$routes->resource('einheiten');

$routes->resource('mietvertraege');

$routes->get('transaktionen', 'Transaktionen::index');
$routes->post('transaktionen/markAsPaid/(:num)', 'Transaktionen::markAsPaid/$1');