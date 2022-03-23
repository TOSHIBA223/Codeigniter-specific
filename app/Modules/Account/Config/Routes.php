<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Account\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer account***/
    
    $subroutes->add('account/my_payout', 'Commission::my_payout');
    $subroutes->add('account/payout_receipt/(:any)', 'Commission::payout_receipt/$1');
    $subroutes->add('account/my_commission', 'Commission::my_commission');
    $subroutes->add('account/commission_receipt/(:num)', 'Commission::commission_receipt/$1');
    $subroutes->add('account/team_bonus', 'Commission::team_bonus');
    $subroutes->add('account/my_generation', 'Team::index');
    $subroutes->add('account/mylevel_info', 'Commission::my_level_info');

});
$routes->group('customer', ['namespace' => 'App\Modules\Account\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer account***/
    
    $subroutes->add('auto_commission/payout', 'Auto_commission::payout');

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Account\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin account***/
    

});