<?php namespace App\Modules\Website\Models;
class common_model {
    public function __construct(){
        $this->db = db_connect();
    }
    #------------------------
    #Read All Data from TABLE
    #-------------------------
    public function get_all($table, $where = array(), $limit = 0, $offset = 0,$title,$name){
        
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where);
        $builder->limit($limit,$offset);
        $builder->orderBy($title,$name);
        $query      =$builder->get();
        return $data=$query->getResult();
    }
    #-----------------
    #Insert ANY TABLE
    #----------------
    public function insert($table,$data=array()){
            $builder=$this->db->table($table);
            return $builder->insert($data);
    }
    #-----------------
    #UPDATE ANY TABLE
    #----------------
     public function update($table,$where = array(),$data=array()){
        $builder=$this->db->table($table);
        return $builder->where($where)
                       ->update($data);
    }
    #-----------------
    #Read ANY TABLE
    #----------------
     public function read($table,$where = array(),$limit=null, $offset=null)
    {
            $builder=$this->db->table($table);
            return $builder->select("*")
                    ->where($where)
                    ->limit($limit, $offset)
                    ->get()
                    ->getRow();
    }
    #------------------------
    #Count All Data from TABLE
    #-------------------------
    public function countRow($table, $where = array()){
        
        return $resutl = $this->db->table($table)
                       ->where($where)
                       ->countAllResults(); 
    }
    
    #------------------------
    #Delete a row from TABLE
    #-------------------------
    public function deleteRow($table,$where){
        $builder    =    $this->db->table($table);
        return $builder->where($where)
			->delete();
    }
    
    
   
        public function send_email($post=array()){

                $email = \Config\Services::email();
		  $where = array(
                    'es_id' => 2
                );
                $emailquery = $this->read('email_sms_gateway',$where);
                       

		//SMTP & mail configuration
                $config['protocol'] =   $emailquery->protocol;
                $config['SMTPHost'] =    $emailquery->host;
                $config['SMTPPort'] =    $emailquery->port;
                $config['SMTPUser']= $emailquery->user;
                $config['SMTPPass']= $emailquery->password;
                $config['mailType']= $emailquery->mailtype;
                $config['charset']  = $emailquery->charset;
                $config['wordWrap'] = true;
                        
                $email->initialize($config);

		//Email content
		$htmlContent = $post['message'];

                $email->setFrom($emailquery->user, $post['title']);
                $email->setTo($post['to']);
                

                $email->setSubject($post['subject']);
                $email->setMessage($htmlContent);
		
		//Send email
		if($ne=$email->send()){
			return 1;

		} else{
			return 0;

		}
	}
        public function email_msg_generate($config = array(), $message_data = array()){
     
	$templateemail = $this->db->table('dbt_sms_email_template')->select('*')->where('template_name', @$config['template_name'])->where('sms_or_email', 'email')->get()->getRow();
        $message  	   = ($config['template_lang']=='en')?$templateemail->template_en:$templateemail->template_fr;
        
        if (is_array($message_data) && sizeof($message_data) > 0){
            $message = $this->_template($message, $message_data);
        }

		//Email content
		$htmlContent = $message;
		$subject 	 = ($config['template_lang']=='en')?$templateemail->subject_en:$templateemail->subject_fr;
		$data = array(
					'subject'	=> $subject,
					'message'	=> $message
				);
		return $data;

	}

    private function _template($template = null, $data = array())
    {
        $newStr = $template;
        foreach ($data as $key => $value) {
            $newStr = str_replace("%$key%", $value, $newStr);
        } 
        return $newStr; 
    }


	public function sms_msg_generate($config = array(), $message_data = array()){

	    $templatesms = $this->db->table('dbt_sms_email_template')->select('*')->where('template_name', @$config['template_name'])->where('sms_or_email', 'sms')->get()->getRow();
        $message  	 = ($config['template_lang']=='en')?$templatesms->template_en:$templatesms->template_fr;
        if (is_array($message_data) && sizeof($message_data) > 0){
            $message = $this->_template($message, $message_data);
        }
        
        $subject 	 = ($config['template_lang']=='en')?$templatesms->subject_en:$templatesms->subject_fr;
        $data = array(
					'subject'	=> $subject,
					'message'	=> $message
				);
		return $data;
    }


       public function get_setting(){
            $builder =$this->db->table("setting");
            return $settings = $builder->select("email,phone,time_zone,title")
                                        ->get()
                                        ->getRow();
	}
    
        public function payment_gateway()
	{
                $builder =$this->db->table("payment_gateway");
		return $builder->select('*')
                                ->where('status', 1)
                                ->get()
                                ->getresult();
	}


}