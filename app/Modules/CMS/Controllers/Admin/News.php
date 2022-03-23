<?php namespace App\Modules\CMS\Controllers\Admin;

class News extends BaseController {
 	
 	
 
	public function index()
	{  
                  
            $data['title']  = display('news_list');
            $data['web_language'] = $this->language_model->single('1');
 		
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['article'] = $this->common_model->get_all('web_news',$pagewhere=array(),20,($page_number-1)*20,'article_id','DESC');
            $total           = $this->common_model->countRow('web_news');
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------

            $data['content'] = $this->BASE_VIEW . '\article\list';
            return $this->template->admin_layout($data);

	}

 
	public function form($article_id = null)
	{ 
		$data['title']        = display('post_news');
		$data['web_language'] = $this->language_model->single('1');
		//Set Rules From validation
		if (!empty($article_id)) {
                    $this->validation->setRules(['headline_en' => "required|max_length[255]|news_slug_check[$article_id]"],['headline_en' => [ 'news_slug_check' => 'The Headline English is already registered.']]);
		}else{
                    $this->validation->setRule('headline_en', display('headline_en'),'required|is_unique[web_news.headline_en]|max_length[255]');	
		}
		$this->validation->setRule('cat_id', display('category'),'required|max_length[10]');
		$slug = url_title(strip_tags($this->request->getVar('headline_en')), 'dash', TRUE);

		//Set Upload File Config
                 if($this->validation->withRequest($this->request)->run()){
                $img = $this->request->getFile('article_image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/news/";
                    $old_image = $this->request->getVar('article_image_old', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,290,205);
                    }
                }
                

		$data['article']   = (object)$userdata = array(
			'article_id'      	=> $this->request->getVar('article_id', FILTER_SANITIZE_STRING),
			'slug'      		=> $slug,
			'headline_en'   	=> $this->request->getVar('headline_en', FILTER_SANITIZE_STRING),
			'headline_fr' 		=> $this->request->getVar('headline_fr', FILTER_SANITIZE_STRING), 
			'article_image'  	=> (!empty($image)?$image:$this->request->getVar('article_image_old', FILTER_SANITIZE_STRING)), 
			'article1_en' 		=> $this->request->getVar('article1_en'),
			'article1_fr' 		=> $this->request->getVar('article1_fr'),
			'cat_id' 		=> $this->request->getVar('cat_id', FILTER_SANITIZE_STRING),
			'publish_date' 		=> date("Y-m-d h:i:s"),
			'publish_by' 		=> $this->session->userdata('email', FILTER_SANITIZE_STRING),
		);

		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()) 
		{

                    if (empty($article_id)) 
                    {
                        if ($this->common_model->insert('web_news',$userdata)){
                            $this->session->setFlashdata('message', display('save_successfully'));

                        }else{
                             $this->session->setFlashdata('exception', display('please_try_again'));

                        }
                        return  redirect()->to(base_url('backend/news/info'));  
                    }else{
                        $where = array( 
                            'article_id'   => $article_id
                        );
                        if ($this->common_model->update('web_news',$where,$userdata)){
                             $this->session->setFlashdata('message', display('update_successfully'));
                        } else {
                             $this->session->setFlashdata('exception', display('please_try_again'));
                        }
                        return  redirect()->to(base_url('backend/news/info/'.$article_id));
                    }

		}else{ 
                   
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/news/info/'.$article_id));
                    }
                    $parent_where=array(
                      'slug'   => 'news'  
                    );
                        
                    $parent_cat=$this->news_model->parent_cat($parent_where);
                    $child_where=array(
                      'parent_id'   => $parent_cat->cat_id
                    );
                    $child_cat=$this->news_model->child_cat($child_where);
                    $data['child_cat'] = $child_cat;
                    if(!empty($article_id)){
                        $data['title'] = display('edit_news');
                        $data['article']   = $this->news_model->single($article_id);
                   }
		}
                
                $data['content'] = $this->BASE_VIEW . '\news\form';
                return $this->template->admin_layout($data);
                
	}


	public function delete($article_id = null)
	{  
            $where=array(
                'article_id'  =>   $article_id
            );
            if ($this->common_model->deleteRow('web_news',$where)) {
                $this->session->setFlashdata('message', display('delete_successfully'));
            } else {
		$this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/news/news_list'));

	}


}
