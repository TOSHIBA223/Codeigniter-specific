<?php 
namespace App\Modules\CMS\Controllers\Admin;


class Contact extends BaseController {
 	
 	
	public function index()
	{  
            $data['title']        = display('edit_contact');
            $data['web_language'] = $this->language_model->single('1');
            $slug3                = $this->uri->getSegment(2);
            $cat_id               = $this->article_model->catidBySlug($slug3)->cat_id;
            $article_id           = $this->article_model->articleByCatid($cat_id)->article_id;
            //Set Rules From validation
            $this->validation->setRule('headline_en', display('headline_en'), 'required|max_length[255]');
            $data['article']   = (object)$userdata = array(
                    'article_id'      	=> $this->request->getVar('article_id',FILTER_SANITIZE_STRING),
                    'headline_en'   	=> $this->request->getVar('headline_en',FILTER_SANITIZE_STRING),
                    'headline_fr' 	=> $this->request->getVar('headline_fr',FILTER_SANITIZE_STRING), 
                    'article1_en' 	=> $this->request->getVar('article1_en',FILTER_SANITIZE_STRING),
                    'article1_fr' 	=> $this->request->getVar('article1_fr'),
                    'article2_en' 	=> $this->request->getVar('article2_en'),
                    'cat_id' 		=> $cat_id,
                    'publish_date' 	=> date("Y-m-d h:i:s"),
                    'publish_by' 	=> $this->session->userdata('email',FILTER_SANITIZE_EMAIL)
            );
		//From Validation Check
            if ($this->validation->withRequest($this->request)->run()){
                $where = array( 
                        'article_id'            => $article_id
                 );
                if ($this->common_model->update('web_article',$where,$userdata)){
                        $this->session->setFlashdata('message', display('update_successfully'));
                }else{
                        $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/contact/contact_info'));
            }else{
                if(!empty($article_id)){
                    $data['title'] = display('edit_contact');
                    $data['article']   = $this->article_model->single($article_id);
                }
            }

            $data['content'] = $this->BASE_VIEW . '\article\contact';
            return $this->template->admin_layout($data);
	}


}
