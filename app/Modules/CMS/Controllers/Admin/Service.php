<?php 

namespace App\Modules\CMS\Controllers\Admin;

class Service extends BaseController {
 	
 	
 
	public function index()
	{  

            $data['title']  = display('service_list');
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
		$data['title']        = display('add_service');
		$data['web_language'] = $this->language_model->single('1');
		$slug3                = $this->uri->getsegment(2);
		$cat_id               = $this->article_model->catidBySlug($slug3)->cat_id;

		if (!empty($article_id)){   
                    $this->validation->setRules(['headline_en' => "required|max_length[255]|slug_check[$article_id]"],['headline_en' => [ 'slug_check' => 'The Headline English is already registered.']]);      
		}else{
                     $this->validation->setRule('headline_en', display('headline_en'), 'required|is_unique[web_article.headline_en]|max_length[255]');
		}

		$slug = url_title(strip_tags($this->request->getVar('headline_en')), 'dash', TRUE);
		$data['article']   = (object)$userdata = array(
			'article_id'      	=> $this->request->getVar('article_id',FILTER_SANITIZE_STRING),
			'slug'      		=> $slug,
			'headline_en'   	=> $this->request->getVar('headline_en',FILTER_SANITIZE_STRING),
			'headline_fr' 		=> $this->request->getVar('headline_fr',FILTER_SANITIZE_STRING),
			'article1_en' 		=> $this->request->getVar('article1_en',FILTER_SANITIZE_STRING),
			'article1_fr' 		=> $this->request->getVar('article1_fr',FILTER_SANITIZE_STRING),
			'article2_en' 		=> $this->request->getVar('article2_en',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'article2_fr' 		=> $this->request->getPost('article2_fr'),
			'video' 		=> $this->request->getVar('video',FILTER_SANITIZE_STRING),
			'cat_id' 		=> $cat_id,
			'publish_date' 		=> date("Y-m-d h:i:s"),
			'publish_by' 		=> $this->session->userdata('email')
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()){
                    if (empty($article_id)){
                        if ($this->common_model->insert('web_article',$userdata)){
                            $this->session->setFlashdata('message', display('save_successfully'));
                        }else {
                             $this->session->setFlashdata('exception', display('please_try_again'));
                        }
                        return  redirect()->to(base_url('backend/service/info')); 
                    }else{
                        $where = array( 
                            'article_id'   => $article_id
                        );
                        if ($this->common_model->update('web_article',$where,$userdata)){
                            $this->session->setFlashdata('message', display('update_successfully'));
                        }else{
                            $this->session->setFlashdata('exception', display('please_try_again'));
                       }
                       return  redirect()->to(base_url('backend/service/info/'.$article_id));
                    }
		}else{
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                    }
                    if(!empty($article_id)){
                        $data['title'] = display('edit_service');
                        $data['article']   = $this->article_model->single($article_id);
                    }
		}

        $data['content'] = $this->BASE_VIEW . '\article\service';
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
            return  redirect()->to(base_url('backend/service/service_list')); 

	}


}
