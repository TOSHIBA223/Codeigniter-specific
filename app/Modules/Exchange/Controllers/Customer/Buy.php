<?php 
namespace App\Modules\Exchange\Controllers\Customer;


class Buy extends BaseController {
 	
 
	public function index()
	{
        		$data['currency'] = $this->buy_model->findExcCurrency();
        		$data['title']  = display('buy_list');
 		
                #-------------------------------#
                 #pagination starts
                #-------------------------------#
                 $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
                 $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
                 $pagewhere = array( 
                     'transection_type'            => 'buy'
                 );
                 $data['buy'] = $this->common_model->get_all('ext_exchange', $pagewhere,20,($page_number-1)*20,'ext_exchange_id','ASC');
                 $total           = $this->common_model->countRow('ext_exchange',$pagewhere);
                 $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
                 #------------------------
                 #pagination ends
                 #------------------------

                 $data['content'] = $this->BASE_VIEW . '\buy\list';
                 return $this->template->customer_layout($data);
	}
 
	public function form()
	{ 
		$data['title']  = display('buy');

		if ($this->session->userdata('buy') || $this->session->userdata('deposit')) {
			$this->session->remove('buy');
            $this->session->remove('deposit');
            $this->session->remove('payment_type');
		}

		$data['payment_gateway'] 		= $this->common_model->payment_gateway();
		$data['currency'] 			= $this->buy_model->findExcCurrency();
		$data['selectedlocalcurrency']          = $this->buy_model->findlocalCurrency();
		#------------------------#
        $this->validation->setRule('cid', display('coin_name'),'required');
        $this->validation->setRule('buy_amount', display('buy_amount'),'required');
        $this->validation->setRule('wallet_id', display('wallet_data'),'required');
        $this->validation->setRule('payment_method', display('payment_method'),'required');
        $this->validation->setRule('usd_amount', display('usd_amount'),'required');
        $this->validation->setRule('rate_coin', display('rate_coin'),'required');
        $this->validation->setRule('local_amount', display('local_amount'),'required');

        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='bitcoin' || $this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='payeer') {
            $this->validation->setRule('comments', display('comments'),'required');
        }
        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='phone') {
            $this->validation->setRule('om_name', display('om_name'),'required');
            $this->validation->setRule('om_mobile', display('om_mobile'),'required');
            $this->validation->setRule('transaction_no', display('transaction_no'),'required');
            $this->validation->setRule('idcard_no', display('idcard_no'),'required');
        }

        if (!$this->request->isValidIP($this->request->getIpAddress())){
            return false;
        }

		if ($this->validation->withRequest($this->request)->run()){
                    
			$sdata['buy_save']   = (object)$userdata = array(
				'coin_id'      			        => $this->request->getVar('cid', FILTER_SANITIZE_STRING),
				'user_id'      			        => $this->session->userdata('user_id'),
				'coin_wallet_id'                => $this->request->getVar('wallet_id', FILTER_SANITIZE_STRING),
				'transection_type'              => "buy",
				'coin_amount'      		        => $this->request->getVar('buy_amount', FILTER_SANITIZE_STRING),
				'usd_amount'      		        => $this->request->getVar('usd_amount', FILTER_SANITIZE_STRING),
				'local_amount'                  => $this->request->getVar('local_amount', FILTER_SANITIZE_STRING),
				'payment_method'                => $this->request->getVar('payment_method', FILTER_SANITIZE_STRING),
				'request_ip'      		        => $this->request->getIpAddress(),
				'verification_code'             => "",
				'payment_details'               => $this->request->getVar('comments', FILTER_SANITIZE_STRING),
				'rate_coin'      		        => $this->request->getVar('rate_coin', FILTER_SANITIZE_STRING),
				'document_status'               => 0,
				'om_name'			            => $this->request->getVar('om_name', FILTER_SANITIZE_STRING),
				'om_mobile'			            => $this->request->getVar('om_mobile', FILTER_SANITIZE_STRING),
				'transaction_no'		        => $this->request->getVar('transaction_no', FILTER_SANITIZE_STRING),
				'idcard_no'			            => $this->request->getVar('idcard_no', FILTER_SANITIZE_STRING),
				'status'      			        => 1
			);

			$sdata['buy']   = (object)$userdata = array(
                'deposit_id'   		        => '',
                'user_id'                   => $this->session->userdata('user_id'),
                'deposit_amount'            => $this->request->getVar('usd_amount', FILTER_SANITIZE_STRING),
                'deposit_method'            => $this->request->getVar('payment_method', FILTER_SANITIZE_STRING),
                'fees'                      => 0
            );
            $this->session->set('payment_type','buy');
			$this->session->set($sdata);
            return redirect()->to(base_url('customer/buy/payment_form'));

		}else{
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $this->validation->listErrors());
            }
        }
                
                $data['content'] = $this->BASE_VIEW . '\buy\form';
                 return $this->template->customer_layout($data);

	}


	public function paymentform()
        {

		$data['title']  = display('buy');
		$data['sbuypayment']=$this->session->userdata('buy');
        $method = $this->session->get('buy')->deposit_method;
        
		if (!$this->session->userdata('buy')) {
            return redirect()->to(base_url('customer/buy/buy_form'));
		}
        return redirect()->to(base_url("customer/payment_gateway/$method"));
	}

	public function buyPayable()
	{  

		$cid 	= $this->request->getVar('cid',FILTER_SANITIZE_STRING);
		$amount = $this->request->getVar('buy_amount',FILTER_SANITIZE_STRING);

		$data['selectedcryptocurrency'] = $this->buy_model->findCurrency($cid);
		$data['selectedexccurrency'] 	= $this->buy_model->findExchangeCurrency($cid);
		$data['selectedlocalcurrency'] 	= $this->buy_model->findlocalCurrency();
		if (!empty($amount)) {
			$data['price_usd'] 		= $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;
			$payableusd 			= $data['price_usd']*$amount;
			$data['payableusd']             = $payableusd;
			$data['payablelocal']           = $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
		}
		else{
			$data['payableusd']     = 0;
                        $data['payablelocal']   = 0;
                        if (empty($cid)) {
                            $data['price_usd']  = 0;
                        }else{
                            $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;

                        }

		}
               
        return view($this->BASE_VIEW . '\buy\ajaxpayable',$data);

	}

	public function getPercentOfNumber($number, $percent){
    	return ($percent / 100) * $number;

	} 

}