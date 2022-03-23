<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\CMS\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin cms***/
    $subroutes->add('content/page_content', 'Content::index');
    $subroutes->add('content/info/(:num)', 'Content::form/$1');
    $subroutes->add('content/delete/(:num)', 'Content::delete/$1');
    $subroutes->add('content/info', 'Content::form');
    $subroutes->add('contact/contact_info', 'Contact::index');
    $subroutes->add('team/team_list', 'Team::index');
    $subroutes->add('team/info', 'Team::form');
    $subroutes->add('team/delete/(:num)', 'Team::delete/$1');
    $subroutes->add('team/info/(:any)', 'Team::form/$1');
    $subroutes->add('client/client_list', 'Client::index');
    $subroutes->add('client/info', 'Client::form');
    $subroutes->add('client/info/(:num)', 'Client::form/$1');
    $subroutes->add('client/delete/(:num)', 'Client::delete/$1');
    $subroutes->add('service/service_list', 'Service::index');
    $subroutes->add('service/info', 'Service::form');
    $subroutes->add('service/info/(:num)', 'Service::form/$1');
    $subroutes->add('service/delete/(:num)', 'Service::delete/$1');
    $subroutes->add('testimonial/testimonial_list', 'Testimonial::index');
    $subroutes->add('testimonial/info', 'Testimonial::form');
    $subroutes->add('testimonial/info/(:num)', 'Testimonial::form/$1');
    $subroutes->add('testimonial/delete/(:num)', 'Testimonial::delete/$1');
    $subroutes->add('faq/faq_list', 'Faq::index');
    $subroutes->add('faq/info', 'Faq::form');
    $subroutes->add('faq/info/(:num)', 'Faq::form/$1');
    $subroutes->add('faq/delete/(:num)', 'Faq::delete/$1');
    $subroutes->add('news/news_list', 'News::index');
    $subroutes->add('news/info', 'News::form');
    $subroutes->add('news/info/(:num)', 'News::form/$1');
    $subroutes->add('news/delete/(:num)', 'News::delete/$1');
    $subroutes->add('category/category_list', 'Category::index');
    $subroutes->add('category/info', 'Category::form');
    $subroutes->add('category/info/(:num)', 'Category::form/$1');
    $subroutes->add('category/delete/(:num)', 'Category::delete/$1');
    $subroutes->add('slider/slider_list', 'Slider::index');
    $subroutes->add('slider/info', 'Slider::form');
    $subroutes->add('slider/info/(:num)', 'Slider::form/$1');
    $subroutes->add('slider/delete/(:num)', 'Slider::delete/$1');
    $subroutes->add('list/social_link', 'Social_link::index');
    $subroutes->add('info/social_link', 'Social_link::form');
    $subroutes->add('info/social_link/(:num)', 'Social_link::form/$1');
    $subroutes->add('advertisement/info', 'Advertisement::form');
    $subroutes->add('advertisement/info/(:num)', 'Advertisement::form/$1');
    $subroutes->add('advertisement/delete/(:num)', 'Advertisement::delete/$1');
    $subroutes->add('advertisement/advertisement_list', 'Advertisement::index');
    $subroutes->add('language/web_language', 'Web_language::index');
});