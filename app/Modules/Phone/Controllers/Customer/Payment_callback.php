<?php 
namespace App\Modules\Phone\Controllers\Customer;


class Payment_callback extends BaseController
{
	public function phone_confirm(){

		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit') {
			
			$payment_type 	= $this->session->get('payment_type');
			$deposit 	= $this->session->get('deposit');
			$userdata = array(
				'user_id'           => $deposit->user_id,
				'deposit_amount'    => $deposit->deposit_amount,
				'deposit_method'    => $deposit->deposit_method,
				'fees'              => $deposit->fees,
				'comments'          => $deposit->comments,
				'deposit_date'      => $deposit->deposit_date,
				'deposit_ip'        => $deposit->deposit_ip,
			);   	

	    	//Store Data On Deposit
			if ($this->payment_model->paymentStore($userdata)) {

				$this->session->remove('payment_type');
				$this->session->setFlashdata('message', "Wait for Confirmation");
                return redirect()->to(base_url('customer/deposit/add_deposit'));

			}
			else{
				$this->session->unset_userdata('payment_type');
				$this->session->setFlashdata('exception', display('please_try_again'));
                return redirect()->to(base_url('customer/deposit/add_deposit'));

			}

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

		$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		return redirect()->to(base_url('customer/deposit/show_list'));


	}

	public function phone_cancel(){

		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		redirect(base_url());    	

	}
	/*private function deposit_confirm(){

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
						'template'        => 'Hi, %name% You Deposit The Amount Is %currency_symbol% %amount% ', 
						'template_config' => $template, 
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

	}*/
	
	/*private function deposit_confirm($session_id){

		$payment_type = $this->session->get('payment_type');
		$deposit      = $this->session->get('deposit');
		
        //Update session
		$deposit->status = 1;
		$deposit->stripe_session_id = $session_id;
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
						'template'        => 'Hi, %name% You Deposit The Amount Is %currency_symbol% %amount% ', 
						'template_config' => $template, 
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

	}*/

	/*public function payeer_success(){

		$request = $this->request->getVar();

		$orderID 	= @$request['m_orderid'];
		$order_id 	= explode('_', $orderID);
		$payment_type 	= @$order_id['0'];
		$deposit_id 	= @$order_id['1'];
		$user_id 	= @$order_id['2'];
		$device 	= @$order_id['3'];

		if (@$request['m_status']=='success') {
    		// Payeer Tranction log

			if ($payment_type == 'deposit') {

				//Find same payment
                            
				$same_payment = $this->db->query("SELECT * FROM `deposit` WHERE user_id='".$user_id."' AND deposit_id ='".$deposit_id."' AND status	= 0")->row();

                                //Store Data On Deposit
				if ($same_payment) {
                                        $userbuilder = $this->db->table('user_registration');
					$userinfo = $this->db->select('*')->where('user_id', $user_id)->get()->getRow();
                                        $where = array(
                                            'user_id' => $same_payment->user_id,
                                        );
                                        $data = array(
                                            'status' => 1
                                        );
                                        $this->common_model->update('deposit',$where,$data);
					$deposit = (object)array(
						'user_id'        => $same_payment->user_id,
						'amount'         => $same_payment->deposit_amount,
						'method'         => $same_payment->deposit_method,
						'fees'           => $same_payment->fees,
						'comments'       => $same_payment->comments,
						'deposit_date'   => $same_payment->deposit_date,
						'deposit_ip'     => $same_payment->deposit_ip
					);


					$transections_data = array(
						'user_id'                   	=> $same_payment->user_id,
						'transection_category'      	=> 'deposit',
						'releted_id'                	=> $deposit_id,
						'amount'                    	=> $same_payment->deposit_amount,
						'comments'                  	=> $same_payment->comments,
						'transection_date_timestamp'	=> date('Y-m-d h:i:s')
					);

					$this->payment_model->transections($transections_data);	

					$set 			= $this->common_model->email_sms('email');
					$smsPermission 	= $this->common_model->email_sms('sms');
					$appSetting = $this->common_model->get_setting();

                    #----------------------------
				    #      email verify smtp
				    #----------------------------
					if(!empty($set) && $set->deposit == 1){
						$post = array(
							'title'      => $appSetting->title,
							'subject'    => 'Deposit',
							'to'         => $userinfo->email,
							'message'    => 'You Deposit The Amount $'.$deposit->amount.'.',
						);
						$send_email = $this->common_model->send_email($post);
					}

					$notifymessage = array(
						'user_id'           => $userinfo->user_id,
						'subject'           => display('diposit'),
						'notification_type' => 'deposit',
						'details'           => 'You Deposit The Amount is $'.$deposit->amount.'.',
						'date'              => date('Y-m-d h:i:s'),
						'status'            => '0'
					);
                    $this->common_model->insert('notifications',$notifymessage);

                    #------------------------------
				    #   SMS Sending
				    #------------------------------
					if(!empty($smsPermission) && $smsPermission->deposit == 1){
						$template = array( 
							'name'      		=> $userinfo->f_name.' '.$userinfo->l_name,
							'amount'    		=> $deposit->amount,
							'date'      		=> date('d F Y')
						);
						if (@$userinfo->phone) {
							$send_sms = $this->sms_lib->send(array(
								'to'              => $userinfo->phone, 
								'template'        => 'Hi, %name% You Deposit The Amount is $ %amount% ', 
								'template_config' => $template, 
							));
						} else {

							$this->session->setFlashdata('exception', display('there_is_no_phone_number'));
						}
					}

					$this->session->remove('payment_type');
					
					$this->session->setFlashdata('message', display('payment_successfully'));
					return redirect()->to(base_url('customer/deposit/show_list'));
					
				}

			} elseif ($payment_type == 'buy') {

				if ($this->buy_model->create((array)$this->session->get('buy'))) {
                                    $this->session->remove('buy');
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
		}else{

			$this->session->setFlashdata('exception', display('payment_cancel'));
			return redirect()->to(base_url('customer/deposit/add_deposit'));
		}

	}

	public function payeer_cancel(){

		$this->session->set_flashdata('exception', display('payment_cancel'));
		return redirect()->to(base_url('customer/deposit/add_deposit'));
	}


	public function banksuccess(){

		$request    = $this->input->get();
		$request1   = $this->input->post();       
	}

	public function bankfail(){

		$request    = $this->input->get();
		$request1   = $this->input->post();
	}

	public function paypal_confirm(){

		if (isset($_GET['paymentId'])) {
                        
                        $builder = $this->db->table('payment_gateway');
			$gateway = $builder->select('*')->where('identity', 'paypal')->where('status',1)->get()->getrow();

			if ($gateway) {

				require APPPATH.'libraries/paypal/vendor/autoload.php';

	            // After Step 1
				$apiContext = new \PayPal\Rest\ApiContext(
                                              new \PayPal\Auth\OAuthTokenCredential(
                                @$gateway->public_key,     // ClientID
                                @$gateway->private_key     // ClientSecret
                    )
				);

	            // Step 2.1 : Between Step 2 and Step 3
				$apiContext->setConfig(
					array(
						'mode'              => @$gateway->secret_key,
						'log.LogEnabled'    => true,
						'log.FileName'      => 'PayPal.log',
						'log.LogLevel'      => 'FINE'
					)
				);

	            // Get payment object by passing paymentId
				$paymentId = $_GET['paymentId'];

				$payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
				$payerId = $_GET['PayerID'];

	            // Execute payment with payer id
				$execution = new \PayPal\Api\PaymentExecution();
				$execution->setPayerId($payerId);

				try {
	              // Execute payment
					$result = $payment->execute($execution, $apiContext);

					$subtotal = $payment->transactions[0]->related_resources[0]->sale->amount->details->subtotal;


					if ($result) {
						$request = $this->request->getVar();
						$payment_type = $this->session->get('payment_type');

				    	// Paypal Tranction log
						$this->payment_model->paypalPaymentLog($request);

						if ($payment_type == 'deposit') {


							$deposit = $this->session->get('deposit');
							$this->session->unset_userdata('deposit');
							$sdata['deposit']   = (object)$userdata = array(
								'user_id'           => $deposit->user_id,
								'deposit_amount'    => $subtotal - $deposit->fees,
								'deposit_method'    => $deposit->deposit_method,
								'fees'              => $deposit->fees,
								'comments'          => $deposit->comments,
								'status'            => 1,
								'deposit_date'      => $deposit->deposit_date,
								'deposit_ip'        => $deposit->deposit_ip,
							);

							$deposit = $this->session->set($sdata);

							$this->deposit_confirm();
                                                        return redirect()->to(base_url('customer/deposit/show_list'));
                                        
						}elseif ($payment_type == 'buy') {
                                                    if ($this->buy_model->create((array)$this->session->get('buy'))) {
                                                        $this->session->remove('buy');
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


				} catch (PayPal\Exception\PayPalConnectionException $ex) {
					echo $ex->getCode();
					echo $ex->getData();
					die($ex);

				} catch (Exception $ex) {
					die($ex);

				}
			}

		}

	}


	public function paypal_cancel(){

		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		return redirect()->to(base_url('customer/deposit/add_deposit'));


	}

	private function errorAndDie($error_msg,$cp_debug_email) {

		if (!empty($cp_debug_email)) { 
			$report = 'Error: '.$error_msg."\n\n"; 
			$report .= "POST Data\n\n"; 
			foreach ($_POST as $k => $v) { 
				$report .= "|$k| = |$v|\n"; 
			} 
			mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
		} 
		die('IPN Error: '.$error_msg);

	} 


	public function conipayment_confirm(){


		$gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'coinpayment')->where('status', 1)->get()->row();

		if (is_string($gateway->data) && is_array(json_decode($gateway->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {
                    
			$data 	        = json_decode(@$gateway->data, true);
			$cp_merchant_id = @$data['marcent_id'];
			$cp_ipn_secret 	= @$data['ipn_secret'];
			$debug_active	= @$data['debuging_active'];
			$debug_email 	= @$data['debug_email'];

		} else {

			$cp_merchant_id = "";
			$cp_ipn_secret 	= "";
			$debug_active	= "";
			$debug_email 	= "";
		}

		$order_currency	= $this->input->post("currency1",TRUE);
		$amount1 		= number_format((float)($this->input->post("amount1",TRUE)), 8, '.', '');
		$order_total 	= $amount1;

		$feesamount 	= !empty($this->input->post("custom",TRUE))?$this->input->post("custom",TRUE):0;
		$depositAmount	= $amount1-$feesamount;

		$reg = array(

			'amount1'			=>$this->input->post("amount1",TRUE),
			'amount2'			=>$this->input->post("amount2",TRUE),
			'buyer_name'                    =>$this->input->post("buyer_name",TRUE),
			'currency1'			=>$this->input->post("currency1",TRUE),
			'currency2'			=>$this->input->post("currency2",TRUE),
			'fee'				=>$this->input->post("fee",TRUE),
			'ipn_id'			=>$this->input->post("ipn_id",TRUE),
			'ipn_mode'			=>$this->input->post("ipn_mode",TRUE),
			'ipn_type'			=>$this->input->post("ipn_type",TRUE),
			'ipn_version'                   =>$this->input->post("ipn_version",TRUE),
			'merchant'			=>$this->input->post("merchant",TRUE),
			'received_amount'               =>$this->input->post("received_amount",TRUE),
			'received_confirms'             =>$this->input->post("received_confirms",TRUE),
			'status'			=>$this->input->post("status",TRUE),
			'status_text'                   =>$this->input->post("status_text",TRUE),
			'txn_id'			=>$this->input->post("txn_id",TRUE)

		);

		$date 			= new DateTime();
		$deposit_date           = $date->format('Y-m-d H:i:s');

		$wheredata 		= "txn_id='".$this->input->post("txn_id",TRUE)."' AND user_id!=''";

		$instantdata            = $this->db->select("*")->from("coinpayments_payments")->where($wheredata)->get()->row();

		$dbt_deposit_data 		= array(

			'user_id'			=> @$instantdata->user_id,
			'currency_symbol'	=> @$this->input->post("currency2",TRUE),
			'amount'         	=> @$this->input->post("amount2",TRUE),
			'method_id'      	=> @$gateway->identity,
			'fees_amount'    	=> @$feesamount,
			'comment'        	=> @$this->input->post("txn_id",TRUE),
			'status'         	=> 0,
			'deposit_date'   	=> @$deposit_date,
			'ip'             	=> @$this->input->ip_address()

		);

		if (!$this->input->post("ipn_mode",TRUE) || $this->input->post("ipn_mode",TRUE)!= 'hmac') { 

			if($debug_active==1){
				$this->errorAndDie('IPN Mode is not HMAC',$debug_email);
			}
		}

		if (!$this->input->server("HTTP_HMAC") || empty($this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('No HMAC signature sent.',$debug_email);
			}
		} 

		$request = file_get_contents('php://input'); 
		if ($request === FALSE || empty($request)) {

			if($debug_active==1){
				$this->errorAndDie('Error reading POST data',$debug_email);
			}

		} 

		if (!$this->input->post("merchant",TRUE) || $this->input->post("merchant",TRUE) != trim($cp_merchant_id)) {

			if($debug_active==1){
				$this->errorAndDie('No or incorrect Merchant ID passed',$debug_email);
			}
		} 

		$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
		if (!hash_equals($hmac, $this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('HMAC signature does not match',$debug_email);
			}
		}

		$txn_id 		= $this->input->post("txn_id",TRUE); 
		$item_name 		= $this->input->post("item_name",TRUE); 
		$item_number	= $this->input->post("item_number",TRUE);
		$amount1 		= number_format((float)($this->input->post("amount1",TRUE)),8, '.', '');
		$amount2 		= number_format((float)($this->input->post("amount2",TRUE)),8, '.', '');
		$currency1 		= $this->input->post("currency1",TRUE); 
		$currency2 		= $this->input->post("currency2",TRUE); 
		$status 		= intval($this->input->post("status",TRUE)); 
		$status_text 	= $this->input->post("status_text",TRUE);

		if ($currency1 != $order_currency) {

			if($debug_active==1){
				$this->errorAndDie('Original currency mismatch!',$debug_email);
			}

		}

		if ($amount1 < $order_total) {

			if($debug_active==1){
				$this->errorAndDie('Amount is less than order total!',$debug_email);
			}

		} 

		if ($status >= 100 || $status == 2) {

			$dbt_deposit_check = $this->db->select('*')->from("dbt_deposit")->where("user_id",@$instantdata->user_id)->where("comment",$this->input->post("txn_id",TRUE))->where("status",1)->get()->num_rows();

			if(@$dbt_deposit_check==0){

				$this->payment_model->coinpaymentsPaymentLog($reg);
				
				$balance_add = array(
					'user_id'           => @$instantdata->user_id,
					'currency_symbol'   => @$this->input->post("currency2",TRUE), 
					'amount'           	=> $depositAmount,
					'last_update' 		=> @$deposit_date,
				);

				$deposit_balance 	= $this->payment_model->coinpayments_balanceAdd($balance_add);;

				if ($deposit_balance) {

					$depositdata = array(
						'user_id'            => @$instantdata->user_id,
						'balance_id'         => @$deposit_balance,
						'currency_symbol'    => @$this->input->post("currency2",TRUE),
						'transaction_type'   => 'DEPOSIT',
						'transaction_amount' => $depositAmount,
						'transaction_fees' 	 => $feesamount,
						'ip'                 => @$this->input->ip_address(),
						'date'               => @$deposit_date
					);
					$this->payment_model->balancelog($depositdata);

				}

				$date 			= new DateTime();
				$deposit_date 	= $date->format('Y-m-d H:i:s');

				$confirmdeposit = array(

					'depositdate'		=> $deposit_date,
					'user_id'			=>@$instantdata->user_id,
					'comment'			=>@$txn_id,
					'currency_symbol'	=>@$currency2

				);
				$this->payment_model->confirm_coinpayment_deposit($confirmdeposit);
				$this->refferalbonus(@$this->input->post("amount2",TRUE),@$this->input->post("currency2",TRUE),@$instantdata->user_id);
			}
		}
		else if ($status < 0) {

			$this->payment_model->coinpaymentsPaymentLog($reg);

			if($status==-1){
				$this->coinpayments_cancel();
			}

		} else {

			$this->payment_model->coinpaymentsPaymentLog($reg);

			$dbt_deposit = $this->db->select('*')->from("dbt_deposit")->where("comment",$this->input->post("txn_id",TRUE))->get()->row();
			if(!$dbt_deposit){
				$this->payment_model->paymentStore($dbt_deposit_data);
			}
		}
	}

	public function coinpayments_cancel(){

		$this->session->set_flashdata('exception', "Payment Canceled/Failed");

	}

	public function conipayment_withdraw()
	{
		$gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'coinpayment')->where('status', 1)->get()->row();

		if (is_string($gateway->data) && is_array(json_decode($gateway->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

			$data 			= json_decode(@$gateway->data, true);
			$cp_merchant_id = @$data['marcent_id'];
			$cp_ipn_secret 	= @$data['ipn_secret'];
			$debug_active	= @$data['debuging_active'];
			$debug_email 	= @$data['debug_email'];

		}
		else{

			$cp_merchant_id = "";
			$cp_ipn_secret 	= "";
			$debug_active	= "";
			$debug_email 	= "";

		}

		if (!$this->input->post("ipn_mode",TRUE) || $this->input->post("ipn_mode",TRUE)!= 'hmac') { 

			if($debug_active==1){
				$this->errorAndDie('IPN Mode is not HMAC',$debug_email);
			}
			
		}

		if (!$this->input->server("HTTP_HMAC") || empty($this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('No HMAC signature sent.',$debug_email);
			}

		} 

		$request = file_get_contents('php://input'); 
		if ($request === FALSE || empty($request)) {

			if($debug_active==1){
				$this->errorAndDie('Error reading POST data',$debug_email);
			}

		} 

		if (!$this->input->post("merchant",TRUE) || $this->input->post("merchant",TRUE) != trim($cp_merchant_id)) {

			if($debug_active==1){
				$this->errorAndDie('No or incorrect Merchant ID passed',$debug_email);
			}

		}

		$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
		if (!hash_equals($hmac, $this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('HMAC signature does not match',$debug_email);
			}

		}

		$status 		= intval($this->input->post("status",TRUE)); 
		$status_text 	= $this->input->post("status_text",TRUE);

		if ($status >= 100 || $status == 2) {
			
			$set_status   = 1;
			$wheredata 		= "txn_id='".$this->input->post("id",TRUE)."' AND user_id!=''";
			$instantdata	= $this->db->select("*")->from("coinpayments_payments")->where($wheredata)->get()->row();
			$user_id      = $instantdata->user_id;

			$dbt_withdraw_check = $this->db->select('*')->from("dbt_withdraw")->where("user_id",@$instantdata->user_id)->where("comment",$this->input->post("id",TRUE))->where("status",1)->get()->num_rows();

			if(@$dbt_withdraw_check==0){

				$data         = array(
					'success_date' 	=>date('Y-m-d h:i:s'),
					'status' 		=> $set_status,
				);

				$wheredata = array(

					'user_id'			=>$user_id,
					'comment'			=>$this->input->post('id',TRUE)
				);

				$this->db->where($wheredata)->update('dbt_withdraw', $data);

				$t_data     = $this->db->select('*')->from('dbt_withdraw')->where($wheredata)->get()->row();

				$userinfo   =  $this->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();
				

				$set        	= $this->common_model->email_sms('email');
				$smsPermission  = $this->common_model->email_sms('sms');
				$appSetting = $this->common_model->get_setting();

				$reg = array(
					'amount1'			=>$this->input->post("amount",TRUE),
					'amount2'			=>$this->input->post("amount",TRUE),
					'buyer_name'		=>'',
					'currency1'			=>$this->input->post("currency",TRUE),
					'currency2'			=>$this->input->post("currency",TRUE),
					'fee'				=>'',
					'ipn_id'			=>$this->input->post("ipn_id",TRUE),
					'ipn_mode'			=>$this->input->post("ipn_mode",TRUE),
					'ipn_type'			=>$this->input->post("ipn_type",TRUE),
					'ipn_version'		=>$this->input->post("ipn_version",TRUE),
					'merchant'			=>$this->input->post("merchant",TRUE),
					'received_amount'	=>'',
					'received_confirms'	=>'',
					'status'			=>$this->input->post("status",TRUE),
					'status_text'		=>$this->input->post("status_text",TRUE),
					'txn_id'			=>$this->input->post("txn_id",TRUE)

				);

				$this->payment_model->coinpaymentsPaymentLog($reg);

				$withdrawamount = $this->input->post("amount",TRUE);


				if(!empty($set) && $set->withdraw == 1){

					$check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $user_id)->where('currency_symbol', $this->input->post('currency',TRUE))->get()->row();
					$new_balance = $check_user_balance->balance-$withdrawamount;


					$this->db->set('balance', $new_balance)->where('user_id', $user_id)->where('currency_symbol', $this->input->post('currency',TRUE))->update("dbt_balance");

		            //User Financial Log
					if ($check_user_balance) {

						$depositdata = array(
							'user_id'            => $user_id,
							'balance_id'         => $check_user_balance->id,
							'currency_symbol'    => $t_data->currency_symbol,
							'transaction_type'   => 'WITHDRAW',
							'transaction_amount' => $t_data->amount,
							'transaction_fees'   => $t_data->fees,
							'ip'                 => $t_data->ip,
							'date'               => $t_data->request_date
						);

						$this->payment_model->balancelog($depositdata);

					}

		            #----------------------------
		            #      email verify smtp
		            #----------------------------
		            if(!empty($set) && $set->withdraw == 1){
						$post = array(
							'title'    => $appSetting->title,
							'subject'  => 'Withdraw',
							'to'       => $this->session->get('email'),
							'message'  => 'You successfully withdraw the amount Is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
						);
						$send = $this->common_model->send_email($post);
					}
				}

				$notification1 = array(
					'user_id'           => $user_id,
					'subject'           => display('withdraw'),
					'notification_type' => 'withdraw',
					'details'           => 'You successfully withdraw the amount Is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
					'date'              => date('Y-m-d h:i:s'),
					'status'            => '0'
				);
				$this->db->insert('notifications',$notification1);

				if(!empty($smsPermission) && $smsPermission->withdraw == 1){
					#----------------------------
		            #      Sms verify
		            #---------------------------
					$template = array( 
						'name'      => $userinfo->first_name." ".$userinfo->last_name,
						'amount'    => $t_data->amount,
						'new_balance' => $new_balance,
						'date'      => date('d F Y')
					);

					if (@$userinfo->phone) {
						$send_sms = $this->sms_lib->send(array(
							'to'       => $userinfo->phone, 
							'subject'         => 'Withdraw',
							'template'         => 'You successfully withdraw the amount is %amount% from your account. Your new balance is %new_balance%', 
							'template_config' => $template, 
						));

					} else {

						$this->session->set_flashdata('exception', display('there_is_no_phone_number'));
					}
				}
			}
		}
	}


	public function stripe_confirm(){


		$token  = $this->request->getVar('stripeToken',FILTER_SANITIZE_STRING);
		$email  = $this->request->getVar('stripeEmail',FILTER_SANITIZE_STRING);
		$deposit = $this->session->get('deposit');

                $builder = $this->db->table('payment_gateway');
		$gateway = $builder->select('*')->where('identity', 'stripe')->where('status',1)->get()->getrow();

		if ($gateway) {

			require_once APPPATH.'Libraries/stripe/vendor/autoload.php';

			$stripe = array(
				"secret_key"      => @$gateway->private_key,
				"publishable_key" => @$gateway->public_key
			);

			\Stripe\Stripe::setApiKey($stripe['secret_key']);

			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));

			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => round((@$deposit->deposit_amount+@$deposit->fees)*100),
				'currency' => 'usd'
			));


			if ($charge) {

				$payment_type = $this->session->get('payment_type');

		    	// Paypal Tranction log

				if ($payment_type == 'deposit') {	    		
                                    
                                            $this->deposit_confirm();
                                            return redirect()->to(base_url('customer/deposit/show_list'));
                                        
				}elseif ($payment_type == 'buy') {
                        
					if ($this->buy_model->create((array)$this->session->get('buy'))) {
						$this->session->remove('buy');
						$this->session->remove('deposit');
						$this->session->remove('payment_type');
						$this->session->setFlashdata('message', display('payment_successfully'));
						return redirect()->to(base_url('customer/buy/buy_list'));
					}
					else{
						$this->session->remove('buy');
						$this->session->remove('deposit');
						$this->session->remove('payment_type');
						$this->session->setFlashdata('exception', display('please_try_again'));
						return redirect()->to(base_url('customer/buy/buy_form'));
                                                //redirect("customer/buy");
					}

				}elseif ($payment_type == 'sell') {
					# code...

				}else {
					# code...

				}

			}

		}

	}

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
               
               require APPPATH.'libraries/paystack/vendor/autoload.php';
		
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
                            
				if ($this->buy_model->create((array)$this->session->get('buy'))) {
                                    $this->session->remove('buy');
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


	public function stripe_cancel(){

		$this->session->setFlashdata('exception', "Payment Canceled/Failed");
        return redirect()->to(base_url('customer/deposit/add_deposit'));

	}


	public function phone_confirm(){

		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit') {
			
			$payment_type 	= $this->session->get('payment_type');
			$deposit 	= $this->session->get('deposit');
			$userdata = array(
				'user_id'           => $deposit->user_id,
				'deposit_amount'    => $deposit->deposit_amount,
				'deposit_method'    => $deposit->deposit_method,
				'fees'              => $deposit->fees,
				'comments'          => $deposit->comments,
				'deposit_date'      => $deposit->deposit_date,
				'deposit_ip'        => $deposit->deposit_ip,
			);   	

	    	//Store Data On Deposit
			if ($this->payment_model->paymentStore($userdata)) {

				$this->session->remove('payment_type');
				$this->session->setFlashdata('message', "Wait for Confirmation");
                return redirect()->to(base_url('customer/deposit/add_deposit'));

			}
			else{
				$this->session->unset_userdata('payment_type');
				$this->session->setFlashdata('exception', display('please_try_again'));
                return redirect()->to(base_url('customer/deposit/add_deposit'));

			}

		}elseif ($payment_type == 'buy') {
			if ($this->buy_model->create((array)$this->session->get('buy'))) {
                            $this->session->remove('buy');
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

		$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		return redirect()->to(base_url('customer/deposit/show_list'));


	}

	public function phone_cancel(){

		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		redirect(base_url());    	

	}


	public function token_confirm(){

		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit') {
			
			$payment_type = $this->session->get('payment_type');
			$deposit = $this->session->get('deposit');	    	

	    	//Store Data On Deposit
			if ($this->payment_model->paymentStore($deposit)) {

				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('message', "Wait for Confirmation");
				redirect("balances");

			}
			else{
				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('exception', display('please_try_again'));
				redirect("balances");

			}

		}elseif ($payment_type == 'buy') {
			# code...

		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

		$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		redirect(base_url());


	}

	public function token_cancel(){


		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		redirect(base_url());    	

	}


	public function bank_confirm(){

		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit') {
			
			$payment_type = $this->session->get('payment_type');
			$deposit = $this->session->get('deposit');	    	

	    	//Store Data On Deposit
			if ($this->payment_model->paymentStore($deposit)) {

				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('message', "Wait for Confirmation");
				redirect("balances");

			}
			else{
				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('exception', display('please_try_again'));
				redirect("balances");

			}

		}elseif ($payment_type == 'buy') {
			if ($this->buy_model->create($this->session->get('buy'))) {
				$this->session->unset_userdata('buy');
				$this->session->unset_userdata('deposit');
				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('message', display('payment_successfully'));
				redirect("customer/buy");
			}
			else{
				$this->session->unset_userdata('buy');
				$this->session->unset_userdata('deposit');
				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('exception', display('please_try_again'));
				redirect("customer/buy");
			}

		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

		$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		redirect(base_url());


	}

	public function bank_cancel(){


		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		redirect(base_url());    	

	}*/

	/*private function deposit_confirm(){

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
						'template'        => 'Hi, %name% You Deposit The Amount Is %currency_symbol% %amount% ', 
						'template_config' => $template, 
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

	}*/

}