<?php

namespace App\Modules\Auth\Controllers\Admin;


helper('date');
class Dashboard extends BaseController
{
    public function index()
    {
        if (!$this->session->get('isLogIn')) {
            return redirect()->route('login');
        }
        $data = $this->dashboard_model->get_cata_wais_transections();
        $data['title']   = display('home');
        $data['wrequest'] = $this->dashboard_model->withdraw_all_request();
        $data['exchange'] = $this->dashboard_model->exchange_all_request();
        $data['cryptocurrency'] = $this->dashboard_model->crypto_all_request();

        $data['investment']     = $this->db->query("SELECT MONTHNAME(`invest_date`) as month, SUM(`amount`) as investment FROM `investment` WHERE YEAR(`invest_date`) = '2018' GROUP BY YEAR(CURDATE()), MONTH(`invest_date`)")->getResult();
        $data['roi']            = $this->db->query("SELECT MONTHNAME(`date`) as month, SUM(`amount`) as roi FROM `earnings` WHERE YEAR(`date`) = '2018' GROUP BY YEAR(CURDATE()), MONTH(`date`)")->getResult();

        $data['transections']   = $this->db->query("SELECT `transection_category` as transection_category, SUM(`amount`) as transections FROM `transections` WHERE  status=1 AND (transection_category='deposit' OR transection_category='withdraw') AND YEAR(`transection_date_timestamp`) = '2018' GROUP BY `transection_category`")->getResult();


        $data['content'] = $this->BASE_VIEW . '\dashboard';
        return $this->template->admin_layout($data);
    }
    

    public function ajaxCheck()
    {
        if ($this->request->isAJAX()) {
            echo $this->request->getVar('id', FILTER_SANITIZE_STRING);
        }
    }
     public function my_payout()
        {   

            //$user_id = $this->session->userdata('user_id');
            $data['title']   = display('all_payout'); 
            
            #-------------------------------#
             #pagination starts
            #-------------------------------#
             $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
             $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
             $pagewhere = array( 
                     'earning_type'    => 'type2'
              );
             $data['my_payout'] = $this->common_model->get_all('earnings', $pagewhere,20,($page_number-1)*20,'earning_id','DESC');
             $total           = $this->common_model->countRow('earnings',$pagewhere);
             $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
             #------------------------
             #pagination ends
             #------------------------

             $data['content'] = $this->BASE_VIEW . '\my_payout';
            return $this->template->admin_layout($data);
        }

         public function comission()
        {   

            //$user_id = $this->session->userdata('user_id');
            $data['title']   = display('comission'); 
            
            #-------------------------------#
             #pagination starts
            #-------------------------------#
             $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
             $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
             $pagewhere = array( 
                     'earning_type'    => 'type1'
              );
             $data['my_payout'] = $this->common_model->get_all('earnings', $pagewhere,20,($page_number-1)*20,'earning_id','DESC');
             $total           = $this->common_model->countRow('earnings',$pagewhere);
             $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
             #------------------------
             #pagination ends
             #------------------------

             $data['content'] = $this->BASE_VIEW . '\comission';
             return $this->template->admin_layout($data);
        }
        public function investment()
        {   

            //$user_id = $this->session->userdata('user_id');
            $data['title']   = display('investment'); 
            
            #-------------------------------#
             #pagination starts
            #-------------------------------#
             $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
             $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
             
             $data['my_payout'] = $this->common_model->get_all('investment', $pagewhere=array(),20,($page_number-1)*20,'order_id','DESC');
             $total           = $this->common_model->countRow('investment',$pagewhere);
             $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
             #------------------------
             #pagination ends
             #------------------------

             $data['content'] = $this->BASE_VIEW . '\investment';
             return $this->template->admin_layout($data);
        }
}