<?php namespace App\Modules\Package\Controllers\Admin;
class Package extends BaseController {
	
 
   public function index()
    {  
            
            $data['title']  = display('package_list');
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(2)) ? $this->uri->getSegment(2) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            //$data['package']   = $this->package_model->read(20, $page);
            $data['package'] = $this->common_model->get_all('package', $pagewhere=array(),20,($page_number-1)*20,'package_id','DESC');
            $total              = $this->common_model->countRow('package');
            $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['content'] = $this->BASE_VIEW . '\list';
            return $this->template->admin_layout($data);
            /*$data['content'] = view("App\Modules\Package\Views\Admin\list", $data);
            return $this->template->admin_layout($data);*/
            
    }
 

   

 
    public function form($package_id = null)
    { 
        
        $this->validation     =  \Config\Services::validation();
        $data['title']  = display('add_package');
        if (!empty($package_id)){
              $this->validation->setRules(['package_name' => "required|max_length[250]|package_check[$package_id]"],['package_name' => [ 'package_check' => 'This Package is already registered.']]);      
        }else{
              $this->validation->setRule('package_name', display('package_name'), 'required|is_unique[package.package_name]|max_length[250]');
        }
        //check validation rules
        $this->validation->setRule('package_details', display('package_details'),'max_length[1000]');
        $this->validation->setRule('package_amount', display('package_amount'),'required|max_length[11]');
        $this->validation->setRule('daily_roi', display('daily_roi'),'required|max_length[11]');
        $this->validation->setRule('weekly_roi', display('weekly_roi'),'required|max_length[11]');
        $this->validation->setRule('monthly_roi', display('monthly_roi'),'required|max_length[11]');
        $this->validation->setRule('yearly_roi', display('yearly_roi'),'required|max_length[11]');
        $this->validation->setRule('total_percent', display('total_percent'),'required|max_length[11]');
        $this->validation->setRule('status', display('status'),'required|max_length[1]');
        $this->validation->setRule('period', display('period'),'required');
        
        $data['package'] = (object)$userdata = array(
                'package_id'      => $this->request->getVar('package_id',FILTER_SANITIZE_STRING),
                'package_name'      => $this->request->getVar('package_name',FILTER_SANITIZE_STRING),
                'period'            => $this->request->getVar('period',FILTER_SANITIZE_STRING),
                'package_deatils'   => $this->request->getVar('package_deatils',FILTER_SANITIZE_STRING), 
                'package_amount'    => $this->request->getVar('package_amount',FILTER_SANITIZE_STRING), 
                'daily_roi'         => $this->request->getVar('daily_roi',FILTER_SANITIZE_STRING),
                'weekly_roi'        => $this->request->getVar('weekly_roi',FILTER_SANITIZE_STRING),
                'monthly_roi'       => $this->request->getVar('monthly_roi',FILTER_SANITIZE_STRING), 
                'yearly_roi'        => $this->request->getVar('yearly_roi',FILTER_SANITIZE_STRING), 
                'total_percent'     => $this->request->getVar('total_percent',FILTER_SANITIZE_STRING), 
                'status'            => $this->request->getVar('status',FILTER_SANITIZE_STRING)
        );
      
        if ($this->validation->withRequest($this->request)->run()){
                
            if (empty($package_id)){
                if ($this->common_model->insert('package',$userdata)){
                    $this->session->setFlashdata('message', display('save_successfully'));
                }else{
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/package/add_package'));
            }else {
                $where = array( 
                    'package_id'            => $package_id
                );
                if($this->common_model->update('package',$where,$userdata)){
                    $this->session->setFlashdata('message', display('update_successfully'));
                }else{
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/package/edit_package/'.$package_id));
            }
        }
        if(!empty($package_id)){
            $data['title']          = display('edit_package');
            $where = array( 
                    'package_id'    => $package_id
                );
            $data['package']        = $this->common_model->read('package',$where);
        }
        $data['content'] = $this->BASE_VIEW . '\package_form';
        return $this->template->admin_layout($data);
    }


    public function delete($user_id = null)
    {  
        $where=array(
          'package_id'  =>   $user_id
        );
        if ($this->common_model->deleteRow('package',$where)) {
            $this->session->setFlashdata('message', display('delete_successfully'));
        } else {
            $this->session->setFlashdata('exception', display('please_try_again'));
        }
        return  redirect()->to(base_url('backend/package/package_list'));

    }

    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */
    

  
	
}
