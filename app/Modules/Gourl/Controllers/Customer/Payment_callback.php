<?php namespace App\Modules\Gourl\Controllers\Customer;


class Payment_callback extends BaseController
{


	public function bitcoin_confirm($orderidp = null){
       
		// Bitcoin Tranction log
		$order_id 		= explode('_', $orderidp);
		$payment_type 	= @$order_id['0'];
		$user_id 		= @$order_id['2'];
		$device 		= @$order_id['3'];

		$deposit      	= $this->db->table('crypto_payments')->select('*')->where('orderID', $orderidp)->get()->getRow();
		
		if ($payment_type == 'deposit' && $deposit) {
            
			$userinfo = $this->common_model->retriveUserInfo();
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
			$this->session->remove('deposit');
			$this->session->setFlashdata('message', display('payment_successfully'));

			$this->session->setFlashdata('message', "Payment successful, please wait for blockchain confirmation.It will take time.");
			return redirect()->to(base_url('customer/deposit/show_list'));

		}elseif ($payment_type == 'buy') {

			if ($this->buy_model->create((array)$this->session->get('buy_save'))) {
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

	public function bitcoin_cancel(){


	}

	public function gourl_callback(){
		require FCPATH.'app/Modules/Gourl/Libraries/gourl/lib/cryptobox.callback.php';

	}


	
}