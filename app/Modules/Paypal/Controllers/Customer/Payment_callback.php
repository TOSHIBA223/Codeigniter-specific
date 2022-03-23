<?php 
namespace App\Modules\Paypal\Controllers\Customer;


class Payment_callback extends BaseController
{
	public function paypal_confirm(){

		if (isset($_GET['paymentId'])) {
                        
                        $builder = $this->db->table('payment_gateway');
			$gateway = $builder->select('*')->where('identity', 'paypal')->where('status',1)->get()->getrow();

			if ($gateway) {

				require APPPATH.'Modules/Paypal/libraries/paypal/vendor/autoload.php';

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

		$this->session->setFlashdata('exception', "Payment Canceled/Faild");
		return redirect()->to(base_url('customer/deposit/add_deposit'));


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