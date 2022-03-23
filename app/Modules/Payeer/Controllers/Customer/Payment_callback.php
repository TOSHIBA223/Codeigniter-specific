<?php 
namespace App\Modules\Payeer\Controllers\Customer;


class Payment_callback extends BaseController
{

	public function payeer_success(){

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
	
}