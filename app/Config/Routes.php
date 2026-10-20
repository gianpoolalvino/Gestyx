<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Index');
$routes->get('AlistamientoVehicular/Accesorios','AlistamientoVehicular\Accesorios\Index::Index');

$routes->get('SolicitudVin/VinSolicitud/(:any)/(:any)','SolicitudVin\VinSolicitud\Index::Index/$1/$2');

