<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('', ['namespace' => 'App\Modules\Website\Controllers'], function($subroutes){

	/*** Route for Website ***/
        $subroutes->add('', 'Home::index');
        $subroutes->add('home', 'Home::index');
        $subroutes->add('coinmarket', 'Home::coinmarket');
        $subroutes->add('package', 'Home::lending');
        $subroutes->add('exchange', 'Home::exchange');
        $subroutes->add('buy', 'Home::buy');
        $subroutes->add('home/buypayable', 'Home::buypayable');
        $subroutes->add('home/sellpayable', 'Home::sellPayable');
        $subroutes->add('paymentform', 'Home::paymentform');
        $subroutes->add('register', 'Home::register');
        $subroutes->add('home/login', 'Home::login');
        $subroutes->add('home/forgotPassword', 'Home::forgotPassword');
        $subroutes->add('sells', 'Home::sells');
        $subroutes->add('about', 'Home::about');
        $subroutes->add('news', 'Home::news');
        $subroutes->add('news/(:any)/(:any)', 'Home::news/$1/$2');
        $subroutes->add('news/(:any)', 'Home::news/$1');
        $subroutes->add('faq', 'Home::faq');
        $subroutes->add('service', 'Home::service');
        $subroutes->add('service/(:any)', 'Home::service/$1');
        $subroutes->add('contact', 'Home::contact');
        $subroutes->add('home/contactMsg', 'Home::contactMsg');
        $subroutes->add('internal_api/getStream', 'Internal_api::getStream');
        $subroutes->add('home/cointrickerdata', 'Home::cointrickerdata');
        $subroutes->add('home/coingraphdata', 'Home::coingraphdata');
        $subroutes->add('coin-details', 'Home::price');
        $subroutes->add('coin-details/(:any)', 'Home::price/$1');
        $subroutes->add('resetPassword', 'Home::resetPassword');
        $subroutes->add('logout', 'Home::logout');
        $subroutes->add('internal_api/settings', 'Internal_api::settings');
        $subroutes->add('home/langChange', 'Home::langChange');
        $subroutes->add('home/activeAcc/(:any)', 'Home::activeAcc/$1');
        $subroutes->add('/(:any)', 'Home::index');
});
