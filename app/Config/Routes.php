<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Users\\UsersController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Users\\UsersController::login');
$routes->get('/logout', 'Users\\UsersController::logout');
$routes->get('/admin/dashboard', 'Users\\UsersController::dashboard');

$routes->get('/admin/users/list', 'Users\\UsersController::list');

$routes->post('/api/user/login', 'Users\\Api\\UsersApiController::check_login');
$routes->get('/api/users/list', 'Users\\Api\\UsersApiController::list');
$routes->post('/api/users/add', 'Users\\Api\\UsersApiController::add');
$routes->post('/api/users/update/(:num)', 'Users\\Api\\UsersApiController::update/$1');

$routes->get('/admin/parts/list', 'Parts\\PartsController::List');
$routes->get('/admin/parts/add', 'Parts\\PartsController::Create');
$routes->get('/admin/parts/edit/(:num)', 'Parts\\PartsController::Edit/$1');

$routes->get('/api/parts/list', 'Parts\\Api\\PartsApiController::list');
$routes->post('/api/parts/add', 'Parts\\Api\\PartsApiController::add');

$routes->post('/api/parts/update/(:num)', 'Parts\\Api\\PartsApiController::update/$1');
$routes->post('/api/parts/delete/(:num)', 'Parts\\Api\\PartsApiController::delete/$1');
$routes->get('/api/parts/get_one/(:num)', 'Parts\\Api\\PartsApiController::getOne/$1');
$routes->post('/api/apiparts/add', 'Parts\\Api\\ApiPartsApiController::add');
$routes->post('/api/apiparts/get_api_data', 'Parts\\Api\\ApiPartsApiController::get_api_data');

$routes->get('/admin/jobs/list', 'Jobs\\JobsController::List');
$routes->get('/admin/jobs/add', 'Jobs\\JobsController::Create');
$routes->get('/admin/jobs/add_left', 'Jobs\\JobsController::Create_left');
$routes->get('/admin/jobs/edit/(:num)', 'Jobs\\JobsController::Edit/$1');

$routes->get('/api/jobs/list', 'Jobs\\Api\\JobsApiController::list');
$routes->post('/api/jobs/add', 'Jobs\\Api\\JobsApiController::add');
$routes->post('/api/jobs/update/(:num)', 'Jobs\\Api\\JobsApiController::update/$1');
$routes->post('/api/jobs/delete/(:num)', 'Jobs\\Api\\JobsApiController::delete/$1');
$routes->get('/api/jobs/get_one/(:num)', 'Jobs\\Api\\JobsApiController::getOne/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
