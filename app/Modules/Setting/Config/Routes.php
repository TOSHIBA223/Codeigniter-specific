<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Setting\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer setting***/
    $subroutes->add('settings/language_setting', 'Settings::language_setting');
    $subroutes->add('settings/update_language', 'Settings::update_language');
    $subroutes->add('settings/payment_method_setting', 'Settings::payment_method_setting');
    $subroutes->add('settings/payment_method_update', 'Settings::payment_method_update');
    

});

$routes->group('',['filter' => 'admin_filter', 'namespace' => 'App\Modules\Setting\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('internal_api/getemailsmsgateway', 'Internal_api::getemailsmsgateway');
});

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Setting\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin setting***/
    $subroutes->add('setting/app_setting', 'Setting::index');
    $subroutes->add('setting/fees_setting', 'Setting::fees_setting');
    $subroutes->add('setting/fees_setting_save', 'Setting::fees_setting_save');
    $subroutes->add('setting/delete_fees_setting/(:num)', 'Setting::delete_fees_setting/$1');
    $subroutes->add('setting/commission_setup', 'Setting::commission_setup');
    $subroutes->add('setting/commission_update', 'Setting::commission_update');
    $subroutes->add('setting/email_sms_setting', 'Setting::email_sms_setting');
    $subroutes->add('setting/update_sender', 'Setting::update_sender');
    $subroutes->add('setting/email_gateway', 'Setting::email_gateway');
    $subroutes->add('setting/test_email', 'Setting::test_email');
    $subroutes->add('setting/update_email_gateway', 'Setting::update_email_gateway');
    $subroutes->add('setting/sms_gateway', 'Setting::sms_gateway');
    $subroutes->add('setting/smsemail_template', 'Setting::sms_email_template');
    $subroutes->add('setting/smsemail_templateform/(:num)', 'Setting::sms_email_template_form/$1');
    $subroutes->add('setting/update_sms_gateway', 'Setting::update_sms_gateway');
    $subroutes->add('setting/test_sms', 'Setting::test_sms');
    $subroutes->add('externalapi/api_list', 'Setting::api_list');
    $subroutes->add('externalapi/external_api_setup/(:num)', 'Setting::api_form/$1');
    $subroutes->add('language/language_list', 'Language::index');
    $subroutes->add('language/add_phrase', 'Language::addPhrase');
    $subroutes->add('language/add_language', 'Language::addLanguage');
    $subroutes->add('language/edit_phrase/(:any)', 'Language::editPhrase/$1');
    $subroutes->add('language/add_lebel', 'Language::addLebel');
    $subroutes->add('language/phrase_list', 'Language::phrase');
});