<?php

/*
    **Developed By Bdtask Ltd. (--Blockchain Team--)**

    1) Status 0 = single menu, 1= parent menue with sub menu
    2) Segment and segemnt text use for active menu when click this menu ex:- if(segment==segment_text)?'active':null;
    3) Menu without sub menu ex:-

        i) Do not change :- 'status' => 0

        $ADMINMENU['auth'] = array(
            'order'         => 1,
            'parent'        => 'Dashboard',
            'status'        => 0,
            'link'          => 'home',
            'icon'          => '<i class="typcn typcn-home-outline"></i>',
            'segment'       => 2,
            'segment_text'  => 'home'
        );

    4) Menu with sub menu ex:-

        i) Do not change :- 'status' => 1

        $ADMINMENU['auth'] = array(
            'order'                 => 1,
            'parent'                => 'Finance',
            'icon'                  => '<i class="fa fa-credit-card"></i>',
            'submenu'               => array(
                '0' => array(
                    'name'          => 'Deposit',
                    'icon'          => null,
                    'link'          => 'deposit',
                    'segment'       => 2,
                    'segment_text'  => 'deposit',
                ),
                '1' => array(
                    'name'          => 'Withdraw',
                    'icon'          => null,
                    'link'          => 'withdraw',
                    'segment'       => 2,
                    'segment_text'  => 'withdraw',
                )
            ),
            'segment'               => 2,
            'segment_text'          => 'finance',
            'status'                => 1
        );
    5) Previous menu with new submenu push ex:-
        $arraydata = array(
            '0' => array(
                'name'          => 'Pending Deposti',
                'icon'          => null,
                'link'          => 'deposit/pending_deposit',
                'segment'       => 3,
                'segment_text'  => 'pending_deposit',
            )
        );
        array_push($ADMINMENU['auth']['submenu'], $arraydata);
    6) Order => x use for shorting menu
*/

$ADMINMENU['cms'] = array(
    'order'         => 7,
    'parent'        => 'CMS',
    'status'        => 1,
    'link'          => 'cms',
    'icon'          => '<i class="fas fa-tv"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => 'Content',
                    'icon'          => null,
                    'link'          => 'content/page_content',
                    'segment'       => 3,
                    'segment_text'  => 'page_content',
                ),
                '1' => array(
                    'name'          => 'Contact',
                    'icon'          => null,
                    'link'          => 'contact/contact_info',
                    'segment'       => 3,
                    'segment_text'  => 'contact_info',
                ),
                '2' => array(
                    'name'          => 'Client',
                    'icon'          => null,
                    'link'          => 'client/client_list',
                    'segment'       => 3,
                    'segment_text'  => 'client_list',
                ),
                '3' => array(
                    'name'          => 'Service',
                    'icon'          => null,
                    'link'          => 'service/service_list',
                    'segment'       => 3,
                    'segment_text'  => 'service_list',
                ),
                '4' => array(
                    'name'          => 'Testimonial',
                    'icon'          => null,
                    'link'          => 'testimonial/testimonial_list',
                    'segment'       => 3,
                    'segment_text'  => 'testimonial_list',
                ),
                '5' => array(
                    'name'          => 'F.A.Q',
                    'icon'          => null,
                    'link'          => 'faq/faq_list',
                    'segment'       => 3,
                    'segment_text'  => 'faq_list',
                ),
                '6' => array(
                    'name'          => 'News',
                    'icon'          => null,
                    'link'          => 'news/news_list',
                    'segment'       => 3,
                    'segment_text'  => 'news_list',
                ),
                '7' => array(
                    'name'          => 'Category',
                    'icon'          => null,
                    'link'          => 'category/category_list',
                    'segment'       => 3,
                    'segment_text'  => 'category_list',
                ),
                '8' => array(
                    'name'          => 'Slider',
                    'icon'          => null,
                    'link'          => 'slider/slider_list',
                    'segment'       => 3,
                    'segment_text'  => 'slider_list',
                ),
                '9' => array(
                    'name'          => 'Social Link',
                    'icon'          => null,
                    'link'          => 'list/social_link',
                    'segment'       => 3,
                    'segment_text'  => 'social_link',
                ),
                '10' => array(
                    'name'          => 'Advertisement',
                    'icon'          => null,
                    'link'          => 'advertisement/advertisement_list',
                    'segment'       => 3,
                    'segment_text'  => 'advertisement_list',
                ),
                '11' => array(
                    'name'          => 'Language Setting',
                    'icon'          => null,
                    'link'          => 'language/web_language',
                    'segment'       => 3,
                    'segment_text'  => 'web_language',
                )

    ),
    'segment'       => 2,
    'segment_text'  => 'cms'
);