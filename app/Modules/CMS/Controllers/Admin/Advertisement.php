<?php namespace App\Modules\CMS\Controllers\Admin;

class Advertisement extends BaseController {
 	
 	
 
	public function index()
	{
          
        $data['title']  = display('advertisement');

        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $data['advertisement']     = $this->common_model->get_all('advertisement', $pagewhere=array(),20,($page_number-1)*20,'id','DESC');
        $total              = $this->common_model->countRow('advertisement');
        $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        $data['content'] = $this->BASE_VIEW . '\advertisement\list';
        return $this->template->admin_layout($data);
        
	}
 
	public function form($id = null)
	{ 
		$data['title']  = display('add_advertisement');

		//Set Rules From validation
                $this->validation->setRule('page', display('page'),'required|trim');
                $this->validation->setRule('add_type', display('add_type'),'required|trim');
                $this->validation->setRule('serial_position', display('serial_position'),'required|max_length[10]');

		if (!empty($id)) {
                $where=array(
                    'page'              => $this->request->getVar('page',FILTER_SANITIZE_STRING),
                    'serial_position'   => $this->request->getVar('serial_position',FILTER_SANITIZE_STRING),
                    'id !='             => $id
                );
                if ($this->common_model->read('advertisement',$where)){
                    $this->session->setFlashdata('exception', display('already_exists'));
                    return  redirect()->to(base_url('backend/advertisement/info/'.$id));
                }
		}else{
                $where=array(
                    'page'              => $this->request->getVar('page',FILTER_SANITIZE_STRING),
                    'serial_position'   => $this->request->getVar('serial_position',FILTER_SANITIZE_STRING),  
                );
                if($this->common_model->read('advertisement',$where)){
                    $this->session->setFlashdata('exception', display('already_exists'));
                    return  redirect()->to(base_url('backend/advertisement/info'));
                }
		}		
		if ($this->request->getVar('add_type')=='code'){
                    $this->validation->setRule('script', display('script'),'required');
		}
                
                //upload Image
                if($this->validation->withRequest($this->request)->run()){
                $img = $this->request->getFile('image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/slider/";
                    $old_image = $this->request->getVar('image_old', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,728,90);
                    }
                }
		

		$data['advertisement']   = (object)$advertisementdata = array(
			'id'      			=> $this->request->getVar('id',FILTER_SANITIZE_STRING),
			'name'   			=> $this->request->getVar('name',FILTER_SANITIZE_STRING),
			'page' 				=> $this->request->getVar('page',FILTER_SANITIZE_STRING), 
			'image'  			=> (!empty($image)?$image:$this->request->getVar('image_old')),
			'script' 			=> $this->request->getVar('script',FILTER_SANITIZE_STRING),
			'url' 				=> $this->request->getVar('url',FILTER_SANITIZE_STRING),
			'serial_position'               => $this->request->getVar('serial_position',FILTER_SANITIZE_STRING),
			'status' 			=> $this->request->getVar('status',FILTER_SANITIZE_STRING)
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()){
                if (empty($id)){
                    if ($this->common_model->insert('advertisement',$advertisementdata)){
                        $this->session->setFlashdata('message', display('save_successfully'));
                    }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/advertisement/info'));
                }else{
                    $where = array( 
                        'id'   => $id
                    );
                    if ($this->common_model->update('advertisement',$where,$advertisementdata)) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/advertisement/info/'.$id));
                }
		}else{
                $error=$this->validation->listErrors();
                if($this->request->getMethod() == "post"){
                    $this->session->setFlashdata('exception', $error);
                    return  redirect()->to(base_url('backend/advertisement/info/'.$id));
                }
                $data['parent_cat'] = $this->common_model->get_all('web_category',$pagewhere=array(),null,null,'cat_id','Desc');
                if(!empty($id)) {				
                    $data['title'] = display('edit_advertisement');
                    $where =  array(
                        'id' => $id
                    );
                    $data['advertisement']   = $this->common_model->read('advertisement',$where);
                }
		}

        $data['content'] = $this->BASE_VIEW . '\advertisement\form';
        return $this->template->admin_layout($data);
                
	}

	public function delete($id = null)
	{  
            
             $where=array(
                'id'  =>   $id
            );
            if ($this->common_model->deleteRow('advertisement',$where)) {
                $this->session->setFlashdata('message', display('delete_successfully'));
            } else {
		        $this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/advertisement/advertisement_list'));

	}

}