<?php 
namespace App\Modules\Exchange\Controllers\Customer;

class Sell extends BaseController {
 	

 
	public function index()
	{
		$data['title']  = display('sell');
                
                #-------------------------------#
                 #pagination starts
                #-------------------------------#
                 $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
                 $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
                 $pagewhere = array( 
                     'transection_type'            => 'sell'
                 );
                 $data['sell'] = $this->common_model->get_all('ext_exchange', $pagewhere,20,($page_number-1)*20,'ext_exchange_id','ASC');
                 $total           = $this->common_model->countRow('ext_exchange',$pagewhere);
                 $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
                 #------------------------
                 #pagination ends
                 #------------------------
                 $data['content'] = $this->BASE_VIEW . '\sell\list';
                 return $this->template->customer_layout($data);
	}
 
	public function form($sell_id = null)
	{ 
		$data['title']  = display('add_sell');

		$data['payment_gateway'] = $this->common_model->payment_gateway();
		$data['currency'] = $this->sell_model->findExcCurrency();
		$data['selectedlocalcurrency'] = $this->sell_model->findlocalCurrency();
		#------------------------#
                $this->validation->setRule('cid', display('coin_name'),'required');
                $this->validation->setRule('sell_amount', display('sell_amount'),'required');
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
                $this->validation->setRule('document', display('document'), 'ext_in[document,png,jpg,gif,ico,pdf]');
		                
                 if($this->validation->withRequest($this->request)->run()){
                    $img = $this->request->getFile('document',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/document/";
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image=null,51,80);
                         $this->session->setFlashdata('message', display("image_upload_successfully"));
                    }
                }

		$data['sell']   = (object)$userdata = array(
			'coin_id'      			=> $this->request->getVar('cid',FILTER_SANITIZE_STRING),
			'user_id'      			=> $this->session->userdata('user_id'),
			'coin_wallet_id'                => $this->request->getVar('wallet_id',FILTER_SANITIZE_STRING),
			'transection_type'              => "sell",
			'coin_amount'      		=> $this->request->getVar('sell_amount',FILTER_SANITIZE_STRING),
			'usd_amount'      		=> $this->request->getVar('usd_amount',FILTER_SANITIZE_STRING),
			'local_amount'                  => $this->request->getVar('local_amount',FILTER_SANITIZE_STRING),
			'payment_method'                => $this->request->getVar('payment_method',FILTER_SANITIZE_STRING),
			'request_ip'      		=> $this->request->getIpAddress(),
			'verification_code'             => "",
			'payment_details'               => $this->request->getVar('comments',FILTER_SANITIZE_STRING),
			'rate_coin'      		=> $this->request->getVar('rate_coin',FILTER_SANITIZE_STRING),
			'document_status'               => (!empty($image)?1:0),
			'om_name'			=> $this->request->getVar('om_name',FILTER_SANITIZE_STRING),
			'om_mobile'			=> $this->request->getVar('om_mobile',FILTER_SANITIZE_STRING),
			'transaction_no'		=> $this->request->getVar('transaction_no',FILTER_SANITIZE_STRING),
			'idcard_no'			=> $this->request->getVar('idcard_no',FILTER_SANITIZE_STRING),
			'status'      			=> 1
		); 

		if ($this->validation->withRequest($this->request)->run()) 
		{
			if (empty($sell_id)) 
			{
				if ($this->sell_model->create($userdata)) {
					if (!empty($image)) {
						$data['document']   = (object)$documentdata = array(
							'ext_exchange_id'  	=> $this->db->insertId(),
							'doc_url'      		=> (!empty($image)?$image:'')
						);
						$this->sell_model->documentcreate($documentdata);
					}
					
					$this->session->setFlashdata('message', display('save_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
                                return redirect()->to(base_url('customer/sell/payment_form'));
			} 
			else 
			{       
				if ($this->sell_model->update($userdata)) {
					$this->session->setFlashdata('message', display('update_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
                                return redirect()->to(base_url('customer/sell/payment_form/'.$sell_id));
			}
		} 
		else
		{
			if(!empty($sell_id)) {
				$data['title'] = display('edit_sell');
				$data['sell']   = $this->sell_model->single($sell_id);
			}
            
            $data['content'] = $this->BASE_VIEW . '\sell\form';
            return $this->template->customer_layout($data);
		}
	}


	public function sellPayable()
	{ 
		$cid = $this->request->getVar('cid',FILTER_SANITIZE_STRING);
		$amount = $this->request->getVar('sell_amount',FILTER_SANITIZE_STRING);

		$data['selectedcryptocurrency'] = $this->sell_model->findCurrency($cid);
		$data['selectedexccurrency'] = $this->sell_model->findExchangeCurrency($cid);
		$data['selectedlocalcurrency'] = $this->sell_model->findlocalCurrency();
		if (!empty($amount)) {
			$data['price_usd'] 		= $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
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
                $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
            }
		}

        return view($this->BASE_VIEW . '\sell\ajaxpayable',$data);
	}
	
	public function getPercentOfNumber($number, $percent){
    	return ($percent / 100) * $number;
	}


}