<?php 
namespace App\Modules\Account\Models\Customer;

class Team_model {
        
        public function __construct()
        {
            $this->db = db_connect();
            $this->session = \Config\Services::session();
        }

	public function my_team($user_id)
	{       
                $userbuilder = $this->db->table("user_registration");
		$result1 = $userbuilder->select("*")
                                        ->where('sponsor_id',$user_id)
                                        ->get()
                                        ->getResult();

		$level_one 	= array();
		$level_two 	= array();
		$level_three    = array();
		$level_four     = array();
		$level_five     = array();


		$l  = 1;
		$l2 = 1;
		$l3 = 1;
		$l4 = 1;
		$l5 = 1;
		foreach ($result1 as $lv1) {
                        $investbuilder = $this->db->table('investment');
			$amount1 = $investbuilder->select("*")->where('user_id',$lv1->user_id)->get()->getResult();
			$level_one['user_id_'.$l] 	= $lv1->user_id;
			$level_one['username_'.$l] 	= $lv1->username;
			$level_one['name_'.$l] 		= $lv1->f_name.' '.$lv1->l_name;
			$level_one['sponser_id_'.$l]    = $lv1->sponsor_id;
			$level_one['amount_'.$l] 	= $amount1;
			
			#------------------------------
			# Laver Two Start             #
			#------------------------------
			$result2 = $userbuilder->select("*")
                                                ->where('sponsor_id',$lv1->user_id)
                                                ->get()
                                                ->getResult();

			
			$l2 = $l2;
			foreach ($result2 as $lv2) {
				$amount2 = $investbuilder->select("*")->where('user_id',$lv2->user_id)->get()->getresult();

				$level_two['user_id_'.$l2] 		= $lv2->user_id;
				$level_two['username_'.$l2]             = $lv2->username;
				$level_two['name_'.$l2] 		= $lv2->f_name.' '.$lv2->l_name;
				$level_two['sponser_id_'.$l2]           = $lv2->sponsor_id;
				$level_two['amount_'.$l2] 		= $amount2;
				
				#------------------------------
				# Lever Three Start           #
				#------------------------------
                                
				$result3 = $userbuilder->select("*")
                                                        ->where('sponsor_id',$lv2->user_id)
                                                        ->get()
                                                        ->getResult();

				$l3 = $l3;
				foreach ($result3 as $lv3) {
					$amount3 = $investbuilder->select("*")->where('user_id',$lv3->user_id)->get()->getresult();

					$level_three['user_id_'.$l3] 	= $lv3->user_id;
					$level_three['username_'.$l3] 	= $lv3->username;
					$level_three['name_'.$l3] 	= $lv3->f_name.' '.$lv3->l_name;
					$level_three['sponser_id_'.$l3]	= $lv3->sponsor_id;
					$level_three['amount_'.$l3] 	= $amount3;
					
					#------------------------------
					# Lever Four Start           #
					#------------------------------
					$result4 = $userbuilder->select("*")
                                                                ->where('sponsor_id',$lv3->user_id)
                                                                ->get()
                                                                ->getresult();


					$l4 = $l4;
					foreach ($result4 as $lv4) {
						$amount4 = $investbuilder->select("*")->where('user_id',$lv4->user_id)->get()->getresult();

						$level_four['user_id_'.$l4] 	= $lv4->user_id;
						$level_four['username_'.$l4] 	= $lv4->username;
						$level_four['name_'.$l4] 	= $lv4->f_name.' '.$lv4->l_name;
						$level_four['sponser_id_'.$l4]	= $lv4->sponsor_id;
						$level_four['amount_'.$l4] 	= $amount4;
						
						#------------------------------
						# Lever Five Start           #
						#------------------------------
						$result5 = $userbuilder->select("*")
						->where('sponsor_id',$lv4->user_id)
						->get()
						->getresult();

						$l5 = $l5;
						foreach ($result5 as $lv5) {
							$amount5 = $investbuilder->select("*")->where('user_id',$lv5->user_id)->get()->getresult();

							$level_five['user_id_'.$l5] 	= $lv5->user_id;
							$level_five['username_'.$l5] 	= $lv5->username;
							$level_five['name_'.$l5] 	= $lv5->f_name.' '.$lv5->l_name;
							$level_five['sponser_id_'.$l5]	= $lv5->sponsor_id;
							$level_five['amount_'.$l5] 	= $amount5;

							$level_five['num'] = $l5;
							$l5++;

						}
						#--------End Level Five--------------------#
						$level_four['num'] = $l4;
						$l4++;

					}					
					#--------End Level Four--------------------#
					$level_three['num'] = $l3;
					$l3++;

				}				
				#--------End Level Three--------------------#
				$level_two['num'] = $l2;
				$l2++;

			}			
			#--------------End Level Two----------------#
			$level_one['num'] = $l;
			$l++;

		}		
		#--------------End Level one----------------#

		$data = array(
			'level_one'     =>@$level_one,
			'level_two'     =>@$level_two,
			'level_three'   =>@$level_three,
			'level_four'    =>@$level_four,
			'level_five'    =>@$level_five,
		);
		
		return $data;
	}
}