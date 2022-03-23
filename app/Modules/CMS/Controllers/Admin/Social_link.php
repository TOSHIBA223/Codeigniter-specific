<?php namespace App\Modules\CMS\Controllers\Admin;

class Social_link extends BaseController {
 	
 	
 
	public function index()
	{
            
            $data['title']  = display('social_link');
            
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['social_link']     = $this->common_model->get_all('web_social_link', $pagewhere=array(),20,($page_number-1)*20,'id','DESC');
            $total              = $this->common_model->countRow('web_social_link');
            $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------

            $data['content'] = $this->BASE_VIEW . '\social_link\list';
            return $this->template->admin_layout($data);
		
	}
 
	public function form($id = null)
	{ 
		$data['title']  = display('add_link');

		$data['web_language'] = $this->language_model->single('1');

		//Set Rules From validation
                $this->validation->setRule('name', display('name'),'required|max_length[100]');
                $this->validation->setRule('link', display('link'),'required|max_length[100]');
                $this->validation->setRule('icon', display('icon'),'required|max_length[100]');
		
		$data['social_link']   = (object)$userdata = array(
			'id'      		=> $this->request->getVar('id',FILTER_SANITIZE_STRING),
			'name'   		=> $this->request->getVar('name',FILTER_SANITIZE_STRING),
			'link' 			=> $this->request->getVar('link',FILTER_SANITIZE_STRING), 
			'icon'  		=> $this->request->getVar('icon',FILTER_SANITIZE_STRING), 
			'status' 		=> $this->request->getVar('status',FILTER_SANITIZE_STRING)
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()) 
		{
                    $where = array( 
                        'id'   => $id
                    );
                    if ($this->common_model->update('web_social_link',$where,$userdata)) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/info/social_link/'.$id));
		} 
		else
		{
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/info/social_link/'.$id));
                    }
                    if(!empty($id)) {
                        $data['title'] = display('edit_social_link');
                        $where=array(
                            'id'  => $id
                        );
                        $data['social_link']   = $this->common_model->read('web_social_link',$where);
                    }
			
		}

        $data['content'] = $this->BASE_VIEW . '\social_link\form';
        return $this->template->admin_layout($data);
		
	}

}
