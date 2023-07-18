<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('User');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User::login');
$routes->get('/login', 'User::login'); 
$routes->get('/manufacturerDashboard', 'Manufacturer::manufacturerDashboard'); 
$routes->get('/sellerDashboard', 'Seller::sellerDashboard');
$routes->get('/customerDashboard', 'Customer::customerDashboard'); 
$routes->get('/addProduct', 'Manufacturer::addProduct'); 
$routes->post('/addItem', 'Manufacturer::addItem'); 
$routes->post('/addStock', 'Seller::addStock'); 
$routes->get('/addStocks', 'Seller::addStocks'); 
$routes->post('/get_quantity', 'Seller::get_quantity'); 
$routes->post('/get_quantity_stocks', 'Customer::get_quantity_stocks'); 
$routes->get('/logout', 'User::logout');
$routes->get('/register', 'User::register'); 
$routes->post('/action', 'User::action');
$routes->post('/add', 'User::add');
$routes->post('/customerBag', 'Customer::customerBag'); 
$routes->get('/customerCart', 'Customer::customerCart'); 
$routes->get('/deleteItem/(:num)', 'Manufacturer::deleteItem/$1');
$routes->get('/deleteStock/(:num)', 'Seller::deleteStock/$1');
// $routes->get('edit-view/(:num)', 'UserCrud::singleUser/$1');
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
