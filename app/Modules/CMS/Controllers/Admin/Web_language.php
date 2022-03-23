<?php namespace App\Modules\CMS\Controllers\Admin;

class Web_language extends BaseController {
 	
 	
	public function index($id = 1)
	{  
		$data['title']  = display('update_website_language');

		//Set Rules From validation
                $this->validation->setRule('name', display('name'),'required|max_length[100]');
                $this->validation->setRule('flag', display('flag'),'required|max_length[10]');

		$data['language'] = (object)$userdata = array(
			'id'			=> $this->request->getVar('id',FILTER_SANITIZE_STRING),
			'name'   		=> $this->request->getVar('name',FILTER_SANITIZE_STRING),
			'flag'   		=> $this->request->getVar('flag',FILTER_SANITIZE_STRING)
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()){
            $where = array( 
                'id'   => $id
            );
            if ($this->common_model->update('web_language',$where,$userdata)) {
                    $this->session->setFlashdata('message', display('update_successfully'));

            } else {
                    $this->session->setFlashdata('exception', display('please_try_again'));

            }
            return  redirect()->to(base_url('backend/language/web_language'));
		} else {
            if(!empty($id)) {
                $data['title'] = display('update_website_language');
                $data['language']   = $this->language_model->single($id);

            }
        }
                
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['countryArray']     = $this->common_model->get_all('dbt_country', $pagewhere=array(),20,($page_number-1)*20,'id','DESC');
            $total              = $this->common_model->countRow('dbt_country');
             $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['content'] = $this->BASE_VIEW . '\article\language';
            return $this->template->admin_layout($data);
		
	}


}
