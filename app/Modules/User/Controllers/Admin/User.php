<?php 
namespace App\Modules\User\Controllers\Admin;

class User extends BaseController {
 	
 	
 
	public function index()
    {   
        
        $data['title']  = display('user_list');
        $uri = service('uri','<?php echo base_url(); ?>'); 

        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
       
        $total           = $this->common_model->countRow('user_registration');
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        $data['content'] = $this->BASE_VIEW . '\user\list';
        return $this->template->admin_layout($data);
    }

    /*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    public function ajax_list()
    {
        $table = 'user_registration';
        $column_order = array(null, 'user_id','username','sponsor_id','f_name','l_name','email','phone','reg_ip','status','created','modified'); //set column field database for datatable orderable
        $column_search = array('user_id','username','sponsor_id','f_name','l_name','email','phone','reg_ip','status','created','modified'); //set column field database for datatable searchable 

        $order = array('uid' => 'DESC'); // default order   
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order);
        
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $users) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("backend/user/user_details/$users->uid").'">'.$users->user_id.'</a>';
            $row[] = $users->sponsor_id;
            $row[] = '<a href="'.base_url("backend/user/user_details/$users->uid").'">'.$users->f_name." ".$users->l_name.'</a>';
            $row[] = '<a href="'.base_url("backend/user/user_details/$users->uid").'">'.$users->username.'</a>';
            $row[] = $users->email;
            $row[] = $users->phone;
            $row[] = '<a href="'.base_url("backend/users/user_info/$users->uid").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit"></i></a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }


 
    public function form($uid = null)
    { 
            
            $data['title']  = display('add_user');
            if (!empty($uid)){
                $this->validation->setRules(['username' => "required|max_length[100]|username_check[$uid]",'email' => "required|valid_email|max_length[100]|email_check[$uid]"],['username' => [ 'username_check' => 'This Username is already registered.'],'email' => [ 'email_check' => 'This Email is already registered.']]);      

            }else{
                $this->validation->setRule('username', display('username'),'required|is_unique[user_registration.username]|max_length[20]');
                $this->validation->setRule('email', display('email'),'required|valid_email|is_unique[user_registration.email]|max_length[100]');
            } 
            $this->validation->setRule('sponsor_id', display('sponsor_id'),'required|max_length[6]');
            $this->validation->setRule('f_name', display('firstname'),'required|max_length[50]');
            $this->validation->setRule('l_name', display('lastname'),'required|max_length[50]');
            $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');
            $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
            $this->validation->setRule('phone', display('phone'),'required|numeric|max_length[30]');
            $this->validation->setRule('status', display('status'),'required|max_length[1]');

            if (empty($uid)){ 
                $data['user'] = (object)$userdata = array(
                    'uid'         => $this->request->getVar('uid',FILTER_SANITIZE_STRING),
                    'user_id'     => $this->randomID(),
                    'sponsor_id'  => $this->request->getVar('sponsor_id',FILTER_SANITIZE_STRING),
                    'username'    => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'f_name'      => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                    'l_name'      => $this->request->getVar('l_name',FILTER_SANITIZE_STRING),
                    'email'       => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                    'password'    => md5($this->request->getVar('password',FILTER_SANITIZE_STRING)),
                    'phone'       => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                    'reg_ip'      => $this->request->getIPAddress(),
                    'status'      => $this->request->getVar('status',FILTER_SANITIZE_STRING)    
                );
            }else{
                    $data['user']  = (object)$userdata = array(
                    'uid'         => $this->request->getVar('uid',FILTER_SANITIZE_STRING),
                    'user_id'             => $this->request->getVar('user_id',FILTER_SANITIZE_STRING),
                    'sponsor_id'          => $this->request->getVar('sponsor_id',FILTER_SANITIZE_STRING),
                    'username'            => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'f_name'              => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                    'l_name'              => $this->request->getVar('l_name',FILTER_SANITIZE_STRING),
                    'email'               => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                    'password'            => md5($this->request->getVar('password',FILTER_SANITIZE_STRING)),
                    'phone'               => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                    'reg_ip'              => $this->request->getIPAddress(),
                    'status'              => $this->request->getVar('status',FILTER_SANITIZE_STRING)
                    );
            }
                
        if ($this->validation->withRequest($this->request)->run()){
            $db=db_connect();
            $builder=$db->table('user_registration');
            $uid_query = $builder->select('user_id')->where('user_id', $this->request->getVar('sponsor_id'))->get()->getRow();
            if (!$uid_query && $this->request->getVar('sponsor_id')!='0'){
                $this->session->setFlashdata('exception', "Valid Sponsor Id Required");
                return  redirect()->to(base_url("backend/users/user_info"));
            }
            if (empty($uid)){
                if ($this->common_model->insert('user_registration',$userdata)) {
                    $this->session->setFlashdata('message', display('save_successfully'));
                }else{
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/users/user_info'));
            }else{
                $where = array( 
                        'uid'            => $uid
                 );
                if ($this->common_model->update('user_registration',$where,$userdata)) {
                    $this->session->setFlashdata('message', display('update_successfully'));
                } else {
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/users/user_info/'.$uid));
            }
        }
                if(!empty($uid)){
                        $data['title'] = display('edit_user');
                        $data['user']   = $this->user_model->single($uid);
                }
                $data['content'] = $this->BASE_VIEW . '\user\form';
                return $this->template->admin_layout($data);
    }

    public function user_details($uid = null)
    { 
        $data['title']  = display('details');

        if(!empty($uid)) {
            $where = array( 
                 'uid'            => $uid
            );
                
            $data['user']       = $this->common_model->read('user_registration',$where);
           
            

            $pagewhere = array( 
                'user_id'            => $data['user']->user_id
            );
            $data['balance'] =   $this->user_model->get_cata_wais_transections($data['user']->user_id);

        }
        $data['content'] = $this->BASE_VIEW . '\user\user_details';
        return $this->template->admin_layout($data);
    }
    public function deposit_list($user_id = null)
    { 
        $table = 'deposit';
        $column_order = array(null, 'deposit_amount','deposit_method','deposit_date'); //set column field database for datatable orderable
        $column_search = array('deposit_amount','deposit_method','deposit_date');//set column field database for datatable searchable 

        $order = array('deposit_id' => 'DESC'); // default order   
        $where = array('user_id' => $user_id,'status'=>1);
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $deposit) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $deposit->deposit_amount;
            $row[] = $deposit->deposit_method;
            $row[] = $deposit->deposit_date;
            $data[] = $row;
        }

        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table,$where),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function investment_list($user_id = null)
    { 
        $table = 'investment';
        $column_order = array(null, 'order_id','package_id','amount','invest_date'); //set column field database for datatable orderable
        $column_search = array('order_id','package_id','amount','invest_date');//set column field database for datatable searchable 

        $order = array('order_id' => 'DESC'); // default order   
        $where = array('user_id' => $user_id);
        $secondtable = 'package';
        $join = 'investment.package_id=package.package_id';
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where,$join,$secondtable);
        
        $data = array();
        $no = $this->request->getvar('start');

        foreach ($list as $investment) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $investment->order_id;
            $row[] = $investment->package_name;
            $row[] = $investment->amount;
            $row[] = $investment->invest_date;
            $data[] = $row;
        }
        
        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table,$where),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function withdraw_list($user_id = null)
    { 
        $table = 'withdraw';
        $column_order = array(null, 'walletid','amount','fees','success_date'); //set column field database for datatable orderable
        $column_search = array('walletid','amount','fees','success_date');//set column field database for datatable searchable 

        $order = array('withdraw_id' => 'DESC'); // default order   
        $where = array('user_id' => $user_id,'status'=>2);
        
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');

        foreach ($list as $withdraw) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $withdraw->walletid;
            $row[] = $withdraw->amount;
            $row[] = $withdraw->fees;
            $row[] = $withdraw->success_date;
            $data[] = $row;
        }
        
        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table,$where),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
    public function transfer_list($user_id = null)
    { 
        $table = 'transfer';
        $column_order = array(null, 'receiver_user_id','amount','fees','date'); //set column field database for datatable orderable
        $column_search = array('receiver_user_id','amount','fees','date');//set column field database for datatable searchable 

        $order = array('transfer_id' => 'DESC'); // default order   
        $where = array('sender_user_id' => $user_id,'status'=>1);
        
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');

        foreach ($list as $transfer) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $transfer->receiver_user_id;
            $row[] = $transfer->amount;
            $row[] = $transfer->fees;
            $row[] = $transfer->date;
            $data[] = $row;
        }
        
        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table,$where),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
    public function transferreceive_list($user_id = null)
    { 
        $table = 'transfer';
        $column_order = array(null, 'sender_user_id','amount','fees','date'); //set column field database for datatable orderable
        $column_search = array('sender_user_id','amount','fees','date');//set column field database for datatable searchable 

        $order = array('transfer_id' => 'DESC'); // default order   
        $where = array('receiver_user_id' => $user_id,'status'=>1);
        
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');

        foreach ($list as $transfer) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $transfer->sender_user_id;
            $row[] = $transfer->amount;
            $row[] = $transfer->fees;
            $row[] = $transfer->date;
            $data[] = $row;
        }
        
        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table,$where),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
    public function delete($user_id = null)
    {  
        if ($this->user_model->delete($user_id)) {
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("backend/user/user");
    }

    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */
}
