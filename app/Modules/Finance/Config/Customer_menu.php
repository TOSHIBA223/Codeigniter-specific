<?php

/*
    **Developed By Bdtask Ltd. (--Blockchain Team--)**

    1) Status 0 = single menu, 1= parent menue with sub menu
    2) Segment and segemnt text use for active menu when click this menu ex:- if(segment==segment_text)?'active':null;
    3) Menu without sub menu ex:-

        i) Do not change :- 'status' => 0

        $CUSTOMERMENU['auth'] = array(
            'parent'        => 'Dashboard',
            'status'        => 0,
            'link'          => 'home',
            'icon'          => '<i class="typcn typcn-home-outline"></i>',
            'segment'       => 2,
            'segment_text'  => 'home'
        );

    4) Menu with sub menu ex:-

        i) Do not change :- 'status' => 1

        $CUSTOMERMENU['auth'] = array(
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
        array_push($CUSTOMERMENU['auth']['submenu'], $arraydata);
    6) Order => x use for shorting menu
*/

$CUSTOMERMENU['finance'] = array(
    'order'         => 3,
    'parent'        => 'Finance',
    'status'        => 1,
    'icon'          => '<i class="fas fa-chart-pie"></i>',
    'submenu'       => array(
        '0' => array(
                    'name'          => 'Add Deposit',
                    'icon'          => null,
                    'link'          => 'deposit/add_deposit',
                    'segment'       => 3,
                    'segment_text'  => 'add_deposit',
        ),
        '1' => array(
                    'name'          => 'Deposit List',
                    'icon'          => null,
                    'link'          => 'deposit/show_list',
                    'segment'       => 3,
                    'segment_text'  => 'show_list',
        ),
        '2' => array(
                    'name'          => 'Withdraw',
                    'icon'          => null,
                    'link'          => 'withdraw/withdraw_money',
                    'segment'       => 3,
                    'segment_text'  => 'withdraw_money',
        ),
        '3' => array(
                    'name'          => 'Withdraw List',
                    'icon'          => null,
                    'link'          => 'withdraw/withdraw_list',
                    'segment'       => 3,
                    'segment_text'  => 'withdraw_list',
        ),
        '4' => array(
                    'name'          => 'Transfer',
                    'icon'          => null,
                    'link'          => 'transfer/transfer_amount',
                    'segment'       => 3,
                    'segment_text'  => 'transfer_amount',
        ),
        '5' => array(
                    'name'          => 'Transfer List',
                    'icon'          => null,
                    'link'          => 'transfer/transfer_list',
                    'segment'       => 3,
                    'segment_text'  => 'transfer_list',
        )
    ),
    'segment'       => 2,
    'segment_text'  => 'finance'
);

$CUSTOMERMENU['transaction'] = array(
    'order'         => 5,
    'parent'        => 'Transaction',
    'status'        => 0,
    'link'          =>'transection/transection_list',
    'icon'          => '<i class="fas fa-exchange-alt"></i>',
    'segment'       => 3,
    'segment_text'  => 'transection_list'
);
