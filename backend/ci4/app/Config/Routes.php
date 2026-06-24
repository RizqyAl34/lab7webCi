<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setAutoRoute(false);

/*
|--------------------------------------------------------------------------
| CORS Preflight
|--------------------------------------------------------------------------
*/
$routes->options('(:any)', function() {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setStatusCode(200);
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');

$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
$routes->get('/login', 'User::login');
$routes->post('/login', 'User::login');
$routes->get('/logout', 'User::logout');

$routes->get('user/login', 'User::login');
$routes->post('user/login', 'User::login');
$routes->get('user/logout', 'User::logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->match(['GET', 'POST'], 'artikel/add', 'Artikel::add');
    $routes->match(['GET', 'POST'], 'artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');
});

/*
|--------------------------------------------------------------------------
| AJAX ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('ajax', function($routes) {
    $routes->post('delete/(:num)', 'Artikel::delete/$1');
});

/*
|--------------------------------------------------------------------------
| REST API ROUTES — GET bebas, POST/PUT/DELETE wajib token
|--------------------------------------------------------------------------
*/
$routes->get('post', 'Post::index');
$routes->get('post/(:segment)', 'Post::show/$1');

// ✅ Endpoint yang diproteksi filter apiauth
$routes->post('post', 'Post::create', ['filter' => 'apiauth']);
$routes->put('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->delete('post/(:segment)', 'Post::delete/$1', ['filter' => 'apiauth']);

/*
|--------------------------------------------------------------------------
| API AUTH ROUTES
|--------------------------------------------------------------------------
*/
$routes->post('api/login', 'Api\Auth::login');