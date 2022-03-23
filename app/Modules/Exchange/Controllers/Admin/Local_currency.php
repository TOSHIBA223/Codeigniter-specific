<?php
namespace App\Modules\Exchange\Controllers\Admin;

class Local_currency extends BaseController {

 
	public function index()
	{
		$data['title']  = display('local_currency');

		#------------------------#
                 $this->validation->setRule('currency_name', display('currency_name'),'required');
                 $this->validation->setRule('currency_iso_code', display('currency_iso_code'),'required');
                 $this->validation->setRule('usd_exchange_rate', display('usd_exchange_rate'),'required');
                 $this->validation->setRule('currency_symbol', display('currency_symbol'),'required');
                 $this->validation->setRule('currency_position', display('currency_position'),'required');

		/*-----------------------------------*/ 
		$data['local_currency']   = (object)$userdata = array(
			'currency_id'      		=> $this->request->getVar('currency_id',FILTER_SANITIZE_STRING),
			'currency_name'   		=> $this->request->getVar('currency_name',FILTER_SANITIZE_STRING),
			'currency_iso_code'             => $this->request->getVar('currency_iso_code',FILTER_SANITIZE_STRING), 
			'usd_exchange_rate'             => $this->request->getVar('usd_exchange_rate',FILTER_SANITIZE_STRING), 
			'currency_symbol' 		=> $this->request->getVar('currency_symbol',FILTER_SANITIZE_STRING),
			'currency_position'             => $this->request->getVar('currency_position',FILTER_SANITIZE_STRING)
		);

		/*-----------------------------------*/
		if ($this->validation->withRequest($this->request)->run()) 
		{
            $where = array(
              'currency_id' => $userdata['currency_id']
            );
                        
			if ($this->common_model->update('local_currency', $where, $userdata)) {
				$this->session->setFlashdata('message', display('update_successfully'));

			} else {
				$this->session->setFlashdata('exception', display('please_try_again'));
				
			}
                        return redirect()->to(base_url("backend/currency/local_currency"));

		} 
		else
		{
			$data['title'] = display('local_currency');
                        $pagewhere = array(
                          'currency_id' => 1
                        );
                        
			$data['local_currency']   = $this->common_model->read('local_currency',$pagewhere);
			
		}
		 $data['content'] = $this->BASE_VIEW . '\local_currency\form';
         return $this->template->admin_layout($data);

	}

}
