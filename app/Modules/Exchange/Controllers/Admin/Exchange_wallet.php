<?php
namespace App\Modules\Exchange\Controllers\Admin;

class Exchange_wallet extends BaseController {
 	
 
	public function index()
	{
		$data['title']  = display('exchange_wallet_list');
 		
                #-------------------------------#
                #pagination starts
                #-------------------------------#
                $page                    = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
                $page_number             = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
                $data['exchange_wallet'] = $this->common_model->get_all('ext_exchange_wallet', $pagewhere=array(),20,($page_number-1)*20,'coin_name','ASC');
                $total                   = $this->common_model->countRow('ext_exchange_wallet',$pagewhere=array());
                $data['pager']           = $this->pager->makeLinks($page_number, 20, $total);  
                #------------------------
                #pagination ends
                #------------------------

                $data['content'] = $this->BASE_VIEW . '\exchange_wallet\list';
          		return $this->template->admin_layout($data);
	}
 
	public function form($ext_exchange_wallet_id = null)
	{ 
		$data['title']  = display('add_exchange_wallet');

		$data['currency'] = $this->exchange_wallet_model->activeCurrency();
		$coin = $this->exchange_wallet_model->findCurrency($this->request->getVar('cid',FILTER_SANITIZE_STRING));
		if (!empty($coin)) {
			$coin_name = $coin->name;
		}
		else{
			$coin_name='';
		}
                //check Validation
                $this->validation->setRule('cid', display('coin_name'),'required');
                $this->validation->setRule('wallet_data', display('wallet_data'),'required');
                $this->validation->setRule('sell_adjustment', display('sell_adjustment'),'required');
                $this->validation->setRule('buy_adjustment', display('buy_adjustment'),'required');
                $this->validation->setRule('status', display('status'),'required');
		
		$data['exchange_wallet']   = (object)$userdata = array(
			'ext_exchange_wallet_id'	=> $this->request->getVar('ext_exchange_wallet_id',FILTER_SANITIZE_STRING),
			'coin_id'   				=> $this->request->getVar('cid',FILTER_SANITIZE_STRING),
			'coin_name' 				=> $coin_name, 
			'wallet_data'  				=> $this->request->getVar('wallet_data',FILTER_SANITIZE_STRING), 
			'sell_adjustment' 			=> $this->request->getVar('sell_adjustment',FILTER_SANITIZE_STRING),
			'buy_adjustment' 			=> $this->request->getVar('buy_adjustment',FILTER_SANITIZE_STRING),
			'status' 					=> $this->request->getVar('status',FILTER_SANITIZE_STRING)
		);
		
		if ($this->validation->withRequest($this->request)->run()) 
		{
			if (empty($ext_exchange_wallet_id)){                            
				if ($this->common_model->insert('ext_exchange_wallet',$userdata)) {
					$this->session->setFlashdata('message', display('save_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
                return redirect()->to(base_url("backend/exchange/exchangewallet_info"));

			} else {
                $pagewhere = array(
                    'ext_exchange_wallet_id' => $ext_exchange_wallet_id
                );
				if ($this->common_model->update('ext_exchange_wallet',$pagewhere,$userdata)) {
					$this->session->setFlashdata('message', display('update_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
				return redirect()->to(base_url("backend/exchange/exchangewallet_info/$ext_exchange_wallet_id"));
			}
		}else{ 
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $this->validation->listErrors());
                return redirect()->to(base_url("backend/exchange/exchangewallet_info/$ext_exchange_wallet_id"));
            }
			if(!empty($ext_exchange_wallet_id)) {
				$data['title'] = display('edit_exchange_wallet');
                $where = array(
                    'ext_exchange_wallet_id' => $ext_exchange_wallet_id
                );
				$data['exchange_wallet']   =  $this->common_model->read('ext_exchange_wallet',$where);
			}
		}

		$data['content'] = $this->BASE_VIEW . '\exchange_wallet\form';
        return $this->template->admin_layout($data);
	}


	public function delete($ext_exchange_wallet_id = null)
	{
        $where = array(
            'ext_exchange_wallet_id' => $ext_exchange_wallet_id
        );
              
		if ($this->common_model->deleteRow('ext_exchange_wallet',$where)) {
			$this->session->setFlashdata('message', display('delete_successfully'));
		} else {
			$this->session->setFlashdata('exception', display('please_try_again'));
		}
                
		return redirect()->to(base_url("backend/exchange/exchange_wallet"));
	}


}
