<?php namespace App\Modules\Finance\Controllers\Admin;
class Credit extends BaseController {
	
 
    public function index()
    {
        
        $data['title']  =  display('credit_list');
       
        #-------------------------------#
            #pagination starts
        #-------------------------------#
        $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $pagewhere = array( 
                        'deposit_method'      =>  'admin'
                         );

        $data['credit_info'] = $this->common_model->get_all('deposit', $pagewhere,20,($page_number-1)*20,'deposit_id','DESC');
        $total           = $this->common_model->countRow('deposit');
        $data['pager']   = $this->pager->makeLinks($page_number,20, $total);  
        #------------------------
        #pagination ends
        #------------------------
        
        $data['content'] = $this->BASE_VIEW . '\Credit\credit_list';
        return $this->template->admin_layout($data);
    } 


    public function add_credit()
    {  
        $data['title'] = display('add_credit');

        $data['content'] = $this->BASE_VIEW . '\Credit\add_credit';
        return $this->template->admin_layout($data);
    }

    public function send_credit()
    {
        $validation     =  \Config\Services::validation();
        /*----------FORM VALIDATION RULES----------*/
         $rules = [
                         'user_id'   => [
                            'rules'   => "required",
                            'errors'  => [
                                'required' => 'The User Id is required'
                                 ]
                            ],
                        'amount'   => [
                            'rules'   => "required|numeric",
                            'errors'  => [
                                'required' => 'The Amount field is required',
                                'numeric'  => 'The Amount field only accepts numeric value'
                                 ]
                            ],
                        'note'   => [
                            'rules'   => "required|trim",
                            'errors'  => [
                                'required' => 'The Note Field is required'
                                 ]
                            ]
                    ];

        /*-------------STORE DATA------------*/

        if ($this->validate($rules)) {
            
            $deposit_data = array(
                'user_id'           => $this->request->getVar('user_id',FILTER_SANITIZE_STRING),
                'deposit_amount'    => $this->request->getVar('amount',FILTER_SANITIZE_STRING),
                'deposit_method'    => 'admin',
                'fees'              => 0.0,
                'comments'          => $this->request->getVar('note',FILTER_SANITIZE_STRING),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'status'            => 1
            );
            $insert_deposit=$this->common_model->insert('deposit',$deposit_data);
            
            $db=  db_connect();
            $insert_id = $db->insertID();

            if($insert_id){

                $transections_data = array(
                'user_id'                   => $this->request->getVar('user_id'),
                'transection_category'      => 'deposit',
                'releted_id'                => $insert_id,
                'amount'                    => $this->request->getVar('amount'),
                'comments'                  => $this->request->getVar('note'),
                'transection_date_timestamp'=> date('Y-m-d h:i:s')
                );
                $this->common_model->insert('transections',$transections_data);
            }
            $this->session->setFlashdata('message','Send the amount successfully');
            return  redirect()->to(base_url('backend/credit/add_credit'));

        } else {
            $error=$validation->listErrors();
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $error);
                return  redirect()->to(base_url('backend/credit/add_credit'));
            }
            $data['title'] = display('add_credit');
            
        }
        $data['content'] = $this->BASE_VIEW . '\Credit\add_credit';
        return $this->template->admin_layout($data);
    }


    public function credit_details($id=NULL)
    {

        $data['title'] = display('credit_info');

        $data['credit_info'] = $this->db->table('deposit')->select('deposit.*,
                                user_registration.user_id,
                                user_registration.f_name,
                                user_registration.l_name,user_registration.phone,user_registration.email')
                                ->join('user_registration','user_registration.user_id=deposit.user_id')
                                ->where('deposit.deposit_method','admin')
                                ->where('deposit.deposit_id',$id)
                                ->where('deposit.status',1)
                                ->get()
                                ->getRow(); 
        $data['content'] = $this->BASE_VIEW . '\Credit\credit_details';
        return $this->template->admin_layout($data);

    }


  
	
}
