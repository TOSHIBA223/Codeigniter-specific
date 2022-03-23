<?php
namespace App\Modules\Website\Controllers;

class Home extends BaseController 
{
    
    
    public function index()
    {
       
        $data['service']     = $this->web_model->article($this->web_model->catidBySlug('service')->cat_id, 8);
        @$cat_id = $this->web_model->catidBySlug('home');

        //Language setting
        $data['lang']         = $this->langSet();
        $data['title']        = "Home";
        @$data['news']        = $this->common_model->get_all('web_news',$where=array(),0,8,'article_id','DESC');
        
        @$data['client']      = $this->web_model->article($this->web_model->catidBySlug('client')->cat_id);
        $builder              = $this->db->table('cryptolist');
        @$data['cryptocoins'] = $builder->select("Id, Url, ImageUrl, Name, Symbol,CoinName,FullName")->orderBy('SortOrder', 'asc')->limit(10,0)->get()->getResult();
        @$data['testimonial'] = $this->web_model->article($this->web_model->catidBySlug('testimonial')->cat_id);
        @$data['about']       = $this->web_model->article($this->web_model->catidBySlug('about')->cat_id);
        $data['article']      = $this->web_model->article($cat_id->cat_id);
        $data['slider']       = $this->web_model->active_slider();

        $cryptoapi              = $this->web_model->findById('external_api_setup', array('id'=>3));
        $apijson                = json_decode($cryptoapi->data);
        $data['crypto_api_key'] = $apijson->api_key;

        $data['content']        = view('themes/'.$this->templte_name->name.'/index',$data);
        return $this->template->website_layout($data);

    }

    public function lending()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']       = $this->langSet();  

        $data['title']      = $this->uri->getSegment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->getSegment(1));
        $data['package']    = $this->web_model->package();
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/lending',$data);
        return $this->template->website_layout($data);
        
    }

    public function coinmarket()
    {
        
        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']           = $this->langSet();        

        $data['title']          = $this->uri->getSegment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->getSegment(1));

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(2)) ? $this->uri->getSegment(2) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $data['cryptocoins'] = $this->common_model->get_all('cryptolist', $pagewhere=array(),20,($page_number-1)*20,'SortOrder','ASC');
         $total           = $this->common_model->countRow('cryptolist',$pagewhere=array());
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------
        $data['content']        = view('themes/'.$this->templte_name->name.'/coinmarket',$data);
        return $this->template->website_layout($data);
        
    }

    public function exchange()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']           = $this->langSet();
        
        $data['title']          = $this->uri->getSegment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->getSegment(1));
        $changellyinfo          = $this->web_model->findById("external_api_setup", array('id'=>2));
        if(!empty($changellyinfo) && $changellyinfo->data){
            $json               = json_decode($changellyinfo->data);
            $data['marcent_id'] = $json->api_key;
        }

        $data['content']        = view('themes/'.$this->templte_name->name.'/exchange',$data);
        return $this->template->website_layout($data);
        
    }

    public function contact()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']       = $this->langSet();
        
        $data['title']      = $this->uri->getSegment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->getSegment(1));
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/contact',$data);
        return $this->template->website_layout($data);
     
    }

    public function buy()
    {

        if ($this->session->userdata('buy')) {
            $this->session->remove('buy');
        }

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']                   = $this->langSet();

        $data['title']                  = $this->uri->getSegment(1);
        $data['article']                = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']               = $this->web_model->cat_info($this->uri->getSegment(1));
        $data['payment_gateway']        = $this->common_model->payment_gateway();
        $data['currency']               = $this->buy_model->findExcCurrency();
        $data['selectedlocalcurrency']  = $this->buy_model->findlocalCurrency();

        //Set Rules From validation
        $this->validation->setRule('cid', display('coin_name'),'required');
        $this->validation->setRule('buy_amount', display('buy_amount'),'required');
        $this->validation->setRule('wallet_id', display('wallet_data'),'required');
        $this->validation->setRule('payment_method', display('payment_method'),'required');
        $this->validation->setRule('usd_amount', display('usd_amount'),'required');
        $this->validation->setRule('rate_coin', display('rate_coin'),'required');
        $this->validation->setRule('local_amount', display('local_amount'),'required');

        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='bitcoin' || $this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='payeer') {
            $this->validation->setRule('comments', display('comments'),'required');
        }
        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='phone') {
            $this->validation->setRule('om_name', display('om_name'),'required');
            $this->validation->setRule('om_mobile', display('om_mobile'),'required');
            $this->validation->setRule('transaction_no', display('transaction_no'),'required');
            $this->validation->setRule('idcard_no', display('idcard_no'),'required');
        }
        

        //Validation Check confirm then Redirect to Payment
        if ($this->validation->withRequest($this->request)->run()) 
        {
            if (!$this->request->isValidIP($this->request->getIpAddress())){
                $this->session->setFlashdata('exception', display("ip_address")." Invalid");
                 return  redirect()->to(base_url('buy'));

            }


            $sdata['buy']   = (object)$userdata = array(
                'coin_id'               => $this->request->getVar('cid',FILTER_SANITIZE_STRING),
                'user_id'               => $this->session->userdata('user_id'),
                'coin_wallet_id'        => $this->request->getVar('wallet_id',FILTER_SANITIZE_STRING),
                'transection_type'      => "buy",
                'coin_amount'           => $this->request->getVar('buy_amount',FILTER_SANITIZE_STRING),
                'usd_amount'            => $this->request->getVar('usd_amount',FILTER_SANITIZE_STRING),
                'local_amount'          => $this->request->getVar('local_amount',FILTER_SANITIZE_STRING),
                'payment_method'        => $this->request->getVar('payment_method',FILTER_SANITIZE_STRING),
                'request_ip'            => $this->request->getIPAddress(),
                'verification_code'     => "",
                'payment_details'       => $this->request->getVar('comments',FILTER_SANITIZE_STRING),
                'rate_coin'             => $this->request->getVar('rate_coin',FILTER_SANITIZE_STRING),
                'document_status'       => 0,
                'om_name'               => $this->request->getVar('om_name',FILTER_SANITIZE_STRING),
                'om_mobile'             => $this->request->getVar('om_mobile',FILTER_SANITIZE_STRING),
                'transaction_no'        => $this->request->getVar('transaction_no',FILTER_SANITIZE_STRING),
                'idcard_no'             => $this->request->getVar('idcard_no',FILTER_SANITIZE_STRING),
                'status'                => 1
            );

            $sdata['deposit']   = (object)$userdata = array(
                'deposit_id'        => '',
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->request->getVar('usd_amount', FILTER_SANITIZE_STRING),
                'deposit_method'    => $this->request->getVar('payment_method', FILTER_SANITIZE_STRING),
                'fees'              => 0
            );

            $this->session->set($sdata);
            return  redirect()->to(base_url('paymentform'));
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
        }       

    
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/buy',$data);
        return $this->template->website_layout($data);
        
    }

    public function sells()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']                   = $this->langSet();
        
        $data['title']                  = $this->uri->getSegment(1);
        $data['article']                = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']               = $this->web_model->cat_info($this->uri->getSegment(1));
        $data['payment_gateway']        = $this->common_model->payment_gateway();
        $data['currency']               = $this->sell_model->findExcCurrency();
        $data['selectedlocalcurrency']  = $this->sell_model->findlocalCurrency();

        //Set Rules From validation
        $this->validation->setRule('cid', display('coin_name'),'required');
        $this->validation->setRule('sell_amount', display('sell_amount'),'required');
        $this->validation->setRule('wallet_id', display('wallet_data'),'required');
        $this->validation->setRule('payment_method', display('payment_method'),'required');
        $this->validation->setRule('usd_amount', display('usd_amount'),'required');
        $this->validation->setRule('rate_coin', display('rate_coin'),'required');
        $this->validation->setRule('local_amount', display('local_amount'),'required');

        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='bitcoin' || $this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='payeer') {
            $this->validation->setRule('comments', display('comments'),'required');
        }
        if ($this->request->getVar('payment_method',FILTER_SANITIZE_STRING)=='phone') {
            $this->validation->setRule('om_name', display('om_name'),'required');
            $this->validation->setRule('om_mobile', display('om_mobile'),'required');
            $this->validation->setRule('transaction_no', display('transaction_no'),'required');
            $this->validation->setRule('idcard_no', display('idcard_no'),'required');
        }  
        //Set Upload File Config 
        $this->validation->setRule('document', display('document'), 'ext_in[document,png,jpg,gif,ico,pdf]');
        if($this->validation->withRequest($this->request)->run()){
            $img = $this->request->getFile('document',FILTER_SANITIZE_STRING);
            $savepath="public/uploads/document/";
            if($this->request->getMethod() == "post"){
                $image=$this->imagelibrary->image($img,$savepath,$old_image=null,51,80);
                 $this->session->setFlashdata('message', display("image_upload_successfully"));
            }
        }
        
        $data['sell']   = (object)$userdata = array(
            'coin_id'               => $this->request->getVar('cid',FILTER_SANITIZE_STRING),
            'user_id'               => $this->session->userdata('user_id'),
            'coin_wallet_id'                => $this->request->getVar('wallet_id',FILTER_SANITIZE_STRING),
            'transection_type'              => "sell",
            'coin_amount'           => $this->request->getVar('sell_amount',FILTER_SANITIZE_STRING),
            'usd_amount'            => $this->request->getVar('usd_amount',FILTER_SANITIZE_STRING),
            'local_amount'                  => $this->request->getVar('local_amount',FILTER_SANITIZE_STRING),
            'payment_method'                => $this->request->getVar('payment_method',FILTER_SANITIZE_STRING),
            'request_ip'            => $this->request->getIpAddress(),
            'verification_code'             => "",
            'payment_details'               => $this->request->getVar('comments',FILTER_SANITIZE_STRING),
            'rate_coin'             => $this->request->getVar('rate_coin',FILTER_SANITIZE_STRING),
            'document_status'               => (!empty($image)?1:0),
            'om_name'           => $this->request->getVar('om_name',FILTER_SANITIZE_STRING),
            'om_mobile'         => $this->request->getVar('om_mobile',FILTER_SANITIZE_STRING),
            'transaction_no'        => $this->request->getVar('transaction_no',FILTER_SANITIZE_STRING),
            'idcard_no'         => $this->request->getVar('idcard_no',FILTER_SANITIZE_STRING),
            'status'                => 1
        ); 

        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()) {
            
            if (!$this->request->isValidIp($this->request->getIpAddress())){
                $this->session->setFlashdata('exception', display("ip_address")." Invalid");
                return  redirect()->to(base_url('sells'));
            }
            if (empty($this->session->userdata('user_id'))) {
                return  redirect()->to(base_url('register#tab2'));
            }

            if ($this->sell_model->create($userdata)) {
                if (!empty($image)) {
                    $data['document'] = (object)$documentdata = array(
                        'ext_exchange_id'   => $this->db->insertId(),
                        'doc_url'           => (!empty($image)?$image:'')

                    );
                    $this->sell_model->documentcreate($documentdata);

                }
                $this->session->setFlashdata('message', display('sell_successfully'));

            }else {
                $this->session->setFlashdata('exception', display('please_try_again'));

            }
            return  redirect()->to(base_url('sells'));

        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
        }
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/sell',$data);
        return $this->template->website_layout($data);
        
    }

    public function price()
    {
            $data['web_language'] = $this->web_model->webLanguage();
            $data['social_link']  = $this->web_model->social_link();
            $data['category']     = $this->web_model->categoryList();
            $data['service']     = $this->web_model->article($this->web_model->catidBySlug('service')->cat_id, 8);

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = $this->uri->getSegment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        @$data['newscat']       = $this->web_model->newsCatListBySlug('news');
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->getSegment(1));
        $builder = $this->db->table('web_news');
        $data['news']           = $builder->select("*")->orderBy('article_id', 'desc')->limit(6, 3)->get()->getResult();
        $data['recentnews']     = $builder->select("*")->orderBy('article_id', 'desc')->limit(3)->get()->getResult();

        $cryptoapi  = $this->web_model->findById('external_api_setup', array('id'=>3));
        $apijson = json_decode($cryptoapi->data);
        $data['crypto_api_key'] = $apijson->api_key;
        
        $data['newcontent']        = view("themes/".$this->templte_name->name."/sidebar", $data);
        $data['content']        = view('themes/'.$this->templte_name->name.'/price',$data);
        return $this->template->website_layout($data);
        
    }

    public function about()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = $this->uri->getSegment(1);        
        @$data['client']           = $this->web_model->article($this->web_model->catidBySlug('client')->cat_id);
        @$data['team']           = $this->web_model->article($this->web_model->catidBySlug('team')->cat_id);
        @$data['testimonial']    = $this->web_model->article($this->web_model->catidBySlug('testimonial')->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->getSegment(1));
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/about',$data);
        return $this->template->website_layout($data);
        
    }

    public function service($slug=NULL)
    {   

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']                   = $this->langSet();

        $data['title']                  = $this->uri->getSegment(1);

        if ($slug=="" || $slug==NULL) {
            $data['article']            = $this->web_model->article($cat_id->cat_id);
            $data['cat_info']           = $this->web_model->cat_info($this->uri->getSegment(1)); 
            
            $data['content']        = view('themes/'.$this->templte_name->name.'/service',$data);
            return $this->template->website_layout($data);

        }else{
            $data['cat_info']           = $this->web_model->cat_info($this->uri->getSegment(1));
            $data['service_details']    = $this->web_model->contentDetails($this->uri->getSegment(2));
            
            $data['content']        = view('themes/'.$this->templte_name->name.'/service-details',$data);
            return $this->template->website_layout($data);

        }
        
    }

    public function news()
    {

        $slug1 = $this->uri->getSegment(1);
        $slug2 = $this->uri->getSegment(2);
        $slug3 = $this->uri->setSilent()->getSegment(3);

        //Language setting
        $data['lang']               = $this->langSet();

        $data['title']              = $this->uri->getSegment(1);

        //For Coin Tricker
        $data['cryptocoins']        = $this->web_model->cryptoCoin(10, 0);
        $data['recentnews']         = $this->db->table('web_news')->select("*")->orderBy('article_id', 'desc')->limit(3)->get()->getResult();
        
        $data['web_language'] = $this->web_model->webLanguage();
        $data['social_link']  = $this->web_model->social_link();
        $data['category']     = $this->web_model->categoryList();
        $data['service']     = $this->web_model->article($this->web_model->catidBySlug('service')->cat_id, 8);

            
        if ($slug2=="" || $slug2==NULL || is_numeric($slug2)) {

            //All Category News with Pagination
            $cat_id     = $this->web_model->catidBySlug($slug1)->cat_id;
            $where_add  = $this->web_model->catidBySlug('news')->cat_id;

            
            #-------------------------------#
            #pagination starts
           #-------------------------------#
            $page           = ($this->uri->getSegment(2)) ? $this->uri->getSegment(2) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['news'] = $this->common_model->get_all('web_news', $pagewhere=array(),5,($page_number-1)*5,'article_id','DESC');
            $total           = $this->common_model->countRow('web_news',$pagewhere=array());
            $data['pager']   = $this->pager->makeLinks($page_number, 5, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['advertisement']  = $this->web_model->advertisement($where_add);
            $data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            
            $data['newcontent']        = view("themes/".$this->templte_name->name."/sidebar", $data);
            $data['content']        = view('themes/'.$this->templte_name->name.'/blog',$data);
            return $this->template->website_layout($data);

        }
        elseif (($slug2!="" || !is_numeric($slug2)) && ($slug3=="" || $slug3==NULL)) {

            @$where_add  = $this->web_model->catidBySlug('news')->cat_id;

            //Slug Category News
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
            
            #-------------------------------#
            #pagination starts
           #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $pagewhere = array(
                'cat_id' => $cat_id
            );
            $data['news'] = $this->common_model->get_all('web_news', $pagewhere,20,($page_number-1)*20,'article_id','DESC');
            $total           = $this->common_model->countRow('web_news',$pagewhere);
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['advertisement']      = $this->web_model->advertisement($where_add);
            @$data['newscat']            = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']           = $this->web_model->cat_info($slug1);
            $data['newcontent']        = view("themes/".$this->templte_name->name."/sidebar", $data);
            
            $data['content']        = view('themes/'.$this->templte_name->name.'/blog',$data);
            return $this->template->website_layout($data);
        }
        elseif ($slug3=="" || $slug3==NULL || is_numeric($slug3)) {

            @$where_add  = $this->web_model->catidBySlug('news')->cat_id;

            //Slug Category News with Pagination
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
           
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $pagewhere = array(
                'cat_id' => $cat_id
            );
            $data['news'] = $this->common_model->get_all('web_news', $pagewhere,20,($page_number-1)*20,'article_id','DESC');
            $total           = $this->common_model->countRow('web_news',$pagewhere);
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['advertisement']  = $this->web_model->advertisement($where_add);
            @$data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            $data['newcontent']        = view("themes/".$this->templte_name->name."/sidebar", $data);
            $data['content']        = view('themes/'.$this->templte_name->name.'/blog',$data);
            return $this->template->website_layout($data);

        }
        elseif ($slug3!="" || !is_numeric($slug3)) {
            //Slug Category News detail
 
            $where_add = $this->web_model->catidBySlug('news-details')->cat_id;
            $data['advertisement']  = $this->web_model->advertisement($where_add);

            @$data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['article']        = $this->web_model->article($slug1);
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            $data['news']           = $this->web_model->newsDetails($slug3);
            
            $data['newcontent']        = view("themes/".$this->templte_name->name."/sidebar", $data);
            $data['content']        = view('themes/'.$this->templte_name->name.'/blog-details',$data);
            return $this->template->website_layout($data);
            
        }
        
    }
    
    public function faq()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']       = $this->langSet();

        $data['title']      = $this->uri->getSegment(1);        
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->getSegment(1));
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/faq',$data);
        return $this->template->website_layout($data);
        
    }

    public function register()
    {
        
        if ($this->session->userdata('isLogIn'))
            return redirect()->to(base_url('home'));

        helper('text');
        $cat_id = $this->web_model->catidBySlug($this->uri->getSegment(1));

        //Language setting
        $data['lang']       = $this->langSet();
        $lang               = $this->langSet();

        $data['title']      = $this->uri->getSegment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->getSegment(1));

        //Set Rules From validation
        $this->validation->setRule('f_name', display('firstname'),'required|alpha_space|max_length[50]');
        $this->validation->setRule('l_name', display('lastname'),'required|alpha_space|max_length[50]');
        $this->validation->setRule('username', display('username'),'required|alpha_numeric|max_length[50]');
        $this->validation->setRule('email', display('email'),'required|valid_email|max_length[100]');
        $this->validation->setRule('pass', display('password'),'required|min_length[8]|max_length[32]|matches[r_pass]');
        $this->validation->setRule('r_pass', display('password'),'required|max_length[32]');
        $this->validation->setRule('phone', display('mobile'),'max_length[100]|numeric');
        $this->validation->setRule('accept_terms', display('accept_terms_privacy'),'required');

        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()) {
            
            $sponsor_user_id = $this->db->table('user_registration')->select('user_id')->where('user_id', $this->request->getCookie('sponsor_id'))->get()->getRow();

            if (!$sponsor_user_id){
                $this->session->setFlashdata('exception', "Valid Sponsor ID Required");
                redirect()->to(base_url('register#tab2'));
                return false;
            }

            $dlanguage = $this->db->table('setting')->select('language')->get()->getRow();
            $data = array();
            $data = [
                'username'  => $this->request->getVar('username',FILTER_SANITIZE_STRING),                
                'email'     => $this->request->getVar('email',FILTER_SANITIZE_EMAIL)
            ];
            
            $usercheck=$this->web_model->checkUser($data);
            if (!empty($usercheck->getRow())) {
                
                if ($usercheck->getRow()->oauth_provider=='facebook' && $usercheck->getRow()->status==0 || $usercheck->getRow()->oauth_provider=='google' && $usercheck->getRow()->status==0) {

                    $checkDuplictuser = $this->web_model->checkDuplictuser($data);    
                    if (!empty($checkDuplictuser)){
                        $this->session->setFlashdata('exception', display('username_used'));
                        return redirect()->to(base_url('register#tab2'));
                    }

                    $data = [
                        'f_name'        => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                        'l_name'        => $this->request->getVar('l_name',FILTER_SANITIZE_STRING), 
                        'sponsor_id'    => $this->request->getCookie('sponsor_id')!=""?$this->request->getCookie('sponsor_id'):'',
                        'language'      => $dlanguage->language,
                        'username'      => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                        'email'         => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                        'phone'         => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                        'password'      => MD5($this->request->getVar('pass',FILTER_SANITIZE_STRING)),
                        'status'        => 1,
                        'reg_ip'        => $this->request->getIpAddress()
                    ];
                    $this->web_model->updateUser($data);
                    $this->session->setFlashdata('message', display('account_create_success_social'));
                    return redirect()->to(base_url('register#tab2'));

                }else {
                    $this->session->setFlashdata('exception', display('email_used')." ".display('username_used'));
                    redirect()->to(base_url('register#tab2'));

                }

            }else{
                $userid = strtoupper(random_string('alnum', 6));

                if (!$this->request->isValidIp($this->request->getIpAddress())){
                    $this->session->setFlashdata('exception',  "Invalid IP address");
                    redirect()->to(base_url('register#tab2'));

                }
                $data = [
                    'f_name'        => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                    'l_name'        => $this->request->getVar('l_name',FILTER_SANITIZE_STRING), 
                    'sponsor_id'    => $this->request->getCookie('sponsor_id')!=""?$this->request->getCookie('sponsor_id'):'', 
                    'language'      => $dlanguage->language,
                    'user_id'       => $userid, 
                    'username'      => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'email'         => $this->request->getVar('email',FILTER_SANITIZE_EMAIL),
                    'phone'         => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                    'oauth_provider'=> 'website',
                    'password'      => MD5($this->request->getVar('pass',FILTER_SANITIZE_STRING)),
                    'status'        => 0,
                    'reg_ip'        => $this->request->getIpAddress()
                ];
                $duplicatemail = $this->web_model->checkDuplictemail($data);          
                if (!empty($duplicatemail->getRow())){
                    $this->session->setFlashdata('exception', display('email_used'));
                    return redirect()->to(base_url('register#tab2'));
                }           
                $checkDuplictuser = $this->web_model->checkDuplictuser($data);    
                if (!empty($checkDuplictuser)){
                    $this->session->setFlashdata('exception', display('username_used'));
                    return redirect()->to(base_url('register#tab2'));
                }
                if($this->web_model->registerUser($data)){

                    $appSetting = $this->common_model->get_setting();
                    $template = array( 
                        'fullname'      => '#',
                        'amount'        => '0',
                        'balance'       => '0',
                        'pre_balance'   => '0',
                        'new_balance'   => '0',
                        'user_id'       => '#',
                        'receiver_id'   => '#',
                        'verify_code'   => '#',
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'registration',
                        'template_lang' => $lang=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);
                    $send_email = array(
                        'title'         => $appSetting->title,
                        'to'            => $this->request->getVar('email',FILTER_SANITIZE_EMAIL),
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                    );

                    $data['title']      = $appSetting->title;
                    $data['to']         = $this->request->getVar('email',FILTER_SANITIZE_STRING);
                    $data['subject']    = $message['subject'];
                    $data['message']    = $message['message']." <a target='_blank' href='".site_url('home/activeAcc/').strtolower($userid).md5($userid)."'>".site_url('home/activeAcc/').strtolower($userid).md5($userid)."</a>";
                    $this->common_model->send_email($data);

                    $this->session->setFlashdata('message', display('account_create_active_link'));
                    return redirect()->to(base_url('register#tab2'));

                }
                else{
                    $this->session->setFlashdata('exception',  display('please_try_again'));
                    return redirect()->to(base_url('register#tab2'));
                }

            }

        }
        else {
            $error=$this->validation->listErrors();
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $error);
                return redirect()->to(base_url('register#tab2'));
            }
        }
        
        $data['content']        = view('themes/'.$this->templte_name->name.'/register',$data);
        return $this->template->website_layout($data);
        
    }

    public function login()
    {

        if ($this->session->userdata('isLogIn'))
           return redirect()->to(base_url());
        
        @$cat_id = $this->web_model->catidBySlug('register');
        
        $data['title']      = $this->uri->getSegment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->getSegment(1));

        //Set Rules From validation
        $this->validation->setRule('email', display('email'),'required|max_length[100]');
        $this->validation->setRule('password', display('password'),'required|max_length[32]|md5');
        
        $data['user'] = (object)$userData = array(
            'email'      => $this->request->getVar('email',FILTER_SANITIZE_STRING),
            'password'   => $this->request->getVar('password',FILTER_SANITIZE_STRING),
        );
        
        //From Validation Check
        if ($this->validation->withRequest($this->request)->run())
        {            
            $user = $this->web_model->checkUser($userData);
            
            if(!empty($user->getRow())) {

                if($user->getRow()->password==md5($userData['password']) && $user->getRow()->status==1) 
                {
                    $sData = array(
                        'isLogIn'     => true,
                        'id'          => $user->getRow()->uid,
                        'user_id'     => $user->getRow()->user_id,
                        'fullname'    => $user->getRow()->f_name.' '.$user->getRow()->l_name,
                        'email'       => $user->getRow()->email,
                        'image'          => $user->getRow()->image,
                        'sponsor_id'  => $user->getRow()->sponsor_id,
                        'phone'       => $user->getRow()->phone,
                    );
                    //Store date to session & Login
                    $this->session->set($sData);
                    return redirect()->to(base_url('home'));

                }
                else{
                    if($user->getRow()->status==0){
                        $this->session->setFlashdata('exception', display('account_active_mail'));
                        return redirect()->to(base_url('register#tab2'));

                    }
                    else{
                        $this->session->setFlashdata('exception', display('incorrect_email_password'));
                        return redirect()->to(base_url('register#tab2'));

                    }

                }

            }
            else{
                $this->session->setFlashdata('exception', display('incorrect_email_password'));
                return redirect()->to(base_url('register#tab2'));

            }

        }
        $data['content']        = view('themes/'.$this->templte_name->name.'/register',$data);
        return $this->template->website_layout($data);
    }

    //Ajax Subscription Action
    public function subscribe()
    {
        $data = array();
        $data['email'] =  $this->request->getVar('subscribe_email',FILTER_SANITIZE_STRING);

        if($this->common_model->insert('web_subscriber',$data)){
            $this->session->setFlashdata('message', display('save_successfully'));
            
        }
        else{
            $this->session->setFlashdata('exception',  display('please_try_again'));

        }
    }

    //Ajax Contact Message Action
    public function contactMsg()
    {
        $appSetting = $this->common_model->get_setting();
        
        $data['fromName']       = $this->request->getVar('f_name',FILTER_SANITIZE_STRING)." ".$this->request->getVar('l_name',FILTER_SANITIZE_STRING);
        $data['from']           = $this->request->getVar('email',FILTER_SANITIZE_EMAIL);
        $data['to']             = $appSetting->email;
        $data['subject']        = 'Leave us a message';
        $data['title']          = $this->request->getVar('email',FILTER_SANITIZE_STRING);
        $data['message']    = "<b>Phone: </b>".$this->request->getVar('phone',FILTER_SANITIZE_STRING)."<br><b>Company: </b>".$this->request->getVar('company',FILTER_SANITIZE_STRING)."<br><b>Message: </b>".$this->request->getVar('comment',FILTER_SANITIZE_STRING);
        
        $this->common_model->send_email($data);

    }

    public function activeAcc($activecode='')
    {
        if($activecode){
            $activecode = strtoupper(substr($activecode, 0, 6));

        }
        $user = $this->web_model->activeAccountSelect($activecode);

        if ($user->CountAll() > 0){
            $this->web_model->activeAccount($activecode);
            $this->session->setFlashdata('message', display('active_account'));
            return redirect()->to(base_url("register#tab2"));

        } else {
            $this->session->setFlashdata('exception', display('wrong_try_activation'));
            return redirect()->to(base_url("register#tab2"));
        }

    }


    public function paymentform(){

        if (empty($this->session->userdata('user_id'))) {
            return  redirect()->to(base_url('register#tab2'));

        }

        @$cat_id = $this->web_model->catidBySlug('buy');

        //Language setting
        $data['lang']       = $this->langSet();

        //Session Data from Buy FORM
        $data['sbuypayment']= $this->session->userdata('buy'); 

        $data['title']      = $this->uri->getSegment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info('buy');


        if ($this->session->userdata('buy')) {
            $data['deposit'] = $this->session->userdata('deposit');
            //Payment Type specify for callback (deposit/buy/sell etc )
            $this->session->set('payment_type', 'buy');

            $method  = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            if (!$data['deposit_data']) {
                $this->session->setFlashdata('exception', display('this_gateway_deactivated'));
                return  redirect()->to(base_url('customer/buy/buy_form'));
            }

        }else{
            $this->session->setFlashdata('exception', "Something went wrong!!!");
            return  redirect()->to(base_url('customer/buy/buy_form'));
        }
        $data['content']        = view('themes/'.$this->templte_name->name.'/paymentform',$data);
        return $this->template->website_layout($data);

    }


    //Ajax calculation Buy Form
    public function buyPayable()
    {

        $cid    = $this->request->getVar('cid',FILTER_SANITIZE_STRING);
        $amount = $this->request->getVar('buy_amount',FILTER_SANITIZE_STRING);

        $data['selectedcryptocurrency'] = $this->buy_model->findCurrency($cid);
        $data['selectedexccurrency']    = $this->buy_model->findExchangeCurrency($cid);
        $data['selectedlocalcurrency']  = $this->buy_model->findlocalCurrency();
        if (!empty($amount)) {
            $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;
            $payableusd             = $data['price_usd']*$amount;
            $data['payableusd']     = $payableusd;
            $data['payablelocal']   = $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
        } else {
            $data['payableusd']     = 0;
            $data['payablelocal']   = 0;
            if (empty($cid)) {
                $data['price_usd']  = 0;
            }else{
                $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;
            }
        }

        return view('themes/'.$this->templte_name->name.'/ajaxbuy',$data);

    }

    //Ajax calculation Sells Form
    public function sellPayable()
    {
        
        $cid    = $this->request->getVar('cid',FILTER_SANITIZE_STRING);
        $amount = $this->request->getVar('sell_amount',FILTER_SANITIZE_STRING);


        $data['selectedcryptocurrency'] = $this->sell_model->findCurrency($cid);
        $data['selectedexccurrency']    = $this->sell_model->findExchangeCurrency($cid);
        $data['selectedlocalcurrency']  = $this->sell_model->findlocalCurrency();
        if (!empty($amount)) {
            $data['price_usd']          = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
            $payableusd                 = $data['price_usd']*$amount;
            $data['payableusd']         = $payableusd;
            $data['payablelocal']       = $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
        } else {

            $data['payableusd']         = 0;
            $data['payablelocal']       = 0;
            if (empty($cid)) {
                $data['price_usd']      = 0;
            }else{
                $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
            }
        }
        
        return view('themes/'.$this->templte_name->name.'/ajaxsell',$data);

    }

    public function forgotPassword()
    {

        //Set Rules From validation
        $this->validation->setrule('email', display('email'),'required');

        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()) {
            $userdata = array(
                'email'       => $this->request->getVar('email',FILTER_SANITIZE_EMAIL),
            );

            $varify_code = $this->randomID();

            /******************************
            *  Email Verify
            ******************************/
            $appSetting = $this->common_model->get_setting();

            $post = array(
                'title'             => $appSetting->title,
                'subject'           => 'Password Reset Verification!',
                'to'                => $this->request->getVar('email',FILTER_SANITIZE_EMAIL),
                'message'           => 'The Verification Code is <h1>'.$varify_code.'</h1>'
            );

            //Send Mail Password Reset Verification
            $send = $this->common_model->send_email($post);
            
            if(isset($send)){

                $varify_data = array(

                    'ip_address'    => $this->request->getIpAddress(),
                    'user_id'       => $this->session->userdata('user_id'),
                    'session_id'    => $this->session->userdata('isLogIn'),
                    'verify_code'   => $varify_code,
                    'data'          => json_encode($userdata)
                );
                
                $this->common_model->insert('verify_tbl',$varify_data);
             
                $id = $this->db->insertId();

                $this->session->setFlashdata('message', "Password reset code sent.Check your email.");
                
                return redirect()->to(base_url("resetPassword"));

            }
        }else{
            $this->session->setFlashdata('exception',display('email')." Required");
            return redirect()->to(base_url('register#tab2'));

        }

    }

    public function resetPassword()
    {

        @$cat_id = $this->web_model->catidBySlug('forgot-password');     

        $data['title'] = $this->uri->getSegment(1);   
        $data['article']  = $this->web_model->article($cat_id->cat_id);
        $data['cat_info'] = $this->web_model->cat_info('forgot-password');

        $code = $this->request->getVar('verificationcode',FILTER_SANITIZE_STRING);
        $newpassword = $this->request->getVar('newpassword',FILTER_SANITIZE_STRING);
        
        $chkdata = $this->db->table('verify_tbl')->select('*')
                            ->where('verify_code',$code)
                            ->where('status', 1)
                            ->get()
                            ->getRow();

        //Set Rules From validation
        $this->validation->setRule('verificationcode',display('enter_verify_code'),'required');
        $this->validation->setRule('newpassword',display('password'),'required|min_length[8]|max_length[32]|matches[r_pass]');
       

        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()) {
            
            if($chkdata!=NULL) {
                $p_data = ((array) json_decode($chkdata->data));
                $password   = array('password' => md5($newpassword));
                $status     = array('status'   => 0);
                $where = array('verify_code' => $code);
                $userwhere = array('email' => $p_data['email']);
                $this->common_model->update('verify_tbl',$where,$status);
                $this->common_model->update('user_registration',$userwhere,$password);

                $this->session->setFlashdata('message',display('update_successfully'));
                return redirect()->to(base_url('register#tab2'));

            }else{
                $this->session->setFlashdata('exception',display('wrong_try_activation'));
                return redirect()->to(base_url('resetPassword'));
            }

        }else{
            $error=$this->validation->listErrors();
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $error);
                return redirect()->to(base_url('resetPassword'));
            }
            $data['content']        = view('themes/'.$this->templte_name->name.'/passwordreset',$data);
            return $this->template->website_layout($data);
           
        }

    }

    
    //Ajax Language Change
    public function langChange()
    {
        $newdata = array(
            'lang'  => $this->request->getVar('lang',FILTER_SANITIZE_STRING)
        );        

        $user_id = $this->session->userdata('user_id');
        if ($user_id!="") {
            $data['language'] = $this->request->getVar('lang',FILTER_SANITIZE_STRING);
            $where = array('user_id' => $user_id);
            $this->common_model->update('user_registration',$where,$data);

        }
        else {
            $this->session->set($newdata);

        }
        
    }


    /******************************
    * Language Set For User
    ******************************/
    public function langSet(){

        $lang = "";
        $user_id = $this->session->userdata('user_id');
        if ($user_id!="") {
            $builder = $this->db->table('user_registration');
            $ulang = $builder->select('language')->where('user_id', $user_id)->get()->getRow();
            if ($ulang->language!='english') {
                $lang ='french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set($newdata);

            }
            else{
                $lang ='english';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set($newdata);
            }

        }
        else{
            $builder = $this->db->table('setting');
            $alang = $builder->select('language')->get()->getRow();
            if ($alang->language=='french') {
                $lang ='french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set($newdata);

            }else{
                if ($this->session->lang=='french') {
                    $lang ='french';

                }
                else{
                    $lang ='english';
                }

            }

        }

        return $lang;
    }

    //Ajax Sparkline Graph data JSON Formate
    public function coingraphdata($data1=0)
    {
        $per_page = 15;

        $data['cryptocoins']  = $this->db->table('cryptolist')->select("Symbol")->orderBy('SortOrder', 'asc')->limit($per_page, $data1)->get()->getResult();
        $cryptoapi  = $this->web_model->findById('external_api_setup', array('id'=>3));

        $apijson = json_decode($cryptoapi->data);

        foreach ($data['cryptocoins'] as $key => $value) {            

            $test1      = file_get_contents('https://min-api.cryptocompare.com/data/histoday?fsym='.$value->Symbol.'&tsym=USD&limit=10&api_key='.$apijson->api_key);
            $history1   = json_decode($test1, true);

            $data24h[$value->Symbol]="";
            foreach ($history1['Data'] as $h_key => $h_value) {
                $data24h[$value->Symbol] .= $h_value['low'].",".$h_value['high'].",";
            }
            $data24h[$value->Symbol] = rtrim($data24h[$value->Symbol], ',');
        }

        echo json_encode($data24h);  
    }

    //Ajax Currency Price Tricker data JSON Formate
    public function cointrickerdata()
    {
        
        $data['cryptocoins']  = $this->db->table('cryptolist')->select("Symbol")->orderBy('SortOrder', 'asc')->limit(10, 0)->get()->getResult();

        foreach ($data['cryptocoins'] as $key => $value) {            

            $test1 = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym='.$value->Symbol.'&tsyms=USD');
            $history1 = json_decode($test1, true);

            $datatricker[$value->Symbol]="";
            foreach ($history1 as $tri_key => $tri_value) { 

                $datatricker[$value->Symbol] .= $tri_value.",";

            }
            $datatricker[$value->Symbol] = rtrim($datatricker[$value->Symbol], ',');    

        }
        echo json_encode($datatricker);
    }

    /******************************
    * Converter Percent of Number
    ******************************/
    public function getPercentOfNumber($number, $percent){
        return ($percent / 100) * $number;
    }


    /******************************
    * Rand ID Generator
    ******************************/
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .="".$charArray[$randItem];

        }
        return $result;

    }

    public function logout()
    { 
        //destroy session
      $ipadd = $this->request->getIPAddress();
      $this->session->destroy();
      return redirect()->to(base_url());
    }
}