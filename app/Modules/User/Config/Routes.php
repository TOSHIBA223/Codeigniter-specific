<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\User\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    
    $subroutes->add('profile/edit_profile', 'Profile::index');
    $subroutes->add('profile/update', 'Profile::Update');
    $subroutes->add('profile/change_password', 'Profile::change_password');
    $subroutes->add('profile/change_save', 'Profile::change_save');
    $subroutes->add('profile/profile_verify/(:any)', 'Profile::profile_verify/$1');
    $subroutes->add('profile/profile_update', 'Profile::profile_update');

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\User\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('users/user_info', 'User::form');
    $subroutes->add('users/user_info/(:num)', 'User::form/$1');
    $subroutes->add('users/user_list', 'User::index');
    $subroutes->add('user/user_details/(:num)', 'User::user_details/$1');

});

$routes->group('', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\User\Controllers\Admin'], function ($subroutes) {
		$subroutes->add('user/ajax_list', 'User::ajax_list');
        $subroutes->add('user/deposit_list/(:any)', 'User::deposit_list/$1');
        $subroutes->add('user/investment_list/(:any)', 'User::investment_list/$1');
        $subroutes->add('user/withdraw_list/(:any)', 'User::withdraw_list/$1');
        $subroutes->add('user/transfer_list/(:any)', 'User::transfer_list/$1');
        $subroutes->add('user/transferreceive_list/(:any)', 'User::transferreceive_list/$1');
});