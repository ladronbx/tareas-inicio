<?php

namespace Config;
use App\Controllers\HomeController;
use App\Controllers\OpportunitexController;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->post('/enviar-oportunidad', OpportunitexController::class . '::enviarOportunidad');
$routes->get('/', HomeController::class . '::form');

$routes->get('/', 'Home::index');


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}