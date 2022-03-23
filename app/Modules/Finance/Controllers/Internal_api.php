<?php namespace App\Modules\Finance\Controllers;
class Internal_api extends BaseController
{



   

    public function gateway()
    { 
        $builder = $this ->db->table('payment_gateway');
        $gateway        = $builder->select('*')
                            ->where('id', 4)
                            ->where('status', 1)
                            ->get()
                            ->getRow();
          
        echo json_encode($gateway);
    }


}