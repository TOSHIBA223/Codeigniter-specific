<?php 
namespace App\Modules\Paystack\Controllers\Customer;


class Payment_callback extends BaseController
{
	public function paystack_confirm(){

		$payment_type 	= $this->session->get('payment_type');
                $builder = $this->db->table('payment_gateway');
		$gateway 		= $builder->select('*')->where('identity', 'paystack')->where('status',1)->get()->getrow();


		$url = "https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$gateway->shop_id";
		if ($gateway->secret_key=='premium') {
			$url = "https://api.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$gateway->shop_id";
		}

		$json           = new \CodeIgniter\Files\File($url);
		$obj            = json_decode($json, true);
		$val            = floatval($obj['USD_NGN']);
		$total          = $val * (float)@$sdata->deposit_amount+(float)@$sdata->fees;
		$deposit_amount = number_format($total, 2, '.', '');
		$deposit_amount = $deposit_amount*100;

		$paystack = array(
			"secret_key"      => @$gateway->private_key,
			"publishable_key" => @$gateway->public_key
		);
               
        require APPPATH.'Modules/Paystack/libraries/paystack/vendor/autoload.php';
		
		$paystack = new \Yabacon\Paystack($paystack['secret_key']);
		$trx = $paystack->transaction->verify(
			[
				'reference'=> $_GET['reference']
			]
		);

		if(!$trx->status){
			exit($trx->message);
		}

		if('success' == $trx->data->status){

			if ($payment_type == 'deposit') {	    		

				$this->deposit_confirm();
                                return redirect()->to(base_url('customer/deposit/show_list'));
			}elseif ($payment_type == 'buy') {
                            
				if ($this->payment_model->create((array)$this->session->get('buy_save'))) {
                                    $this->session->remove('buy');
                                    $this->session->remove('buy_save');
                                    $this->session->remove('deposit');
                                    $this->session->remove('payment_type');
                                    $this->session->setFlashdata('message', display('payment_successfully'));
                                    return redirect()->to(base_url('customer/buy/buy_list'));
                                }else{
                                    $this->session->remove('buy');
                                    $this->session->remove('deposit');
                                    $this->session->remove('payment_type');
                                    $this->session->setFlashdata('exception', display('please_try_again'));
                                    return redirect()->to(base_url('customer/buy/buy_form'));
                                }

			}elseif ($payment_type == 'sell') {
				# code...

			}else {
				# code...

			}

		}



	}
	private function deposit_confirm(){

		$payment_type = $this->session->get('payment_type');
		$deposit      = $this->session->get('deposit');
		
        //Update session
		$deposit->status = 1;
		$this->session->remove('deposit');

        //Find same payment
		$same_payment = $this->db->query("SELECT * FROM `deposit` WHERE user_id='".$deposit->user_id."' AND deposit_amount	='".$deposit->deposit_amount."' AND fees='".$deposit->fees."' AND deposit_date='".$deposit->deposit_date."'")->getrow();

                //Store Data On Deposit
		if (!$same_payment) {

			$userinfo 	= $this->common_model->retriveUserInfo();

			$deposit_id     = $this->payment_model->save_transections((array)$deposit);
			
    		//User Financial Log
			if ($deposit_id) {

				
				$transections_data = array(
					'user_id'                   	=> $deposit->user_id,
					'transection_category'      	=> 'deposit',
					'releted_id'                	=> $deposit_id,
					'amount'                    	=> $deposit->deposit_amount,
					'transection_date_timestamp'	=> date('Y-m-d h:i:s'),
					'comments'                  	=> $deposit->comments,
					'status' 						=> 1
				);

				$this->payment_model->transections($transections_data);

			}		


			$set            = $this->common_model->email_sms('email');
			$smsPermission  = $this->common_model->email_sms('sms');
			$appSetting     = $this->common_model->get_setting();
			$user_lang      = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->get('user_id'))->get()->getRow();
			#----------------------------
		    #      email verify smtp
		    #----------------------------
		    $template = array( 
			    'fullname'      => $this->session->get('fullname'),
			    'amount'        => $deposit->deposit_amount,
			    'balance'       => @$blance['balance'],
			    'pre_balance'   => @$blance['balance'],
			    'new_balance'   => @$blance['balance'],
			    'user_id'       => $deposit->user_id,
			    'receiver_id'   => $deposit->user_id,
			    'verify_code'   => @$varify_code,
			    'date'          => date('d F Y')
			);
			$config_var = array( 
			    'template_name' => 'deposit_success',
			    'template_lang' => $user_lang->language=='english'?'en':'fr',
			);
			$message    = $this->common_model->email_msg_generate($config_var, $template);
			if(!empty($set) && $set->deposit == 1){

				$code_send = array(
				    'title'         => $appSetting->title,
				    'to'            => $this->session->get('email'),
				    'subject'       => $message['subject'],
				    'message'       => $message['message'],
				);
				$send_email = $this->common_model->send_email($code_send);
			}
			$notification2 = array(
				'user_id'           => $this->session->get('user_id'),
				'subject'           => display('diposit'),
				'notification_type' => 'deposit',
				'details'           => 'You Deposit The Amount Is $'.$deposit->deposit_amount.'.',
				'date'              => date('Y-m-d h:i:s'),
				'status'            => '0'
			);
			$this->common_model->insert('notifications',$notification2); 

            #------------------------------
		    #   SMS Sending
		    #------------------------------
			if(!empty($smsPermission) && $smsPermission->deposit == 1){

				$template = array( 
					'name'      		=> $this->session->get('fullname'),
					'amount'    		=> $deposit->deposit_amount,
                    'currency_symbol'   => 'usd',
					'date'      		=> date('d F Y')
				);
				if (@$userinfo->phone) {
					$send_sms = $this->sms_lib->send(array(
						'to'              => $this->session->get('phone'), 
						'message'       => $message['message']
					));
				} else {

					$this->session->setFlashdata('exception', display('there_is_no_phone_number'));
				}				
			}
                        
			$this->session->remove('payment_type');
			$this->session->setFlashdata('message', display('payment_successfully'));
                       
                       

		} else {
			$this->session->unset_userdata('payment_type');
			$this->session->set_flashdata('exception', display('please_try_again'));
                       

		}

	}
	
	
}