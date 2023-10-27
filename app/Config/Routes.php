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
$routes->get('/admin/users/edit/(:num)', 'Users\\UsersController::Edit/$1');
$routes->get('/admin/users/add', 'Users\\UsersController::Create/$1');

$routes->post('/api/user/login', 'Users\\Api\\UsersApiController::check_login');
$routes->get('/api/users/list', 'Users\\Api\\UsersApiController::list');
$routes->post('/api/users/add', 'Users\\Api\\UsersApiController::add');
$routes->post('/api/users/update_is_active', 'Users\\Api\\UsersApiController::update_is_active');
$routes->post('api/users/get_role_names', 'Users\\Api\\UsersApiController::get_role_names');
$routes->post('/api/users/update/(:num)', 'Users\\Api\\UsersApiController::update/$1');
// $routes->post('/api/parts/add', 'Parts\\Api\\PartsApiController::add');
$routes->get('/api/users/get_one/(:num)', 'Users\\Api\\UsersApiController::getOne/$1');
$routes->post('/api/users/delete/(:num)', 'Users\\Api\\UsersApiController::delete/$1');



$routes->post('/api/users/get_permission_names', 'Users\\Api\\UsersApiController::get_permission_names');


$routes->get('/admin/parts/list', 'Parts\\PartsController::List');
$routes->get('/admin/parts/add', 'Parts\\PartsController::Create');
$routes->get('/admin/parts/import', 'Parts\\PartsController::Import');
$routes->post('/admin/parts/bulk_import_parts', 'Parts\\PartsController::bulk_import_parts');

$routes->get('admin/parts/export_part', 'Parts\\PartsController::export_part');
$routes->get('admin/parts/edit/(:num)', 'Parts\\PartsController::Edit/$1');


$routes->get('/admin/parts/view/(:num)', 'Parts\\PartsController::View/$1');

$routes->get('/api/parts/list', 'Parts\\Api\\PartsApiController::list');
$routes->post('/api/parts/add', 'Parts\\Api\\PartsApiController::add');
$routes->post('/api/parts/update_is_active', 'Parts\\Api\\PartsApiController::update_is_active');

$routes->post('/api/parts/update/(:num)', 'Parts\\Api\\PartsApiController::update/$1');
$routes->post('/api/parts/delete/(:num)', 'Parts\\Api\\PartsApiController::delete/$1');
$routes->get('/api/parts/get_one/(:num)', 'Parts\\Api\\PartsApiController::getOne/$1');
$routes->get('/api/parts/get_api_url', 'Parts\\Api\\PartsApiController::get_api_url');


$routes->post('/api/apiparts/add', 'Parts\\Api\\ApiPartsApiController::add');
$routes->post('/api/apiparts/get_api_data', 'Parts\\Api\\ApiPartsApiController::get_api_data');

$routes->get('/admin/jobs/list', 'Jobs\\JobsController::List');
$routes->get('/admin/jobs/add', 'Jobs\\JobsController::Create');
$routes->get('/admin/jobs/add_left', 'Jobs\\JobsController::Create_left');
$routes->get('/admin/jobs/right_job', 'Jobs\\JobsController::Right_job');
$routes->get('/admin/jobs/left_job', 'Jobs\\JobsController::Left_job');
$routes->get('/admin/jobs/edit/(:num)', 'Jobs\\JobsController::Edit/$1');
$routes->post('/api/jobs/update_is_active', 'jobs\\Api\\PartsApiController::update_is_active');

$routes->get('/api/jobs/list', 'Jobs\\Api\\JobsApiController::list');
$routes->post('/api/jobs/add', 'Jobs\\Api\\JobsApiController::add');
$routes->post('/api/jobs/update/(:num)', 'Jobs\\Api\\JobsApiController::update/$1');
$routes->post('/api/jobs/delete/(:num)', 'Jobs\\Api\\JobsApiController::delete/$1');
$routes->get('/api/jobs/get_one/(:num)', 'Jobs\\Api\\JobsApiController::getOne/$1');


$routes->post('/api/jobs/get_api_data', 'Jobs\\Api\\JobsApiController::get_api_data');



$routes->get('/admin/roles/list', 'Roles\\RolesController::List');
$routes->get('/admin/roles/add', 'Roles\\RolesController::Create');
$routes->get('/admin/roles/edit/(:num)', 'Roles\\RolesController::Edit/$1');

$routes->get('/api/roles/list', 'Roles\\Api\\RolesApiController::list');
$routes->post('/api/roles/add', 'Roles\\Api\\RolesApiController::add');
$routes->post('/api/roles/update_is_active', 'Roles\\Api\\RolesApiController::update_is_active');
$routes->post('/api/roles/delete/(:num)', 'Roles\\Api\\RolesApiController::delete/$1');
$routes->get('/api/roles/get_one/(:num)', 'Roles\\Api\\RolesApiController::getOne/$1');
$routes->post('/api/roles/update/(:num)', 'Roles\\Api\\RolesApiController::update/$1');




$routes->get('/admin/permissions/list', 'Permission\\PermissionController::List');
$routes->get('/admin/permissions/add', 'Permission\\PermissionController::Create');
$routes->get('/admin/permissions/edit/(:num)', 'Permission\\PermissionController::Edit/$1');

 $routes->get('/api/permissions/list', 'Permission\\Api\\PermissionApiController::list');
$routes->post('/api/permissions/add', 'Permission\\Api\\PermissionApiController::add');
$routes->post('/api/permissions/update_is_active', 'Permission\\Api\\PermissionApiController::update_is_active');
$routes->post('/api/permissions/delete/(:num)', 'Permission\\Api\\PermissionApiController::delete/$1');
$routes->get('/api/permissions/get_one/(:num)', 'Permission\\Api\\PermissionApiController::getOne/$1');
$routes->post('/api/permissions/update/(:num)', 'Permission\\Api\\PermissionApiController::update/$1');
$routes->get('api/pemissions/get_one/(:num)', 'Permission\\Api\\PermissionApiController::getOne/$1');


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
