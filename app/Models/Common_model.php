<?php 
namespace App\Models;

class Common_model {
    
    public function __construct(){
        $this->db = db_connect();
        $this->session = \Config\Services::session();
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
        $query=$builder->get();
        return $data=$query->getResult();
    }
    
    #----------------------
    #Insert Into ANY TABLE 
    #----------------------
    public function insert($table,$data=array()){
    		
            $builder=$this->db->table($table);
            return $builder->insert($data);
    }
    
    #-----------------
    #UPDATE ANY TABLE
    #-----------------
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
        $builder=$this->db->table($table);
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
        
        //Intial the email config
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

	public function email_sms($method)
	{
            $builder=$this->db->table("sms_email_send_setup");
            return $builder->select('*')
                            ->where('method',$method)
                            ->get()
                            ->getrow();

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
        public function get_all_transection_by_user($user_id)
	{
                $builder = $this->db->table('transections');
		$data = $builder->select('*')
                                ->where('user_id',$user_id)
                                ->where('status',1)
                                ->get()
                                ->getResult();
		
		$dep = 0;
		$dep_f = 0;
		$w_f = 0;
		$t_f = 0;
		$we = 0;
		$invest = 0;
		$tras = 0;
		$reciver = 0;
		$individule = array();

		foreach ($data as $value) {

			if(@$value->transection_category=='deposit'){

				$deposit = $this->getFees('deposit',$value->releted_id);
				$dep_f = $dep_f + $deposit->fees;
				$individule['d_fees'] = $dep_f;

				$dep = $dep + $value->amount;
				$individule['deposit'] = $dep;
			}

			if(@$value->transection_category=='withdraw'){

				$withdraw = $this->getFees('withdraw',$value->releted_id);
				$w_f = $w_f + $withdraw->fees;
				$individule['w_fees'] = $w_f;

				$we = $we+$value->amount;
				$individule['withdraw'] = $we;

			}

			if(@$value->transection_category=='transfer'){

				$transfer = $this->getFees('transfer',$value->releted_id);
				$t_f = $t_f + $transfer->fees;
				$individule['t_fees'] = $t_f;

				$tras = $tras+$value->amount;
				$individule['transfar'] = $tras;
			}

			if(@$value->transection_category=='investment'){
				$invest = $invest+$value->amount;
				$individule['investment'] = $invest;
			}

			if(@$value->transection_category=='reciver'){
				$reciver = $reciver+$value->amount;
				$individule['reciver'] = $reciver;
			}
		}

			// My Payout
                        $payoutbuilder = $this->db->table('earnings');
			$my_payout = $payoutbuilder->select("sum(amount) as earns2")
				->where('user_id',$user_id)
				->where('earning_type','type2')
				->get()
				->getRow();
			$individule['my_payout'] = $my_payout->earns2;

			//Package Commission
			$commission = $payoutbuilder->select("sum(amount) as earns1")
				->where('user_id',$user_id)
				->where('earning_type','type1')
				->get()
				->getrow();
			$individule['commission'] = $commission->earns1;

			//team bonus
                        $userbuilder = $this->db->table('user_level');
			$bonus = $userbuilder->select("sum(bonus) as bonuss")
				->where('user_id',$user_id)
				->get()
				->getrow();

			$individule['bonuss'] = $bonus->bonuss;


			// total earning
			$total_earn =  $individule['my_payout']+$individule['commission']+$individule['bonuss'];
			$individule['earn'] = $total_earn;
			#-----------------------
			//TOTAL FEES
			$total_fees = (@$individule['d_fees']+@$individule['w_fees']+@$individule['t_fees']);
			#-----------------------

			#---------------------------
			# TOTAL GRAND BALENCE
			$individule['balance'] = (@$individule['deposit']+@$individule['reciver']+@$total_earn)-(@$individule['withdraw']+@$individule['investment']+@$individule['transfar']+@$total_fees);
			#----------------------------
			return $individule;

	}
	public function get_cata_wais_transections($user_id="")
	{
		if ($user_id!="") {
			$user_id = $user_id;
		}
		else{
			$user_id = $this->session->get('user_id');
		}
                $builder= $this->db->table("transections");
		$data = $builder->select('*')
		->where('user_id', $user_id)
		->get()
		->getresult();
		
		$dep = 0;
		$dep_f = 0;
		$w_f = 0;
		$t_f = 0;
		$we = 0;
		$invest = 0;
		$tras = 0;
		$reciver = 0;
		$individule = array();

		foreach ($data as $value) {

			if(@$value->transection_category=='deposit'){

				$deposit = $this->getFees('deposit',$value->releted_id);
				$dep_f = $dep_f + @$deposit->fees;
				$individule['d_fees'] = $dep_f;

				$dep = $dep + $value->amount;
				$individule['deposit'] = $dep;
			}

			if(@$value->transection_category=='withdraw'){

				$withdraw = $this->getFees('withdraw',$value->releted_id);
				$w_f = $w_f + @$withdraw->fees;
				$individule['w_fees'] = $w_f;

				$we = $we+$value->amount;
				$individule['withdraw'] = $we;

			}

			if(@$value->transection_category=='transfer'){

				$transfer = $this->getFees('transfer',$value->releted_id);
				$t_f = $t_f + $transfer->fees;
				$individule['t_fees'] = $t_f;

				$tras = $tras+$value->amount;
				$individule['transfar'] = $tras;
			}

			if(@$value->transection_category=='investment'){
				$invest = $invest+$value->amount;
				$individule['investment'] = $invest;
			}

			if(@$value->transection_category=='reciver'){
				$reciver = $reciver+$value->amount;
				$individule['reciver'] = $reciver;
			}
		}

			// My Payout
                        $mypayout_builder= $this->db->table("earnings");
			$my_payout = $mypayout_builder->select("sum(amount) as earns2")
				->where('user_id',$this->session->get('user_id'))
				->where('earning_type','type2')
				->get()
				->getrow();
			$individule['my_payout'] = $my_payout->earns2;

			//Package Commission
                        $mypayout_commission= $this->db->table("earnings");
			$commission = $mypayout_commission->select("sum(amount) as earns1")
				->where('user_id',$this->session->get('user_id'))
				->where('earning_type','type1')
				->get()
				->getrow();
			$individule['commission'] = $commission->earns1;

			//team bonus
                        $bonus_builder = $this->db->table("user_level"); 
			$bonus = $bonus_builder->select("sum(bonus) as bonuss")
				->where('user_id',$this->session->get('user_id'))
				->get()
				->getrow();

			$individule['bonuss'] = $bonus->bonuss;


			// total earning
			$total_earn =  $individule['my_payout']+$individule['commission']+$individule['bonuss'];
			$individule['earn'] = $total_earn;
			#-----------------------
			//TOTAL FEES
			$total_fees = (@$individule['w_fees']+@$individule['t_fees']);
			#-----------------------
			
			#---------------------------
			# TOTAL GRAND BALENCE
			$individule['balance'] = (@$individule['deposit']+@$individule['reciver']+@$total_earn)-(@$individule['withdraw']+@$individule['investment']+@$individule['transfar']+@$total_fees);
			#----------------------------
			return $individule;

	}
        public function getFees($table,$id)
	{       
        $builder = $this->db->table($table);
		return $builder->select('*')
		->where($table.'_id',$id)
		->get()
		->getrow();
	}
        
	public function retriveUserInfo()
	{
        $builder = $this->db->table('user_registration');
		return $builder->select('*')
			->where('user_id', $this->session->get('user_id'))
			->get()
			->getrow();
	}

}