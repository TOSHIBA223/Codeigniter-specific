<?php namespace App\Modules\CMS\Controllers\Admin;

class Slider extends BaseController {
 	
 	
 
	public function index()
	{
           
            $data['title']          = display('slider_list');
            $data['web_language']   = $this->language_model->single('1');

            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['slider']     = $this->common_model->get_all('web_slider', $pagewhere=array(),20,($page_number-1)*20,'slider_id','DESC');
            $total              = $this->common_model->countRow('web_slider');
            $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------

            $data['content'] = $this->BASE_VIEW . '\slider\list';
            return $this->template->admin_layout($data);
		
	}
 
	public function form($slider_id = null)
	{ 
            $data['title']  = display('add_slider');
            $data['web_language'] = $this->language_model->single('1');
            //Set Rules From validation
            $this->validation->setRule('slider_h1_en', display('slider_h1_en'),'required|max_length[1000]');
            //upload Image
            if($this->validation->withRequest($this->request)->run()){
            $img = $this->request->getFile('slider_img',FILTER_SANITIZE_STRING);
                $savepath="public/uploads/slider/";
                $old_image = $this->request->getVar('slider_img_old', FILTER_SANITIZE_STRING);
                if($this->request->getMethod() == "post"){
                    $image=$this->imagelibrary->image($img,$savepath,$old_image,1349,750);
                }
            }
           
            $data['slider']   = (object)$sliderdata = array(
                    'slider_id'      	=> $this->request->getVar('slider_id', FILTER_SANITIZE_STRING),
                    'slider_h1_en'   	=> $this->request->getVar('slider_h1_en', FILTER_SANITIZE_STRING),
                    'slider_h1_fr' 	=> $this->request->getVar('slider_h1_fr', FILTER_SANITIZE_STRING), 
                    'slider_h2_en'  	=> $this->request->getVar('slider_h2_en', FILTER_SANITIZE_STRING), 
                    'slider_h2_fr' 	=> $this->request->getVar('slider_h2_fr', FILTER_SANITIZE_STRING),
                    'slider_h3_en' 	=> $this->request->getVar('slider_h3_en', FILTER_SANITIZE_STRING),
                    'slider_h3_fr' 	=> $this->request->getVar('slider_h3_fr', FILTER_SANITIZE_STRING),
                    'slider_img' 	=> (!empty($image)?$image:$this->request->getVar('slider_img_old')),
                    'custom_url' 	=> $this->request->getVar('custom_url', FILTER_SANITIZE_STRING),
                    'status' 		=> $this->request->getVar('status', FILTER_SANITIZE_STRING)
		);

		//From Validation Check
            if ($this->validation->withRequest($this->request)->run()){
                if (empty($slider_id)){
                    if ($this->common_model->insert('web_slider',$sliderdata)){
                        $this->session->setFlashdata('message', display('save_successfully'));
                    }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                        return  redirect()->to(base_url('backend/slider/info'));
                }else{
                    $where = array( 
                        'slider_id'   => $slider_id
                    );
                    if ($this->common_model->update('web_slider',$where,$sliderdata)){
                        $this->session->setFlashdata('message', display('update_successfully'));
                    }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/slider/info/'.$slider_id));
                }
            }else{
                $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/slider/info/'.$slider_id));
                    }
                if(!empty($slider_id)){
                    $data['title']    = display('edit_slider');
                    $where=array(
                        'slider_id' => $slider_id
                    );
                    $data['slider']   = $this->common_model->read('web_slider',$where);
                }
            }

            $data['content'] = $this->BASE_VIEW . '\slider\form';
            return $this->template->admin_layout($data);
	}


	public function delete($slider_id = null)
	{  
             $where=array(
                'slider_id'  =>   $slider_id
            );
            if ($this->common_model->deleteRow('web_slider',$where)) {
                $this->session->setFlashdata('message', display('delete_successfully'));
            } else {
		$this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/slider/slider_list'));
         
	}

}