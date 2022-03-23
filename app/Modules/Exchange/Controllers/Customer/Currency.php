<?php 
namespace App\Modules\Exchange\Controllers\Customer;

class Currency extends BaseController {
 	
        public function index()
	{
                
                $data['title']  = display('cryptocurrency');

                #-------------------------------#
                 #pagination starts
                #-------------------------------#
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
                 return $this->template->customer_layout($data);

	}

}
