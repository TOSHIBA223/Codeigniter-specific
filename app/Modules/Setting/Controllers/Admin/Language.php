<?php 
namespace App\Modules\Setting\Controllers\Admin;

class Language extends BaseController {

    private $table  = "language";
    private $phrase = "phrase";

    public function index()
    {
            $data['title']     = "Language List";
            $data['languages']    = $this->languages();
            $data['content'] = $this->BASE_VIEW . '\language\main';
            return $this->template->admin_layout($data);

    }

    public function phrase()
    {
            #-------------------------------#
             #pagination starts
            #-------------------------------#
             $page           = ($this->uri->getSegment(4)) ? $this->uri->getSegment(4) : 0;
             $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
             $data["phrases"] = $this->phrases(20,($page_number-1)*20); 
             $total           = $this->common_model->countRow('language');
             $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
             #------------------------
             #pagination ends
             #------------------------
            $data['languages']    = $this->languages();
            $data['content'] = $this->BASE_VIEW . '\language\phrase';
            return $this->template->admin_layout($data);
        
    }
 

    public function languages()
    { 
            if ($this->db->tableExists($this->table)) { 

                $fields = $this->db->getFieldData($this->table);

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


    public function addLanguage()
    { 
            $language = preg_replace('/[^a-zA-Z0-9_]/', '', $this->request->getVar('language'));
            $language = strtolower($language);

            if (!empty($language)) {
                if (!$this->db->fieldExists($language, $this->table)) {
                    $this->dbforge->addColumn($this->table, [
                        $language => [
                            'type' => 'TEXT'
                        ]
                    ]); 
                    $this->session->setFlashdata('message', 'Language added successfully');
                    return  redirect()->to(base_url('backend/language/language_list'));
                } 
            }else{
                $this->session->setFlashdata('exception', 'Please try again');
            }
           return  redirect()->to(base_url('backend/language/language_list'));
    }


    public function editPhrase($language = null)
    { 

            #-------------------------------#
             #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(4)) ? $this->uri->getSegment(4) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data["phrases"] = $this->phrases(10,($page_number-1)*10); 
            $total           = $this->common_model->countRow('language');
            $data['pager']   = $this->pager->makeLinks($page_number, 10, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['language'] = $language;

            $data['content'] = $this->BASE_VIEW . '\language\phrase_edit';
            return $this->template->admin_layout($data);

    }

    public function addPhrase() 
    {  

        $lang = $this->request->getVar('phrase'); 

        if (sizeof($lang) > 0) {

            if ($this->db->tableExists($this->table)) {

                if ($this->db->fieldExists($this->phrase, $this->table)) {

                    foreach ($lang as $value) {

                        $value = preg_replace('/[^a-zA-Z0-9_]/', '', $value);
                        $value = strtolower($value);

                        if (!empty($value)) {
                            $num_rows = $this->common_model->countRow($this->table,[$this->phrase => $value]);


                            if ($num_rows == 0) { 
                                $this->common_model->insert($this->table,[$this->phrase => $value]); 
                                $this->session->setFlashdata('message', 'Phrase added successfully');
                            } else {
                                $this->session->setFlashdata('exception', 'Phrase already exists!');
                            }
                        }   
                    }  
                    return  redirect()->to(base_url('backend/language/phrase_list'));
                }  
            }
        }

        $this->session->setFlashdata('exception', 'Please try again');
        return  redirect()->to(base_url('backend/language/phrase_list'));
    }
 
    public function phrases($limit=null,$offset=null)
    {
            if ($this->db->tableExists($this->table)) {

                if ($this->db->fieldExists($this->phrase, $this->table)) {
                    $builder= $this->db->table('language');
                    return $builder->orderBy($this->phrase,'asc')
                        ->limit($limit,$offset)
                        ->get()
                        ->getResult();
                }  
            } 
            return false;
    }


    public function addLebel() { 
         
            $language = $this->request->getVar('language');
            $phrase   = $this->request->getVar('phrase');
            $lang     = $this->request->getVar('lang');

            if (!empty($language)) {

                if ($this->db->tableExists($this->table)) {
                    if ($this->db->fieldExists($language, $this->table)) {
                        if (sizeof($phrase) > 0)
                        for ($i = 0; $i < sizeof($phrase); $i++) {
                            $this->validation->setRule("$lang[$i]", display('lang[]'),'permit_empty|alpha_numeric_punct');
                            $where=array(
                                $this->phrase => $phrase[$i]
                            );
                            $setdata=array(
                                $language=>$lang[$i]
                            );
                            $this->common_model->update($this->table,$where,$setdata);
                        }  
                        $this->session->setFlashdata('message', 'Label added successfully!');
                        return  redirect()->to(base_url('backend/language/edit_phrase/'.$language));
                    }  
                }
            } 
          
            $error=$this->validation->listErrors();
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $error);
            }
        return  redirect()->to(base_url('backend/language/edit_phrase'.$language));
    }
}



 