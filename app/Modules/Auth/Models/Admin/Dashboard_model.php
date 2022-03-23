<?php

namespace App\Modules\Auth\Models\Admin;

class Dashboard_model
{

    public function withdraw_all_request()
    {
        $db      = db_connect();
        $users = $db->table('withdraw');
        return $users->select("*")
            ->where('status', 1)
            ->limit(10)
            ->orderBy('request_date', 'DESC')
            ->get()
            ->getResult();
    }
    public function exchange_all_request()
    {
        $db      = db_connect();
        $users = $db->table('ext_exchange');
        return $users->select("*")
            ->where('status', 1)
            ->limit(10)
            ->orderBy('date_time', 'DESC')
            ->get()
            ->getResult();
    }
    public function crypto_all_request()
    {
        $db      = db_connect();
        $users    = $db->table('crypto_currency');
        return $users->select("cid, name, symbol")
            ->where('status', 1)
            ->get()
            ->getResult();
    }

    public function get_cata_wais_transections()
    {

        $db      = db_connect();
        $users = $db->table('user_registration')->countAll();

        $invest = $db->query("select sum(amount) as invest from investment")->getRow();

        // My Payout
        $earn = $db->query("select sum(amount) as earns from earnings where earning_type ='type2'")->getRow();

        $pay = @$earn->earns;
        $commission = $db->query("select sum(amount) as earns from earnings where earning_type ='type1'")->getRow();
        $pack_commission = @$commission->earns;

        $data = array();
        $data['total_user'] = @$users;
        $data['total_investment'] = @$invest->invest;
        $data['total_roi'] = @$pay;
        $data['commission'] = @$pack_commission;

        return $data;
    }
}