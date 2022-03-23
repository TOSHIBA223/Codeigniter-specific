<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Package\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer package***/
    $subroutes->add('package/package_list', 'Package::index');
    $subroutes->add('package/confirm_package/(:num)', 'Package::confirm_package/$1');
    $subroutes->add('package/package_buy/(:num)/', 'Package::buy/$1');
    $subroutes->add('package/buy_success/(:num)/(:num)', 'Package::buy_success/$1/$2');
    $subroutes->add('package/my_package', 'Package::my_package');
    

});



$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Package\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin package***/
    $subroutes->add('package/add_package', 'Package::form');
    $subroutes->add('package/edit_package', 'Package::form');
    $subroutes->add('package/edit_package/(:num)', 'Package::form/$1');
    $subroutes->add('package/package_list', 'Package::index');
    $subroutes->add('package/delete/(:num)', 'Package::delete/$1');
});