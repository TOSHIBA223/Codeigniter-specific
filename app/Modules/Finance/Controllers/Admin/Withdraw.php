<?php namespace App\Modules\Finance\Controllers\Admin;

class Withdraw extends BaseController {
 	
 	
	public function index()
	{  
             
            $data['title'] = display('withdraw_list');
            #-------------------------------#
             #pagination starts
            #-------------------------------#
            $page            = ($this->uri->getSegment(4)) ? $this->uri->getSegment(4) : 0;
            $page_number     = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            
            $data['withdraw']   = $this->common_model->get_all('withdraw', $pagewhere=array(),20,($page_number-1)*20,'withdraw_id','DESC');
            //$data['withdraw']= $this->withdraw_model->read(20, $page);
            $total           = $this->common_model->countRow('withdraw');
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['content'] = $this->BASE_VIEW . '\Withdraw\withdraw_list';
            return $this->template->admin_layout($data);
	}


	public function pending_withdraw()
	{
            
            $data['title']  = display('pending_withdraw');
            
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(2)) ? $this->uri->getSegment(2) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $pagewhere = array( 
                    'status'  => 1
                );
            $data['withdraw']   = $this->common_model->get_all('withdraw', $pagewhere,20,($page_number-1)*20,'withdraw_id','DESC');
            $total              = $this->common_model->countRow('withdraw',$pagewhere);
            $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['content'] = $this->BASE_VIEW . '\Withdraw\pending_withdraw';
            return $this->template->admin_layout($data);
            
	}


	public function confirm_withdraw()
	{
        $set_status = 2;
        $user_id    = $_GET['user_id'];
        $id         = $_GET['id'];

        $withdrawdata = $this->db->table('withdraw')->select('*')->where('withdraw_id', $id)->where('user_id', $user_id)->get()->getRow();

        if ($withdrawdata->status == '1') {
            $data = array(
                'success_date' => date('Y-m-d h:is'),
                'status'       => $set_status,
            );
            $updatewhere = array(
                'withdraw_id'   => $id,
                'user_id'       => $user_id
            );
            $this->common_model->update('withdraw',$updatewhere,$data);
            $this->session->setFlashdata('message', display('withdraw_confirm'));

        }else if($withdrawdata->status =='2'){
            $this->session->setFlashdata('exception', display('already_confirmed'));
        }
        else{
            $this->session->setFlashdata('exception', display('already_canceled'));
        }

        
        return redirect()->to('withdraw/withdraw_list');
	}


        public function cancel_withdraw()
        {
            
            $set_status = 3;
            $user_id    = $_GET['user_id'];
            $id         = $_GET['id'];
            $withdrawdata = $this->db->table('withdraw')->select('*')->where('withdraw_id', $id)->where('user_id', $user_id)->get()->getRow();
            if ($withdrawdata->status == '1') {
                $data = array(
                    'cancel_date' => date('Y-m-d h:is'),
                    'status'      => $set_status
                );
                $transactiondata = array(
                    'status'      => 0,
                );
                $where = array(
                    'transection_category'=>'withdraw',
                    'user_id'             => $user_id,
                    'releted_id'          => $id
                            );
                $this->common_model->update('transections',$where,$transactiondata);

                $updatewhere = array(
                    'withdraw_id'   => $id,
                    'user_id'       => $user_id
                );
                $this->common_model->update('withdraw',$updatewhere,$data);

                $this->session->setFlashdata('message', display('withdraw_cancel'));
            }else if($withdrawdata->status =='2'){
                $this->session->setFlashdata('exception', display('already_confirmed'));
            }else{
                $this->session->setFlashdata('exception', display('already_canceled'));
            }
            return redirect()->to('withdraw/withdraw_list');
        }

}
