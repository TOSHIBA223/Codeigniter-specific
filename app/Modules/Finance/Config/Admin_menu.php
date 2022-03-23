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

$ADMINMENU['finance'] = array(
    'order'         => 2,
    'parent'        => 'Finance',
    'status'        => 1,
    'link'          => 'finance',
    'icon'          => '<i class="fa fa-credit-card"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => 'Deposit List',
                    'icon'          => null,
                    'link'          => 'deposit/deposit_list',
                    'segment'       => 3,
                    'segment_text'  => 'deposit_list',
                ),
                '1' => array(
                    'name'          => 'Pending Deposit',
                    'icon'          => null,
                    'link'          => 'deposit/pending_deposit',
                    'segment'       => 3,
                    'segment_text'  => 'pending_deposit',
                ),
                '2' => array(
                    'name'          => 'Withdraw List',
                    'icon'          => null,
                    'link'          => 'withdraw/withdraw_list',
                    'segment'       => 3,
                    'segment_text'  => 'withdraw_list',
                ),
                '3' => array(
                    'name'          => 'Pending Withdraw',
                    'icon'          => null,
                    'link'          => 'withdraw/pending_withdraw',
                    'segment'       => 3,
                    'segment_text'  => 'pending_withdraw',
                ),
                '4' => array(
                    'name'          => 'Add Credit',
                    'icon'          => null,
                    'link'          => 'credit/add_credit',
                    'segment'       => 3,
                    'segment_text'  => 'add_credit',
                ),
                '5' => array(
                    'name'          => 'Credit List',
                    'icon'          => null,
                    'link'          => 'credit/credit_list',
                    'segment'       => 3,
                    'segment_text'  => 'credit_list',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'deposit'
);