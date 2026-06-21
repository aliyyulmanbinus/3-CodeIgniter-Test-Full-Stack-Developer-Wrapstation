<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Routes untuk modul Users
$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->post('/users/delete/(:num)', 'UserController::delete/$1');

// Routes untuk modul Products
$routes->get('/products', 'ProductController::index');
$routes->get('/products/create', 'ProductController::create');
$routes->post('/products/store', 'ProductController::store');
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1');
$routes->post('/products/update/(:num)', 'ProductController::update/$1');
$routes->post('/products/delete/(:num)', 'ProductController::delete/$1');

// Routes untuk modul Transactions
$routes->get('/transactions', 'TransactionController::index');
$routes->get('/transactions/create', 'TransactionController::create');
$routes->post('/transactions/store', 'TransactionController::store');
$routes->get('/transactions/edit/(:num)', 'TransactionController::edit/$1');
$routes->post('/transactions/update/(:num)', 'TransactionController::update/$1');
$routes->post('/transactions/delete/(:num)', 'TransactionController::delete/$1');
