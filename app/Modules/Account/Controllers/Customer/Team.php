<?php 
namespace App\Modules\Account\Controllers\Customer;


class Team extends BaseController
{

    public function index()
    { 
        $user_id = $this->session->userdata('user_id');  
        $data = $this->team_model->my_team($user_id);
        $data['title']   = display('my_generation'); 
        
        $data['content'] = $this->BASE_VIEW . '\team';
        return $this->template->customer_layout($data); 
    }

}
