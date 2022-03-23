<?php
namespace App\Modules\Exchange\Controllers\Admin;

class Exchange extends BaseController {

 
	public function index()
	{
	     $data['title']  = display('exchange_list');
	     #------------------------
	     #pagination Starts
	     #------------------------
	     $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
	     $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
	     $data['exchange'] = $this->common_model->get_all('ext_exchange', $pagewhere=array(),20,($page_number-1)*20,'ext_exchange_id','asc');
	     $total           = $this->common_model->countRow('ext_exchange');
	     $pagewhere =   array(
	       'status' => 1  
	     );
	     //check active currency
	     $data['currency'] = $this->common_model->get_all('crypto_currency',$pagewhere,null,null,'cid','asc');
	     //find all user
	     $data['userinfo'] = $this->common_model->get_all('user_registration',$where=array(),null,null,'uid','asc');
	     $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
	     #------------------------
	     #pagination ends
	     #------------------------
	     
	      $data['content'] = $this->BASE_VIEW . '\exchange\list';
          return $this->template->admin_layout($data);
	}
 
	public function form($ext_exchange_id = null)
	{ 
		$data['title']    = display('add_exchange');
                 $pagewhere =   array(
                   'status' => 1  
                 );
                 //check active currency
                 $data['currency'] = $this->common_model->get_all('crypto_currency',$pagewhere,null,null,'cid','asc');
		
                 $wherecurrency =   array(
                   'cid' => $this->request->getVar('cid',FILTER_SANITIZE_STRING),
                     'status' => 1  
                 );
                 //check single currency
                $coin = $this->common_model->read('crypto_currency',$wherecurrency);
		if (!empty($coin)) {
			$coin_name = $coin->name;
		}
		else{
			$coin_name='';
		}

		#------------------------#
                 $this->validation->setRule('cid', display('coin_name'),'required');
                $this->validation->setRule('wallet_data', display('wallet_data'),'required');
                $this->validation->setRule('sell_adjustment', display('sell_adjustment'),'required');
                $this->validation->setRule('buy_adjustment', display('buy_adjustment'),'required');
                $this->validation->setRule('status', display('status'),'required');
		/*-----------------------------------*/ 
		$data['exchange']   = (object)$userdata = array(
			'ext_exchange_id'			=> $this->request->getVar('ext_exchange_id',FILTER_SANITIZE_STRING),
			'coin_id'   				=> $this->request->getVar('cid',FILTER_SANITIZE_STRING),
			'coin_name' 				=> $coin_name, 
			'wallet_data'  				=> $this->request->getVar('wallet_data',FILTER_SANITIZE_STRING), 
			'sell_adjustment' 			=> $this->request->getVar('sell_adjustment',FILTER_SANITIZE_STRING),
			'buy_adjustment' 			=> $this->request->getVar('buy_adjustment',FILTER_SANITIZE_STRING),
			'status'                                => $this->request->getVar('status',FILTER_SANITIZE_STRING)
		);

		/*-----------------------------------*/
		
		if(!empty($ext_exchange_id)) {
			$data['title'] = display('exchange');
                        $where=array(
                            'ext_exchange_id' => $ext_exchange_id
                        );
                        $data['exchange'] = $this->common_model->read('ext_exchange',$where);
                     //check exchanger user 
                        $whereuser =   array(
                        'user_id' => $data['exchange']->user_id,
                        'status' => 1  
                     );
                
                $data['userinfo'] =  $this->common_model->read('user_registration',$whereuser);
		}
		$data['content'] = $this->BASE_VIEW . '\exchange\form';
        return $this->template->admin_layout($data);
		
	}


	public function receiveConfirm()
	{  
		$status                     = $this->request->getVar('status',FILTER_SANITIZE_STRING);
		$receving_status            = $this->request->getVar('receving_status',FILTER_SANITIZE_STRING);
		$receving_status_confirm    = $this->request->getVar('receving_status_confirm',FILTER_SANITIZE_STRING);
		$payment_status             = $this->request->getVar('payment_status',FILTER_SANITIZE_STRING);
		$payment_status_confirm     = $this->request->getVar('payment_status_confirm',FILTER_SANITIZE_STRING);

		if ($status) {
			$data['exchange']   = (object)$userdata = array(
				'ext_exchange_id'			=> $this->request->getVar('ext_exchange_id',FILTER_SANITIZE_STRING),
				'status'   					=> 0,
				'receive_status'   			=> 0,
				'payment_status'   			=> 0,
				'receive_by'   				=> $this->session->userdata('email')
			);
            $where=array(
                'ext_exchange_id'=>$userdata->ext_exchange_id
            );
            $this->common_model->update('ext_exchange',$where,$userdata);
		}

		if ($receving_status) {
			if ($receving_status_confirm) {
				$data['exchange']   = (object)$userdata = array(
					'ext_exchange_id'			=> $this->request->getVar('ext_exchange_id',FILTER_SANITIZE_STRING),
					'receive_status'   			=> 1,
					'payment_status'   			=> 0,
					'receive_by'   				=> $this->session->userdata('email')
				);

            $where=array(
                'ext_exchange_id'=>$data['exchange']->ext_exchange_id
            );
                        $this->common_model->update('ext_exchange',$where,$userdata);
			}
		}
		
		if ($payment_status_confirm) {			
			$data['exchange']   = (object)$userdata = array(
				'ext_exchange_id'			=> $this->request->getVar('ext_exchange_id',FILTER_SANITIZE_STRING),
				'status'   				=> 2,
				'payment_status'   			=> 1,
				'payment_by'   				=> $this->session->userdata('email')
			);
            $where=array(
                'ext_exchange_id'=> $data['exchange']->ext_exchange_id
            );
            $this->common_model->update('ext_exchange',$where,$userdata);
		}
	}


}
