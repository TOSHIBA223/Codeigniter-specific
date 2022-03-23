<?php 
namespace App\Modules\Package\Controllers\Customer;

class Package extends BaseController
{
    public function index()
    {   
        $data['title']   = display('package'); 
        $data['package'] = $this->common_model->get_all('package',$where=array(),$limit=null,$offset=null,'package_id','ASC');

        $data['content'] = $this->BASE_VIEW .'\package';
        return $this->template->customer_layout($data);
    }

    public function confirm_package($package_id=NULL)
    {   
        $user_id = $this->session->userdata('user_id');
        $data['title']   = display('package'); 
        $where = array(
            'user_id'    => $user_id
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        $packagewhere = array(
            'package_id' => $package_id
        );
        $data['settings'] = $this->db->table('setting')->select("*")->get()->getRow();
        $data['package'] = $this->common_model->read('package',$packagewhere);
        $data['content'] = $this->BASE_VIEW .'\package_confirmation';
        return $this->template->customer_layout($data);
        
    }

    /*
    |--------------------------------------------------------------
    |   BUY PACKAGE 
    |--------------------------------------------------------------
    */
    public function buy($package_id=NULL)
    { 
        // balance chcck
        $blance = $this->check_balance($package_id);

        $set           = $this->common_model->email_sms('email');
        $smsPermission = $this->common_model->email_sms('sms');
        $appSetting    = $this->common_model->get_setting();

        if($blance!=NULL){

            $user_id = $this->session->userdata('user_id');
            if($this->check_investment($user_id)==''){
                $saveLevel = array(
                    'user_id'           => $this->session->userdata('user_id'),
                    'sponser_commission'=> 0.0,
                    'team_commission'   => 0.0,
                    'level'             => 1,
                    'last_update'       => date('Y-m-d h:i:s')
                );

                /*********************************
                *   Data Store Details Table
                **********************************/
                $this->common_model->insert('team_bonus_details',$saveLevel);
                $this->common_model->insert('team_bonus',$saveLevel);

            }

            $buy_data = array(
                'user_id'       => $this->session->userdata('user_id'),
                'sponsor_id'    => $this->session->userdata('sponsor_id'),
                'package_id'    => $package_id,
                'amount'        => $blance->package_amount,
                'invest_date'   => date('Y-m-d'),
                'day'           => date('N'),
            );
            
            $result = $this->package_model->buy_package($buy_data);
            // check investment by customent
            $where = array(
                'user_id' => $this->session->userdata('user_id')
            );
            $customent_investment =$this->common_model->countRow('investment',$where);
        
            $sponsor_id    = $this->session->userdata('sponsor_id');
            // get sponsert information by id
            $sponsorwhere = array(
                'user_id' => $sponsor_id
            );
           $sponsers_info = $this ->common_model->read('user_registration',$sponsorwhere);
             // check invesment by sponser
           $investwhere = array(
                'user_id' => $sponsor_id
            );
            $investment =$this->common_model->countRow('investment',$investwhere);

            if($this->session->userdata('sponsor_id')!=NULL){

                if($investment > 0 ){
                    // get package informaion by package id
                    $packwhere = array('package_id' => $package_id);
                    $pack_info = $this->common_model->read('package',$packwhere);
                    #--------------------------------
                    #    commission data save
                    #--------------------------------
                    $referralwhere = array('level_name' => 1);
                    $referral_bonous = $this->common_model->read('setup_commission',$referralwhere);

                    $commission_amount = ($blance->package_amount/100)*$referral_bonous->referral_bonous;

                    $commission = array(
                        'user_id'       => $this->session->userdata('sponsor_id'),
                        'Purchaser_id'  => $this->session->userdata('user_id'),
                        'earning_type'  => 'type1',
                        'package_id'    => $pack_info->package_id,
                        'amount'        => $commission_amount,
                        'date'          => date('Y-m-d'),
                    );
                    $this->common_model->insert('earnings',$commission);
                    //end commission

                    //get total balance
                    $balance     = $this->common_model->get_all_transection_by_user($sponsers_info->user_id);   
                    $new_balance = ($balance['balance']+$commission_amount);


                    $user_lang      = $this->db->table('user_registration')->select('*')->where('user_id', $this->session->userdata('user_id'))->get()->getRow();
                    #----------------------------
                    # sms send to commission received
                    #----------------------------
                    if(!empty($smsPermission) && $smsPermission->commission == 1){                       
                        $template  = array( 
                            'fullname'      => $user_lang->f_name." ".$user_lang->l_name,
                            'amount'        => $commission_amount,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'commission',
                            'template_lang' => $user_lang->language=='english'?'en':'fr',
                        );
                        $message = $this->common_model->sms_msg_generate($config_var, $template);
                        $send_sms = $this->sms_lib->send(array(
                            'to'            => $sponsers_info->phone, 
                            'message'       => $message['message']
                        ));

                    }
                    if(!empty($set) && $set->commission == 1){
                        $template  = array( 
                            'fullname'      => $user_lang->f_name." ". $user_lang->l_name,
                            'amount'        => $commission_amount,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'commission',
                            'template_lang' => $user_lang->language=='english'?'en':'fr',
                        );
                        $message    = $this->common_model->email_msg_generate($config_var, $template);
                        $code_send = array(
                            'title'         => $appSetting->title,
                            'to'            => $sponsers_info->email,
                            'subject'       => $message['subject'],
                            'message'       => $message['message'],
                        );
                        $send_email = $this->common_model->send_email($code_send);
                    }

                    //Notification Commission
                    $notification = array(
                        'user_id'           => $sponsers_info->user_id,
                        'subject'           => 'Commission',
                        'notification_type' => 'commission',
                        'details'           => $message['message'],
                        'date'              => date('Y-m-d h:i:s'),
                        'status'            => '0'
                    );
                    $this->common_model->insert('notifications',$notification);

                    #----------------------------------------------------------
                    #   Won Sponser set personal and team commission set heare
                    #-----------------------------------------------------------
                    $teambonuswhere = array(
                        'user_id' => $sponsor_id
                    );
                    $sponsers = $this->common_model->read('team_bonus',$teambonuswhere);
                    if($sponsers!=NULL){

                        $scom = @$sponsers->sponser_commission + $blance->package_amount;
                        $tcom = @$sponsers->team_commission + $blance->package_amount;

                        $sdata = array(
                            'sponser_commission'=> $scom,
                            'team_commission'   => $tcom,
                            'last_update'       => date('Y-m-d h:i:s')
                        );
                        $detailsdata = array(
                            'user_id'           =>$sponsor_id,
                            'sponser_commission'=>$scom,
                            'team_commission'   =>$tcom,
                            'last_update'       =>date('Y-m-d h:i:s')
                        );

                        /******************************
                        *   Data Store Details Table
                        ******************************/
                        $this->common_model->insert('team_bonus_details',$detailsdata);
                        $updatewhere = array(
                            'user_id' => $sponsor_id
                        );
                        $this->common_model->update('team_bonus',$updatewhere,$sdata);
                       

                    } else {

                        $scom = @$sponsers->sponser_commission + @$blance->package_amount;
                        $tcom = @$sponsers->team_commission + @$blance->package_amount;
                        
                        $sdata = array(
                            'user_id'           =>$sponsor_id,
                            'sponser_commission'=>$scom,
                            'team_commission'   =>$tcom,
                            'last_update'       =>date('Y-m-d h:i:s')
                        );

                        /******************************
                        *   Data Store Details Table
                        ******************************/
                        $this->common_model->insert('team_bonus_details',$sdata);
                        $this->common_model->insert('team_bonus',$sdata);
                        

                    }
                    #-----------------------------
                    # Level bonus heare with level
                    #-----------------------------
                    $getBool = $this->setlevel_withbonus($sponsor_id);
                }
                $tuSdata = array(

                    'genaretion' =>  2,
                    'package_id' =>  $package_id,
                    'amount'     =>  $blance->package_amount,
                    'sponsor_id' =>  $sponsor_id
                );

                $this->recursive_data($tuSdata);
                #
                #--------------------------------

            }

            if($result != NULL){
                $transections_data = array(
                    'user_id'                   => $this->session->userdata('user_id'),
                    'transection_category'      => 'investment',
                    'releted_id'                => $result['investment_id'],
                    'amount'                    => $blance->package_amount,
                    'transection_date_timestamp'=> date('Y-m-d h:i:s')
                );
                $this->common_model->insert('transections',$transections_data);

                $user_lang      = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->userdata('user_id'))->get()->getRow();
                #----------------------------
                # sms send 
                #----------------------------
                $template  = array( 
                    'fullname'      => $this->session->userdata('fullname'),
                    'amount'        => $blance->package_amount,
                    'balance'       => @$balance['balance'],
                    'pre_balance'   => @$balance['balance'],
                    'new_balance'   => @$new_balance,
                    'user_id'       => $this->session->userdata('user_id'),
                    'receiver_id'   => $this->session->userdata('user_id'),
                    'verify_code'   => @$varify_code,
                    'date'          => date('d F Y')
                );
                $config_var = array( 
                    'template_name' => 'pack_purchase',
                    'template_lang' => $user_lang->language=='english'?'en':'fr',
                );
                $message  = $this->common_model->sms_msg_generate($config_var, $template);
                $send_sms = $this->sms_lib->send(array(
                    'to'            => $this->session->userdata('phone'), 
                    'message'       => $message['message']
                ));

                #----------------------------
                # mail send
                #----------------------------
                $template  = array( 
                    'fullname'      => $this->session->userdata('fullname'),
                    'amount'        => $blance->package_amount,
                    'balance'       => @$balance['balance'],
                    'pre_balance'   => @$balance['balance'],
                    'new_balance'   => @$new_balance,
                    'user_id'       => $this->session->userdata('user_id'),
                    'receiver_id'   => $this->session->userdata('user_id'),
                    'verify_code'   => @$varify_code,
                    'date'          => date('d F Y')
                );
                $config_var = array( 
                    'template_name' => 'pack_purchase',
                    'template_lang' => $user_lang->language=='english'?'en':'fr',
                );
                $message    = $this->common_model->email_msg_generate($config_var, $template);
                $code_send = array(
                    'title'         => $appSetting->title,
                    'to'            => $this->session->userdata('email'),
                    'subject'       => $message['subject'],
                    'message'       => $message['message'],
                );
                $send_email = $this->common_model->send_email($code_send);

                $notification = array(
                    'user_id'           => $this->session->userdata('user_id'),
                    'subject'           => $message['subject'],
                    'notification_type' => 'package_by',
                    'details'           => $message['message'],
                    'date'              => date('Y-m-d h:i:s'),
                    'status'            => '0'
                );
                $this->common_model->insert('notifications', $notification); 
            }

            $this->session->setFlashdata('message', display('package_buy_successfully'));
             return redirect()->to(base_url('customer/package/buy_success/'.$package_id.'/'.$result['investment_id']));
                                      
        } else{

            $this->session->setFlashdata('exception', display('balance_is_unavailable'));
            return redirect()->to(base_url('customer/package/confirm_package/'.$package_id));
            
        }// END FCHECK BALANCE

    } // END FUNCTION

    /**
    * recursive function
    *
    * @param   array  $sp
    * @return   1 and finish recursive function
    */

    public function recursive_data($sp=NULL){
        
        $userwhere = array(
            'user_id' => @$sp['sponsor_id']
        );
        $data = $this->common_model->read('user_registration',$userwhere);


        if(@$data->sponsor_id!=NULL && @$sp['genaretion']<=5 ){
            
            $investwhere = array(
            'user_id' => $data->sponsor_id
            );
            $investment = $this->common_model->countRow('investment',$investwhere);
           

            if($investment !=NUll){
                $sponserswhere = array(
                    'user_id' => $data->sponsor_id
                );
                $sponsers = $this->common_model->read('team_bonus',$sponserswhere);
                

                if($sponsers!=NULL){
                    $scom = @$sponsers->sponser_commission + @$sp['amount'];
                    $tcom = @$sponsers->team_commission + @$sp['amount'];


                    $detailsdata = array('user_id'=>@$data->sponsor_id,'team_commission'=>$tcom,'sponser_commission'=>$scom,'last_update'=>date('Y-m-d h:i:s'));
                    /*
                    |
                    |   Data Store Details Table
                    |
                    */
                    $this->common_model->insert('team_bonus_details',$detailsdata);
                    
                    
                    $sdata = array('team_commission'=>$tcom,'last_update'=>date('Y-m-d h:i:s'));
                    $updatewhereteambonus =array(
                        'user_id' => @$data->sponsor_id
                    ); 
                    $this->common_model->update('team_bonus',$updatewhereteambonus,$sdata);

                } else {

                    $tcom = @$sponsers->team_commission + @$sp['amount'];
                    $sdata = array('user_id'=>@$data->sponsor_id,'team_commission'=>$tcom,'last_update'=>date('Y-m-d h:i:s'));

                    /*
                    |
                    |   Data Store Details Table
                    |
                    */
                    $this->common_model->insert('team_bonus_details',$team_bonus_details);
                    $this->common_model->insert('team_bonus',$sdata);
                    

                }

                #-----------------------------
                # Level bonus heare with level
                $getBool = $this->setlevel_withbonus($data->sponsor_id);
                #-----------------------------

                #-----------------------------------
                # Leveling heare without level bonus

                #---------------------------------
                #    sponser leveling check and set commission
                $lcwhere = array(
                    'user_id' => $data->sponsor_id,
                    'level'  => 2
                );
                $lc = $this->common_model->read('team_bonus',$lcwhere);
                

                if(@$lc!=NULL){
                     $refwhere = array(
                         'level_name' => $lc->level
                     );
                    $referral_bonous = $this->common_model->read('setup_commission',$refwhere);
                    
                    $packwhere = array(
                        'package_id' => @$sp['package_id']
                    );
                    $pack_info = $this->common_model->read('package',$packwhere);
                  
                    $commission_amount = ($pack_info->package_amount/100)*$referral_bonous->referral_bonous;
                    
                    $commission = array(
                        'user_id'       => $data->sponsor_id,
                        'Purchaser_id'  => $this->session->userdata('user_id'),
                        'earning_type'  => 'type1',
                        'package_id'    => @$sp['package_id'],
                        'amount'        => $commission_amount,
                        'date'          => date('Y-m-d'),
                    );
                    
                    $this->common_model->insert('earnings',$commission);
                }

            }

            $tuSdata = array(
                'genaretion' => @$sp['genaretion']+1,
                'amount' => @$sp['amount'],
                'package_id' => @$sp['package_id'],
                'sponsor_id' => @$data->sponsor_id,
            );  

            $this->recursive_data($tuSdata);  

        } else {

            return 1;

        }

    } 

    /**
    * level_complit function
    *
    * @param   sponser id  $user_id
    * @return   1 and finish level_complit function
    */

    public function level_complit($user_id=NULL){
        
        $investwhere = array(
            'user_id' => $user_id
        );
        $investment = $this->common_model->countRow('investment',$investwhere);

        $set           = $this->common_model->email_sms('email');
        $smsPermission = $this->common_model->email_sms('sms');
        $appSetting    = $this->common_model->get_setting();

        if($investment !=NUll){
            
            $sponserswhere = array(
                'user_id' => $user_id
            );
            $sponsers = $this->common_model->read('team_bonus',$sponserswhere);
            
            $sponsers_info_where = array(
                'user_id' => $user_id
            );
            $sponsers_info = $this->common_model->read('user_registration',$sponsers_info_where);

            $balance = $this->common_model->get_all_transection_by_user($sponsers_info->user_id);

            if($sponsers->sponser_commission!=0 && $sponsers->team_commission!=0){

                $level = @$sponsers->level;
                $builder = $this->db->table('setup_commission');
                $set_com = $builder->select('*')
                    ->where('personal_invest<=',@$sponsers->sponser_commission)
                    ->where('total_invest<=',@$sponsers->team_commission)
                    ->where('level_name',$level)
                    ->get()
                    ->getrow();
               
                if($set_com){
                    $updatewhere = array(
                        'user_id' => $user_id
                    );
                    $leveldata = array(
                        'level' => $level
                    );
                    $data = $this->common_model->update('team_bonus',$updatewhere,$leveldata);
                    
                    $level_data = array(
                        'user_id'       =>@$user_id,
                        'level_id'      =>$level,
                        'achive_date'   =>date('Y-m-d h:i:s'),
                        'bonus'         =>@$set_com->team_bonous,
                        'status'        =>1);
                    $this->common_model->insert('user_level',$level_data);

                    #----------------------------
                    # sms send for  team bonus
                    #----------------------------                    
                    $new_balance = ($balance['balance']+$set_com->team_bonous);   

                    if(!empty($smsPermission) && $smsPermission->team_bonnus == 1){

                        $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $set_com->team_bonous,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'transfer_verification',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message = $this->common_model->sms_msg_generate($config_var, $template);

                        $send_sms = $this->sms_lib->send(array(
                            'to'            => $sponsers_info->phone, 
                            'message'       => $message['message'],
                        ));
                    }


                    #----------------------------
                    #      email verify smtp
                    #----------------------------
                    if(!empty($set) && $set->team_bonnus == 1){
                        $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $set_com->team_bonous,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'transfer_verification',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message = $this->common_model->email_msg_generate($config_var, $template);

                        $send_email = array(
                            'title'         => $appSetting->title,
                            'to'            => $sponsers_info->email,
                            'subject'       => $message['subject'],
                            'message'       => $message['message'],
                        );
                    
                    }
                    // Team Bonus Notification Insert
                    $notification = array(
                        'user_id'           => $sponsers_info->user_id,
                        'subject'           => $message['subject'],
                        'notification_type' => 'team_bonus',
                        'details'           => $message['message'],
                        'date'              => date('Y-m-d h:i:s'),
                        'status'            => '0'
                    );
                    $this->db->insert('notifications',$notification); 
                }
            }

        }

        return 1;

    }


    /***************************
    * buy_success function
    *
    * @param $package_id  $investment_id
    ***************************/

    public function buy_success($package_id,$investment_id)
    {
        $user_id = $this->session->userdata('user_id');
        $data['title']   = display('package'); 
        $where = array(
            'user_id' => $user_id
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        $packwhere = array(
            'package_id' => $package_id
        );
        
        $data['package'] = $this->common_model->read('package',$packwhere);
        $data['content'] = $this->BASE_VIEW .'\package_buy_recite';
        return $this->template->customer_layout($data);
       

    }

    /***************************
    *   check customer balance 
    *   @param pacakate id
    *   return array()
    ***************************/
    public function check_balance($package_id=NULL)
    {
        
        $packwhere = array(
            'package_id' => $package_id
        );
        
        $pak_info = $this->common_model->read('package',$packwhere); 
        $data = $this->package_model->get_cata_wais_transections();

        if($pak_info->package_amount <=$data['balance']){
            return $pak_info;

        }else {

            return $pak_info = array();

        }
        
    }

    /***************************
    *   check investment  
    *   @param user Id
    *   return number of rows
    ***************************/
    public function check_investment($user_id=NULL)
    {
        
        $investwhere = array(
            'user_id' => $user_id
        );
        return $this->common_model->countRow('investment',$investwhere);
        
    }

    /***************************
    *   SET LEVEL BY SPONSER  
    *   @param sponser id
    *   return ture or false
    ***************************/
    public function setUserLevel($sponsor_id)
    {
        $investwhere = array(
            'user_id' => $sponsor_id
        );
        $investment = $this->common_model->countRow('investment',$investwhere);
        
        $set           = $this->common_model->email_sms('email');
        $smsPermission = $this->common_model->email_sms('sms');
        $appSetting    = $this->common_model->get_setting();

        if($investment !=NUll){
            
            $sponsers_info_where = array(
                'user_id' => $sponsor_id
            );
            $sponsers_info = $this->common_model->read('user_registration',$sponsers_info_where);
           $sponserswhere  = array(
                'user_id' => $sponsor_id
            );
            $sponsers = $this->common_model->read('team_bonus',$sponserswhere);

            
            if(@$sponsers->sponser_commission!=0 && @$sponsers->team_commission!=0){

                $level = @$sponsers->level;
                $builder = $this->db->table('setup_commission');
                $setLevel = $builder->select('*')
                            ->where('total_invest<=',@$sponsers->team_commission)
                            ->where('level_name',$level)
                            ->get()
                            ->getRow();

                if($setLevel!=NULL){

                    $new_level = $level+1;
                    $upodatewhere = array(
                        'user_id' => $sponsor_id
                    );
                    $updatedata = array(
                        'level' => $new_level
                    );
                    $data = $this->common_model->update('team_bonus',$upodatewhere,$updatedata);
                    $levelcheckwhere = array(
                        'user_id' => $sponsor_id,
                        'level_id' => $level
                    );
                    $levelChack = $this->common_model->read('user_level',$levelcheckwhere);
                     if(empty($levelChack)){
                        $level_data = array(
                            'user_id'       => @$sponsor_id,
                            'level_id'      => @$level,
                            'achive_date'   => date('Y-m-d h:i:s'),
                            'bonus'         => 0.0,
                            'status'        => 1,
                        );
                        $this->common_model->insert('user_level',$level_data);
                    }

                    #----------------------------
                    # sms send for  team bonus
                    #----------------------------
                    $balance2 = $this->common_model->get_all_transection_by_user($sponsor_id);
                    
                    $new_balance2 = $balance2['balance'];

                    if(!empty($smsPermission) && $smsPermission->team_bonous == 1){

                         $this->load->library('sms_lib');
                        $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $set_com->team_bonous,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance2,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$new_level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'team_bonus',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message = $this->common_model->sms_msg_generate($config_var, $template);
                        $send_sms = $this->sms_lib->send(array(
                            'to'            => $sponsers_info->phone, 
                            'message'       => $message['message'],
                        ));

                    }

                    #----------------------------
                    #      email verify smtp
                    #----------------------------
                    if(!empty($set) && $set->team_bonous == 1){
                       $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $set_com->team_bonous,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'team_bonus',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message    = $this->common_model->email_msg_generate($config_var, $template);
                        $send_email = array(
                            'title'         => $appSetting->title,
                            'to'            => $sponsers_info->email,
                            'subject'       => $message['subject'],
                            'message'       => $message['message'],
                        );

                    }
                    $notification = array(
                        'user_id'           => $sponsers_info->user_id,
                        'subject'           => $message['subject'],
                        'notification_type' => 'team_bonus',
                        'details'           => $message['message'],
                        'date'              => date('Y-m-d h:i:s'),
                        'status'            => '0'
                    );
                    $this->common_model->insert('notifications',$notification);


                    return TRUE;

                } else {

                    return FALSE;
                    
                }

            } else{

                return FALSE;

            }

        }

    }

    /*
    |   SET LEVEL with Level bonus 
    |   @param sponser id
    |   return ture or false
    */
    public function setlevel_withbonus($sponsor_id)
    {
        $set           = $this->common_model->email_sms('email');
        $smsPermission = $this->common_model->email_sms('sms');
        $appSetting    = $this->common_model->get_setting();
        $investwhere = array(
            'user_id' => $sponsor_id
        );
        $investment = $this->common_model->countRow('investment',$investwhere);
       
        if($investment !=NUll){
             $sponsers_info_where = array(
                'user_id' => $sponsor_id
            );
            $sponsers_info = $this->common_model->read('user_registration',$sponsers_info_where);
           $sponsers2where = array(
                'user_id' => $sponsor_id
            );
            $sponsers2 = $this->common_model->read('team_bonus',$sponsers2where);

            if(@$sponsers2->sponser_commission!=0 && @$sponsers2->team_commission!=0){

                $level = @$sponsers2->level;
                $getbuilder = $this->db->table('setup_commission');
                $get_commi = $getbuilder->select('*')
                            ->where('personal_invest<=',@$sponsers2->sponser_commission)
                            ->where('total_invest<=',@$sponsers2->team_commission)
                            ->where('level_name',$level)
                            ->get()
                            ->getrow();   
                

                if($get_commi!=NULL){

                    $new_level = $level+1;
                    $updatewhere = array(
                        'user_id' => $sponsor_id
                    );
                    $updatedata = array(
                        'level' => $new_level
                    );
                    $data = $this->common_model->update('team_bonus',$updatewhere,$updatedata);
                      
                    
                    $level_data = array(
                        'user_id'     => @$sponsor_id,
                        'level_id'    => @$level,
                        'achive_date' => date('Y-m-d h:i:s'),
                        'bonus'       => @$get_commi->team_bonous,
                        'status'      => 1,
                    );
                    $this->common_model->insert('user_level',$level_data);

                    #----------------------------
                    # sms send for  team bonus
                    #----------------------------
                    $balance2 = $this->common_model->get_all_transection_by_user($sponsor_id);
                    $new_balance2 = $balance2['balance']+$get_commi->team_bonous;

                    if(!empty($smsPermission) && $smsPermission->team_bonnus){
                       $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $get_commi->team_bonous,
                            'balance'       => @$balance2['balance'],
                            'pre_balance'   => @$balance2['balance'],
                            'new_balance'   => @$new_balance2,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$new_level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'team_bonus',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message = $this->common_model->sms_msg_generate($config_var, $template);
                        $send_sms = $this->sms_lib->send(array(
                            'to'            => $sponsers_info->phone, 
                            'message'       => $message['message'],
                        ));
                    }

                    #----------------------------
                    #      email verify smtp
                    #----------------------------
                    if(!empty($set) && $set->team_bonnus){
                        $template = array( 
                            'fullname'      => $sponsers_info->f_name.' '.$sponsers_info->l_name,
                            'amount'        => $get_commi->team_bonous,
                            'balance'       => @$balance['balance'],
                            'pre_balance'   => @$balance['balance'],
                            'new_balance'   => @$new_balance2,
                            'user_id'       => $sponsers_info->user_id,
                            'receiver_id'   => $sponsers_info->user_id,
                            'verify_code'   => @$varify_code,
                            'stage'         => @$new_level,
                            'date'          => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'team_bonus',
                            'template_lang' => $sponsers_info->language=='english'?'en':'fr',
                        );
                        $message    = $this->common_model->email_msg_generate($config_var, $template);
                        $send_email = array(
                            'title'         => $appSetting->title,
                            'to'            => $sponsers_info->email,
                            'subject'       => $message['subject'],
                            'message'       => $message['message']
                        );                    
                    }

                   $notification = array(
                        'user_id'           => $sponsers_info->user_id,
                        'subject'           => $message['subject'],
                        'notification_type' => 'team_bonus',
                        'details'           => $message['message'],
                        'date'              => date('Y-m-d h:i:s'),
                        'status'            => '0'
                    );
                    $this->common_model->insert('notifications', $notification); 

                    return TRUE;

                } else {

                    return FALSE;

                }

            } else {
                return FALSE;

            } 

        }

    }
   
    public function my_package()
    {   
        $data['title']   = display('investment'); 
        $data['invest'] = $this->package_model->all_investment();
        $data['content'] = $this->BASE_VIEW .'\investment';
        return $this->template->customer_layout($data);
    }

}