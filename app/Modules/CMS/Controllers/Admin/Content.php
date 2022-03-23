<?php namespace App\Modules\CMS\Controllers\Admin;

class Content extends BaseController {
 	
	public function index()
	{
            $data['title']  = display('content_list');
            
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $pagewhere = array( 
                'page_content'    => 1
            );
            $data['article'] = $this->common_model->get_all('web_article', $pagewhere,20,($page_number-1)*20,'article_id','DESC');
            $total           = $this->common_model->countRow('web_article',$pagewhere);
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------

             $data['content'] = $this->BASE_VIEW . '\article\list';
            return $this->template->admin_layout($data);
	}
 
	public function form($article_id = null)
	{
            
		$data['title']  = display('add_content');
		$data['web_language'] = $this->language_model->single('1');
                $this->validation->setRule('headline_en', display('headline_en'), 'required|max_length[1000]');
                $this->validation->setRule('cat_id', display('category'), 'required|max_length[10]');
                $this->validation->setRule('position_serial', display('position_serial'), 'required|max_length[10]|trim');
                $this->validation->setRule('article_image', display('article_image'), 'ext_in[article_image,png,jpg,gif,ico],is_image[article_image]');
                
                 if($this->validation->withRequest($this->request)->run()){
                    $img = $this->request->getFile('article_image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/";
                    $old_image = $this->request->getVar('article_image_old', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,300,312);
                    }
                }
		$data['article']   = (object)$userdata = array(
			'article_id'      	=> $this->request->getVar('article_id',FILTER_SANITIZE_STRING),
			'headline_en'   	=> $this->request->getVar('headline_en',FILTER_SANITIZE_STRING),
			'headline_fr' 		=> $this->request->getVar('headline_fr',FILTER_SANITIZE_STRING), 
			'article_image'  	=> (!empty($image)?$image:$this->request->getVar('article_image_old',FILTER_SANITIZE_STRING)), 
			'article1_en' 		=> $this->request->getVar('article1_en'),
			'article1_fr' 		=> $this->request->getVar('article1_fr'),
			'article2_en' 		=> $this->request->getVar('article2_en'),
			'article2_fr' 		=> $this->request->getVar('article2_fr'),
			'video' 		=> $this->request->getVar('video',FILTER_SANITIZE_STRING),
			'cat_id' 		=> $this->request->getVar('cat_id',FILTER_SANITIZE_STRING),
			'page_content' 		=> 1,
			'position_serial' 	=> $this->request->getVar('position_serial',FILTER_SANITIZE_STRING),
			'publish_date' 		=> date("Y-m-d h:i:s",FILTER_SANITIZE_STRING),
			'publish_by' 		=> $this->session->userdata('email',FILTER_SANITIZE_STRING)
		);
		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()) 
		{
                    if (empty($article_id)){
                        if ($this->common_model->insert('web_article',$userdata)){
                                $this->session->setFlashdata('message', display('save_successfully'));
                        }else{
                                $this->session->setFlashdata('exception', display('please_try_again'));
                        }
                        return  redirect()->to(base_url('backend/content/info'));
                    }else{
                        $where = array( 
                            'article_id'            => $article_id
                         );

                        if ($this->common_model->update('web_article',$where,$userdata)) {
                                $this->session->setFlashdata('message', display('update_successfully'));

                        }else{
                                $this->session->setFlashdata('exception', ('please_try_again'));
                        }
                        
                         return  redirect()->to(base_url('backend/content/info/'.$article_id));
                        }
		}else{ 
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/content/info/'.$article_id));
                    }
                    $data['parent_cat']    = $this->common_model->get_all('web_category',$where=array(),null,null,'cat_id','DESC');
                    if(!empty($article_id)){
                        $data['title']     = display('edit_content');
                        $data['article']   = $this->article_model->single($article_id);
                    }
		}
        $data['content'] = $this->BASE_VIEW . '\article\form';
        return $this->template->admin_layout($data);
	}


	public function delete($article_id = null)
	{  
                $where=array(
                    'article_id'  =>   $article_id
                );
                if ($this->common_model->deleteRow('web_article',$where)) {
                    $this->session->setFlashdata('message', display('delete_successfully'));
		} else {
                    $this->session->setFlashdata('exception', display('please_try_again'));
		}
                return  redirect()->to(base_url('backend/content/page_content'));
	}


}
