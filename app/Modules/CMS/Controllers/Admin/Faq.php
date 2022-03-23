<?php namespace App\Modules\CMS\Controllers\Admin;

class FAQ extends BaseController {
 	
 	
 
	public function index()
	{  
            
            $data['title']  = display('faq_list');
            $slug3          = $this->uri->getSegment(2);
            $cat_id         = $this->article_model->catidBySlug($slug3)->cat_id;
            
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $pagewhere = array( 
                  'cat_id'  => $cat_id
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
            $data['title']  = display('add_faq');
            $data['web_language']   = $this->language_model->single('1');
            $slug3                  = $this->uri->getSegment(2);
            $cat_id                 = $this->article_model->catidBySlug($slug3)->cat_id;
            //Set Rules From validation		
            $this->validation->setRule('headline_en', display('headline_en'),'required|max_length[255]');
            $this->validation->setRule('article1_en', display('article1_en'),'required');
            
            $data['article']   = (object)$userdata = array(
                    'article_id'      	=> $this->request->getVar('article_id',FILTER_SANITIZE_STRING),
                    'headline_en'   	=> $this->request->getVar('headline_en',FILTER_SANITIZE_STRING),
                    'headline_fr'   	=> $this->request->getVar('headline_fr',FILTER_SANITIZE_STRING),
                    'article1_en'       => $this->request->getVar('article1_en',FILTER_SANITIZE_STRING),
                    'article1_fr' 	=> $this->request->getVar('article1_fr',FILTER_SANITIZE_STRING),
                    'cat_id' 		=> $cat_id,
                    'publish_date' 	=> date("Y-m-d h:i:s"),
                    'publish_by' 	=> $this->session->userdata('email',FILTER_SANITIZE_STRING)
            );

            //From Validation Check
            if ($this->validation->withRequest($this->request)->run()){
                if (empty($article_id)){
                    if ($this->common_model->insert('web_article',$userdata)){
                        $this->session->setFlashdata('message', display('save_successfully'));
                    }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/faq/info'));
                }else{   
                    $where = array( 
                        'article_id'   => $article_id
                     );
                    if ($this->common_model->update('web_article',$where,$userdata)){
                        $this->session->setFlashdata('message', display('update_successfully'));
                    }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/faq/info/'.$article_id));
                }
            }else{
                $error=$this->validation->listErrors();
                if($this->request->getMethod() == "post"){
                    $this->session->setFlashdata('exception', $error);
                    return  redirect()->to(base_url('backend/faq/info/'.$article_id));
                }
                if(!empty($article_id)){
                    $data['title'] = display('edit_faq');
                    $data['article']   = $this->article_model->single($article_id);
                }
            }

            $data['content'] = $this->BASE_VIEW . '\article\faq';
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
            return  redirect()->to(base_url('backend/faq/faq_list')); 

	}


}
