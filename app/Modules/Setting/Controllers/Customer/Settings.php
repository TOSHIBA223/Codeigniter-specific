<?php 
namespace App\Modules\Setting\Controllers\Customer;
class Settings extends BaseController
{
    


        public function language_setting()
        {
            $user_id = $this->session->userdata('user_id');
            $data['lang'] =$this->db->table('user_registration')->select('language')->where('user_id',$user_id)->get()->getRow();

            $data['title']   = display('language_setting'); 
            $data['languageList'] = $this->languageList(); 
            $data['content'] = $this->BASE_VIEW . '\settings\language_setting';
            return $this->template->customer_layout($data);
        }

        public function update_language()
        {
            $language = $this->request->getVar('language',FILTER_SANITIZE_STRING);
            $user_id = $this->session->userdata('user_id');

             $where = array(
                 'user_id' => $user_id
             );
             $data = array(
                 'language' => $language
             );
             $this->common_model->update('user_registration',$where,$data);
            
            $this->session->setFlashdata('message',display('update_successfully')); 
            return redirect()->to(base_url('customer/settings/language_setting'));
            
        }

        /*
        |-----------------------------------
        |   Bitcoin Settings View
        |-----------------------------------
        */
        public function payment_method_setting()
        {   
            $user_id = $this->session->userdata('user_id');
            $builder =$this->db->table('payment_metod_setting');
            $data['bitcoin'] = $builder->select('*')->where('user_id',$user_id)->where('method','bitcoin')->get()->getRow();
            $data['payeer'] = $builder->select('*')->where('user_id',$user_id)->where('method','payeer')->get()->getRow();
            $data['phone'] = $builder->select('*')->where('user_id',$user_id)->where('method','phone')->get()->getRow();
            $data['paypal'] = $builder->select('*')->where('user_id',$user_id)->where('method','paypal')->get()->getRow();
            $data['stripe'] = $builder->select('*')->where('user_id',$user_id)->where('method','stripe')->get()->getRow();
            $data['paystack'] = $builder->select('*')->where('user_id',$user_id)->where('method','paystack')->get()->getRow();

            $data['title']   = display('payment_method_setting');
            $data['content'] = $this->BASE_VIEW . '\settings\bitcoin_settings';
            return $this->template->customer_layout($data);  
        }


        /*
        |-----------------------------------
        |   Payeer Settings View
        |-----------------------------------
        */
        public function payment_method_update()
        { 

             $bitcoin = $this->request->getVar('bitcoin',FILTER_SANITIZE_STRING);  
             $payeer = $this->request->getVar('payeer',FILTER_SANITIZE_STRING);
             $phone = $this->request->getVar('phone',FILTER_SANITIZE_STRING);
             $paypal = $this->request->getVar('paypal',FILTER_SANITIZE_STRING);
             $stripe = $this->request->getVar('stripe',FILTER_SANITIZE_STRING);
             $paystack = $this->request->getVar('paystack',FILTER_SANITIZE_STRING);
             $user_id = $this->session->userdata('user_id');

            if($bitcoin!=NULL) {
                $data = array('user_id'=>$user_id,'method'=>$bitcoin,'wallet_id'=>$this->request->getVar('bitcoin_wallet_id',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$bitcoin)->get()->getRow();
                if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $bitcoin
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            } 


            if($payeer!=NULL) {

                $data = array('user_id'=>$user_id,'method'=>$payeer,'wallet_id'=>$this->request->getVar('payeer_wallet_id',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$payeer)->get()->getRow();

                if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $payeer
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            }


            if($phone!=NULL) {

                $data = array('user_id'=>$user_id,'method'=>$phone,'wallet_id'=>$this->request->getVar('phone_no',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$phone)->get()->getRow();

               if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $phone
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            } 


            if($paypal!=NULL) {
                $data = array('user_id'=>$user_id,'method'=>$paypal,'wallet_id'=>$this->request->getVar('phone_no',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$paypal)->get()->getRow();

                if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $paypal
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                    
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            }


            if($paystack!=NULL) {
                $data = array('user_id'=>$user_id,'method'=>$paystack,'wallet_id'=>$this->request->getVar('phone_no',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$paystack)->get()->getRow();

                if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $paystack
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                    
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            }


            if($stripe!=NULL) {
                $data = array('user_id'=>$user_id,'method'=>$stripe,'wallet_id'=>$this->request->getVar('phone_no',FILTER_SANITIZE_STRING));
                $builder =$this->db->table('payment_metod_setting');
                $check = $builder->select('*')->where('user_id',$user_id)->where('method',$stripe)->get()->getRow();

                if($check!=NULL) {
                    $where = array(
                        'user_id' => $user_id,
                        'method'  => $stripe
                    );
                    $this->common_model->update('payment_metod_setting',$where,$data);
                    
                } else {
                    $this->common_model->insert('payment_metod_setting',$data);
                }
            } 

            $this->session->setFlashdata('message',display('update_successfully')); 
            return redirect()->to(base_url('customer/settings/payment_method_setting'));

        }


    public function languageList()
    { 
       
        if ($this->db->tableExists("language")) { 
                    
                $fields = $this->db->getFieldData("language");
                $i = 1;
                foreach ($fields as $field)
                {  
                    if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
                }
                
                if (!empty($result)) 
                    return $result;
 

        } else {
            return false; 
            
        }
    }    


}
