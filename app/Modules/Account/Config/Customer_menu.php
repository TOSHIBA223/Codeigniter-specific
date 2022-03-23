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

$CUSTOMERMENU['account'] = array(
    'order'         => 2,
    'parent'        => 'Account',
    'status'        => 1,
    'icon'          => '<i class="fa fa-key"></i>',
    'submenu'       => array(
        '0' => array(
                    'name'          => 'My Payout',
                    'icon'          => null,
                    'link'          => 'account/my_payout',
                    'segment'       => 3,
                    'segment_text'  => 'my_payout',
        ),
        '1' => array(
                    'name'          => 'My Commission',
                    'icon'          => null,
                    'link'          => 'account/my_commission',
                    'segment'       => 3,
                    'segment_text'  => 'my_commission',
        ),
        '2' => array(
                    'name'          => 'Team Bonus',
                    'icon'          => null,
                    'link'          => 'account/team_bonus',
                    'segment'       => 3,
                    'segment_text'  => 'team_bonus',
        ),
        '3' => array(
                    'name'          => 'My Generation',
                    'icon'          => null,
                    'link'          => 'account/my_generation',
                    'segment'       => 3,
                    'segment_text'  => 'my_generation',
        ),
        '4' => array(
                    'name'          => 'My Level Info',
                    'icon'          => null,
                    'link'          => 'account/mylevel_info',
                    'segment'       => 3,
                    'segment_text'  => 'mylevel_info',
        )
    ),
    'segment'       => 2,
    'segment_text'  => 'account'
);