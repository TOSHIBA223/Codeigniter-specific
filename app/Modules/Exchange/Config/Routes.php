<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Exchange\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer exchange***/
    $subroutes->add('currency/currency_list', 'Currency::index');
    $subroutes->add('buy/buy_list', 'Buy::index');
    $subroutes->add('buy/payment_form', 'Buy::paymentform');
    $subroutes->add('buy/buy_form', 'Buy::form');
    $subroutes->add('buy/buypayable', 'Buy::buypayable');
    $subroutes->add('sell/sell_list', 'Sell::index');
    $subroutes->add('sell/sell_form', 'Sell::form');
    $subroutes->add('sell/sellpayable', 'Sell::sellpayable');
    $subroutes->add('sell/payment_form', 'Sell::form');
    

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Exchange\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin exchange***/
    $subroutes->add('exchange/exchange_list', 'Exchange::index');
    $subroutes->add('exchange/edit_exchange/(:num)', 'Exchange::form/$1');
    $subroutes->add('exchange/receiveConfirm', 'Exchange::receiveConfirm');
    $subroutes->add('currency/currency_list', 'Currency::index');
    $subroutes->add('currency/currency_info/(:num)', 'Currency::form/$1');
    $subroutes->add('currency/local_currency', 'Local_currency::index');
    $subroutes->add('exchange/exchange_wallet', 'Exchange_wallet::index');
    $subroutes->add('exchange/exchangewallet_info', 'Exchange_wallet::form');
    $subroutes->add('exchange/exchangewallet_info/(:num)', 'Exchange_wallet::form/$1');
    $subroutes->add('exchange_wallet/delete/(:num)', 'Exchange_wallet::delete/$1');
});

$routes->group('backend', ['namespace' => 'App\Modules\Exchange\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('currency/Currency_cronjob', 'Currency_cronjob::updateCurency');
});