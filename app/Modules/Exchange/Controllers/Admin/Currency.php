<?php
namespace App\Modules\Exchange\Controllers\Admin;

class Currency extends BaseController {
 	
 
	public function index()
	{
		$data['title']  = display('cryptocurrency');
 	
                #------------------------
                 #pagination Starts
                #------------------------
                 $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
                 $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
                 
                 $data['localcurrency'] = $this->currency_model->findlocalCurrency();
                 $data['currency'] = $this->common_model->get_all('crypto_currency', $pagewhere=array(),20,($page_number-1)*20,'rank','ASC');
                 $total           = $this->common_model->countRow('crypto_currency',$pagewhere=array());
                 $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
                 #------------------------
                 #pagination ends
                 #------------------------
                 $data['content'] = $this->BASE_VIEW . '\currency\list';
        		 return $this->template->admin_layout($data);

	}
 
	public function form($cid = null)
	{ 
		$data['title']  = display('cryptocurrency');

		//Set Rules From validation
                $this->validation->setRule('status', display('status'),'required|max_length[1]');
		
		$data['currency']   = (object)$userdata = array(
			'cid'      	=> $this->request->getVar('cid',FILTER_SANITIZE_STRING),
			'status' 	=> $this->request->getVar('status',FILTER_SANITIZE_STRING)
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()) 
		{
			if (empty($cid)) 
			{
                                
				if ($this->common_model->insert('crypto_currency',$userdata)) {
					$this->session->setFlashdata('message', display('save_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
                                return redirect()->to(base_url("backend/currency/currency_info"));
			} 
			else 
			{
                                $where = array(
                                    'cid' => $cid
                                );
                                
				if ($this->common_model->update('crypto_currency',$where,$userdata)) {
					$this->session->setFlashdata('message', display('update_successfully'));
				} else {
					$this->session->setFlashdata('exception', display('please_try_again'));
				}
				return redirect()->to(base_url("backend/currency/currency_list"));
			}
		} 
		else
		{
			if(!empty($cid)) {
				$data['title'] = display('edit_currency');
                                $pagewhere = array(
                                  'cid' => $cid  
                                );
				$data['currency']   = $this->common_model->read('crypto_currency',$pagewhere);
			}
		}
		$data['content'] = $this->BASE_VIEW . '\currency\form';
        return $this->template->admin_layout($data);
	}
	
}
