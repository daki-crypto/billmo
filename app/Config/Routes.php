<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth routes
$routes->group('auth', ['filter' => 'guest'], static function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('processLogin', 'Auth::processLogin');
    $routes->get('signup', 'Auth::signup');
    $routes->post('processSignup', 'Auth::processSignup');
});

$routes->get('auth/logout', 'Auth::logout', ['filter' => 'auth']);

// Default route
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Profile routess
$routes->group('profile', ['filter' => 'auth'], static function ($routes) {
    $routes->get('', 'ProfileController::index');
    $routes->post('update', 'ProfileController::update');
    $routes->post('change-password', 'ProfileController::changePassword');
    $routes->post('reset-password', 'ProfileController::resetPassword');
});


// Test database connection
$routes->get('/test', 'Home::testdb');

// User management (Admin only)
$routes->group('users', ['filter' => 'admin'], static function ($routes) {
    $routes->get('', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->get('(:num)/edit', 'UserController::edit/$1');
    $routes->post('(:num)/update', 'UserController::update/$1');
    $routes->post('(:num)/delete', 'UserController::delete/$1');
});

// Bills routes
$routes->group('bills', ['filter' => 'admin'], static function ($routes) {
    $routes->get('', 'BillController::index');
    $routes->get('create', 'BillController::create');
    $routes->post('store', 'BillController::store');
    $routes->get('(:num)', 'BillController::show/$1');
    $routes->get('(:num)/edit', 'BillController::edit/$1');
    $routes->post('(:num)/update', 'BillController::update/$1');
    $routes->post('(:num)/delete', 'BillController::delete/$1');
    $routes->get('client/(:num)', 'BillController::clientBills/$1');
});

// Clients routes (Admin only)
$routes->group('clients', ['filter' => 'admin'], static function ($routes) {
    $routes->get('', 'ClientController::index');
    $routes->get('create', 'ClientController::create');
    $routes->post('store', 'ClientController::store');
    $routes->get('(:num)', 'ClientController::show/$1');
    $routes->get('(:num)/edit', 'ClientController::edit/$1');
    $routes->post('(:num)/update', 'ClientController::update/$1');
    $routes->post('(:num)/delete', 'ClientController::delete/$1');
});

// Billing routes (Normal user - compute & view history)
$routes->group('billing', ['filter' => 'normal'], static function ($routes) {
    $routes->get('compute', 'ComputeBillController::compute');
    $routes->post('store', 'ComputeBillController::store');
    $routes->get('history', 'ComputeBillController::history');
    $routes->get('summary/(:num)', 'ComputeBillController::summary/$1');
});

// Audit logs routes
$routes->group('audit', ['filter' => 'auth'], static function ($routes) {
    $routes->get('', 'AuditController::index');
});

