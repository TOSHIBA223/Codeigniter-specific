<?php
namespace App\Modules\Account\Controllers\Customer;
class Auto_commission extends BaseController 
{
    

    public function payout(){

        $day = date('N');

        $investment = $this->db->table('investment')->select("*")
                        ->where('day',$day)
                        ->orderBy('order_id','DESC')
                        ->get()
                        ->getResult();

        if($investment!=NULL){

            foreach ($investment as  $value) {

                $date_1 = date_create(date('Y-m-d'));
                $date_2 = date_create($value->invest_date);
                $diff = date_diff($date_2, $date_1);

                $package_periodp = $this->db->table('package')->select('period')->where('package_id',$value->package_id)->get()->getRow();
                
                if ($package_periodp) {
                    $package_period = $package_periodp->period;

                }else{
                    $package_period = 0;
                    
                }

                if($diff->days>0  && $diff->days<=$package_period){
                    $days = floor($diff->format("%R%a")%7);
                
                } else {

                    $days = 1;

                }
                
                if($days==0){
                       $rio = $this->db->table('package')->select('package_id,weekly_roi')->where('package_id',$value->package_id)->get()->getRow();
                        $user_info = $this->db->table('user_registration')->select('user_id,f_name,l_name,username,phone,email')->where('user_id',$value->user_id)->get()->getRow();

                    $amount = $rio->weekly_roi;

                    $paydata = array(
                        'user_id'       => $value->user_id,
                        'Purchaser_id'  => $value->user_id,
                        'earning_type'  => 'type2',
                        'package_id'    => $value->package_id,
                        'order_id'      => $value->order_id,
                        'amount'        => $amount,
                        'date'          => date('Y-m-d'),
                    );

                    $check = $this->db->table('earnings')
                                        ->where('package_id',$value->package_id)
                                        ->where('order_id',$value->order_id)
                                        ->where('user_id',$value->user_id)
                                        ->where('earning_type','type2')
                                        ->where('date',date('Y-m-d'))
                                        ->countAllResults();
                    
                    if(empty($check)){
                        $user_lang      = $this->db->table('user_registration')->select('language')->where('user_id', $user_info->user_id)->get()->getRow();
                 
                        $this->common_model->insert('earnings',$paydata);
                        //get total balance
                        $balance = $this->common_model->get_all_transection_by_user($user_info->user_id);
                        
                        #----------------------------
                        # sms send to commission received
                        #----------------------------
                        $template = array(
                            'name'      => $user_info->f_name.' '.$user_info->l_name,
                            'new_balance'=> $balance['balance'],
                            'date'      => date('d F Y')
                        );
                        $config_var = array( 
                            'template_name' => 'payout',
                            'template_lang' => $user_lang->language=='english'?'en':'fr',
                        );
                        $message    = $this->common_model->email_msg_generate($config_var, $template);
                         $send_sms = $this->sms_lib->send(array(

                            'to'              => $user_info->phone, 
                            'message'        => $message['message']

                        ));
                        #----------------------------------
                        #   sms insert to received commission
                        #---------------------------------
                        if($send_sms){

                            $message_data = array(
                                'sender_id' =>1,
                                'receiver_id' => $user_info->user_id,
                                'subject' => 'Payout',
                                'message' => 'You received your payout. Your new balance is $'.$balance['balance'],
                                'datetime' => date('Y-m-d h:i:s'),
                            );

                            $this->common_model->insert('message',$message_data);
                        }
                        #------------------------------------- 

                        $set = $this->common_model->email_sms('email');
                        $appSetting = $this->common_model->get_setting();

                         
                    #--------------------------
                    #  email verify smtp mail
                    #--------------------------
                    $template = array( 
                        'fullname'      => $user_info->f_name.' '.$user_info->l_name,
                        'new_balance'   => $balance['balance'],
                        'date'          => date('d F Y')
                    );
                    
                    $config_var = array( 
                        'template_name' => 'payout',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);

                    $send_email = array(
                        'title'         => $appSetting->title,
                        'to'            => $user_info->email,
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                    );
                    
                    $code_send = $this->common_model->send_email($send_email);
                    if($code_send){
                        $message_data = array(
                            'sender_id'     => 1,
                            'receiver_id'   => $user_info->user_id,
                            'subject'       => $message['subject'],
                            'message'       => $message['message'],
                            'datetime'      => date('Y-m-d h:i:s'),
                        );
                        $this->common_model->insert('message',$message_data);
                        }

                    }
                }
            }
        }
    }

}