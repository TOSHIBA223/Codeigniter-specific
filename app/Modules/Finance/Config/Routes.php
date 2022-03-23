<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Finance\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('deposit/add_deposit', 'Deposit::index');
    $subroutes->add('deposit/payment_gateway', 'Deposit::payment_gateway');
    $subroutes->add('deposit/show_list', 'Deposit::show');
    $subroutes->add('deposit/deposit_list/(:any)', 'Deposit::deposit_list/$1');
    $subroutes->add('withdraw/withdraw_ajax_list/(:any)', 'Withdraw::withdraw_ajax_list/$1');
    $subroutes->add('withdraw/confirm_withdraw/(:num)', 'Withdraw::confirm_withdraw/$1');
    $subroutes->add('withdraw/withdraw_verify', 'Withdraw::withdraw_verify');
    $subroutes->add('withdraw/withdraw_details/(:num)', 'Withdraw::withdraw_details/$1');
    $subroutes->add('withdraw/withdraw_list', 'Withdraw::withdraw_list');    
    $subroutes->add('withdraw/store', 'Withdraw::store');
    $subroutes->add('withdraw/withdraw_money', 'Withdraw::index');
    $subroutes->add('withdraw/withdraw_list', 'Withdraw::withdraw_list');

    $subroutes->add('transfer/transfer_amount', 'Transfer::index');
    $subroutes->add('transfer/store', 'Transfer::store');
    $subroutes->add('transfer/confirm_transfer/(:num)', 'Transfer::confirm_transfer/$1');
    $subroutes->add('transfer/transfer_verify', 'Transfer::transfer_verify');
    $subroutes->add('transfer/transfer_recite/(:num)', 'Transfer::transfer_recite/$1');
    $subroutes->add('transfer/transfer_list', 'Transfer::transfer_list');
    $subroutes->add('transfer/send_details/(:num)', 'Transfer::send_details/$1');
    $subroutes->add('transfer/receive_details/(:num)', 'Transfer::receive_details/$1');
    $subroutes->add('transection/transection_list', 'Transection::index');
    

});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Finance\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('internal_api/gateway', 'Internal_api::gateway');
    $subroutes->add('ajaxload/fees_load', 'Ajaxload::fees_load');
    $subroutes->add('ajaxload/walletid', 'Ajaxload::walletid');
    $subroutes->add('ajaxload/checke_reciver_id', 'Ajaxload::checke_reciver_id');

});
$routes->group('', ['namespace' => 'App\Modules\Finance\Controllers'], function ($subroutes) {
    /*** Route for  finance***/
    $subroutes->add('ajaxload/user_info_load/(:any)', 'Ajaxload::user_info_load/$1');
   

});

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Finance\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('deposit/deposit_list', 'Deposit::index');
    $subroutes->add('deposit/pending_deposit', 'Deposit::pending_deposit');
    $subroutes->add('withdraw/withdraw_list', 'Withdraw::index');
    $subroutes->add('withdraw/pending_withdraw', 'Withdraw::pending_withdraw');
    $subroutes->add('credit/add_credit', 'Credit::add_credit');
    $subroutes->add('credit/send_credit', 'Credit::send_credit');
    $subroutes->add('credit/credit_list', 'Credit::index');
    $subroutes->add('confirm_deposit', 'Deposit::confirm_deposit');
    $subroutes->add('cancel_deposit', 'Deposit::cancel_deposit');
    $subroutes->add('credit/credit_details/(:num)', 'Credit::credit_details/$1');
    $subroutes->add('confirm_withdraw', 'Withdraw::confirm_withdraw');
    $subroutes->add('cancel_withdraw', 'Withdraw::cancel_withdraw');

});