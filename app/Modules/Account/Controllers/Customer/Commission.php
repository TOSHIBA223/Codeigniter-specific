<?php 
namespace App\Modules\Account\Controllers\Customer;
class Commission extends BaseController
{

    public function my_payout()
    {   

        $user_id = $this->session->userdata('user_id');
        $data['title']   = display('my_payout'); 
        
        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $pagewhere = array( 
                 'user_id'            => $user_id,
                 'earning_type'    => 'type2'
          );
         $data['my_payout'] = $this->common_model->get_all('earnings', $pagewhere,20,($page_number-1)*20,'earning_id','DESC');
         $total           = $this->common_model->countRow('earnings',$pagewhere);
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------

         $data['content'] = $this->BASE_VIEW . '\my_payout';
        return $this->template->customer_layout($data);
    }

    public function payout_receipt($id=NULL)
    {
        $user_id = $this->session->userdata('user_id');
        $data['title']   = display('receipt'); 
        $builder=$this->db->table('earnings');
        $data['my_payout'] = $builder->select("earnings.*,package.*")
                            ->join('package','package.package_id=earnings.package_id')
                            ->where('earnings.user_id',$user_id)
                            ->where('earnings.earning_type','type2')
                            ->where('earnings.earning_id',$id)
                            ->get()
                            ->getRow();
        $where = array(
            'user_id' => $user_id
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        $data['content'] = $this->BASE_VIEW . '\payout_receipt';
        return $this->template->customer_layout($data);
        
    }

    public function my_commission()
    {   
        $user_id = $this->session->userdata('user_id');
        $data['title'] = display('my_commission');
        
        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $builder        =  $this->db->table('earnings');
         $data['my_commission'] = $builder->select("earnings.*,user_registration.*,package.*")
                                        ->join('user_registration','user_registration.user_id=earnings.Purchaser_id')
                                        ->join('package','package.package_id=earnings.package_id')
                                        ->where('earnings.user_id',$user_id)
                                        ->where('earnings.earning_type','type1')
                                        ->limit(20,($page_number-1)*20)
                                        ->orderBy('earning_id','DESC')
                                        ->get()
                                        ->getResult();
         $total           = $builder->select("earnings.*,user_registration.*,package.*")
                                    ->join('user_registration','user_registration.user_id=earnings.Purchaser_id')
                                    ->join('package','package.package_id=earnings.package_id')
                                    ->where('earnings.user_id',$user_id)
                                    ->where('earnings.earning_type','type1')
                                    ->countAllResults(); 
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------

         $data['content'] = $this->BASE_VIEW . '\my_commission';
        return $this->template->customer_layout($data);
        
    }


    public function commission_receipt($id=NULL)
    {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = display('my_commission'); 
        $builder        =  $this->db->table('earnings');
        $data['my_commission'] = $builder->select("earnings.*,user_registration.*,package.*")
                                        ->join('user_registration','user_registration.user_id=earnings.Purchaser_id')
                                        ->join('package','package.package_id=earnings.package_id')
                                        ->where('earnings.user_id',$user_id)
                                        ->where('earnings.earning_type','type1')
                                        ->where('earnings.earning_id',$id)
                                        ->get()
                                        ->getRow();
        $where = array(
            'user_id' => $user_id
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        
        $data['content'] = $this->BASE_VIEW . '\commission_receipt';
        return $this->template->customer_layout($data);
    }

    public function team_bonus()
    {

        $user_id = $this->session->userdata('user_id');        
        $data['title'] = display('team_bonus');

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $builder        =  $this->db->table('user_level');
         $data['team_bonus'] = $builder->select('user_level.*,setup_commission.*')
                                        ->join('setup_commission','setup_commission.level_name=user_level.level_id','left')
                                        ->where('user_level.user_id',$user_id)
                                        ->limit(20, ($page_number-1)*20)
                                        ->get()
                                        ->getResult();
                    
         $total           = $builder->select('user_level.*,setup_commission.*')
                                    ->join('setup_commission','setup_commission.level_name=user_level.level_id','left')
                                    ->where('user_level.user_id',$user_id)
                                    ->limit(20, ($page_number-1)*20)
                                    ->countAllResults(); 
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------
         
        $data['content'] = $this->BASE_VIEW . '\team_bonus';
        return $this->template->customer_layout($data);
         
    }
    

    public function my_level_info()
    {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = display('my_level_info'); 

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $pagewhere = array( 
                 'user_id'            => $user_id
             );
         $data['level_info'] = $this->common_model->get_all('user_level', $pagewhere,20,($page_number-1)*20,'user_id','DESC');
         $total              = $this->common_model->countRow('user_level',$pagewhere);
         $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------
         $data['content'] = $this->BASE_VIEW . '\my_level_info';
        return $this->template->customer_layout($data);

    }

}