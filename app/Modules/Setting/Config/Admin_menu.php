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

$ADMINMENU['setting'] = array(
    'order'         => 5,
    'parent'        => 'Setting',
    'status'        => 1,
    'link'          => 'setting',
    'icon'          => '<i class="fas fa-cog"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => 'App Setting',
                    'icon'          => null,
                    'link'          => 'setting/app_setting',
                    'segment'       => 3,
                    'segment_text'  => 'app_setting',
                ),
                '1' => array(
                    'name'          => 'Fees Setting',
                    'icon'          => null,
                    'link'          => 'setting/fees_setting',
                    'segment'       => 3,
                    'segment_text'  => 'fees_setting',
                ),
                '2' => array(
                    'name'          => 'Comission Setup',
                    'icon'          => null,
                    'link'          => 'setting/commission_setup',
                    'segment'       => 3,
                    'segment_text'  => 'commission_setup',
                ),
                '3' => array(
                    'name'          => 'Email and Sms Setting',
                    'icon'          => null,
                    'link'          => 'setting/email_sms_setting',
                    'segment'       => 3,
                    'segment_text'  => 'email_sms_setting',
                ),
                '4' => array(
                    'name'          => 'Email Gateway',
                    'icon'          => null,
                    'link'          => 'setting/email_gateway',
                    'segment'       => 3,
                    'segment_text'  => 'email_gateway',
                ),
                '5' => array(
                    'name'          => 'SMS Gateway',
                    'icon'          => null,
                    'link'          => 'setting/sms_gateway',
                    'segment'       => 3,
                    'segment_text'  => 'sms_gateway',
                ),
                '6' => array(
                    'name'          => 'SMS/Email Template',
                    'icon'          => null,
                    'link'          => 'setting/smsemail_template',
                    'segment'       => 3,
                    'segment_text'  => 'smsemail_template',
                ),
                '7' => array(
                    'name'          => 'External API',
                    'icon'          => null,
                    'link'          => 'externalapi/api_list',
                    'segment'       => 3,
                    'segment_text'  => 'api_list',
                ),
                '8' => array(
                    'name'          => 'Language Setting',
                    'icon'          => null,
                    'link'          => 'language/language_list',
                    'segment'       => 3,
                    'segment_text'  => 'language_list',
                )

    ),
    'segment'       => 2,
    'segment_text'  => 'setting'
);