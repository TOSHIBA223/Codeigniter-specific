<?php 
namespace App\Modules\Package\Models\Website;

class Package_model {

	function __construct() {
            $this->db =  db_connect();
            $this->tableName = 'user_registration';
            $this->primaryKey = 'uid';
         }

	/*public function registerUser($data = [])
	{	 
                $builder=$this->db->table('user_registration');
		$data['modified'] = date("Y-m-d H:i:s");  
		$data['created'] = date("Y-m-d H:i:s");
                return $builder->insert($data);
                

	}
	
	public function updateUser($data)
	{
            $data['modified'] = date("Y-m-d H:i:s");
            $builder=$this->db->table('user_registration');
                return $builder->where(array('email'=>$data['email']))
                               ->update($data);

	}
	public function activeAccountSelect($activecode='')
  	{   
	    $builder = $this->db->table('user_registration');
	    return $builder->select("user_registration.user_id")
	      			   ->where('user_id', $activecode);
  	}
	public function activeAccount($activecode='')
  	{
      	$data = array('status' => '1');
  
    	$builder=$this->db->table('user_registration');
        return $builder->where('user_id', $activecode)
                       ->update($data);
  	}
	public function checkUser($data = array())
	{
                $builder = $this->db->table('user_registration');
		$where = "(email ='".$data['email']."' OR username = '".$data['email']."')";
		return $builder->select("*")
			->where($where)
			->get();
	}

	public function checkDuplictemail($data = [])
	{
                $builder = $this->db->table('user_registration');
		return $builder->select("user_registration.email")
			->where('email', $data['email'])
			->get();
	}


	public function checkDuplictuser($data = [])
	{	 
                $builder = $this->db->table('user_registration');
		return $builder->select("user_registration.username")
			->where('username', $data['username'])
                        ->get()
			->getRow();
	}
        

	public function active_slider()
	{
                $builder = $this->db->table('web_slider');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('slider_id', 'asc')
			->get()
			->getResult();
	}

	public function social_link()
	{   
                $builder = $this->db->table('web_social_link');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('id', 'asc')
			->get()
			->getResult();
	}
	
	public function categoryList()
	{	 
                $builder = $this->db->table('web_category');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('position_serial', 'asc')
			->get()
			->getResult();
	}

	

	public function newsCatListBySlug($slug=NULL)
	{	 
                $builder = $this->db->table('web_category');
                $cat_id = $builder->select('cat_id')->where('slug', $slug)->get()->getRow();

		return $builder->select('*')
			->where('status', 1)
			->orderBy('cat_id', 'desc')
			->where('parent_id', $cat_id->cat_id)
			->get()
			->getResult();
	}*/
	public function cat_info($slug=NULL){
                $builder = $this->db->table('web_category');
		return $builder->select("*")
			->where('slug', $slug)
			->where('status', 1)
			->get()
			->getRow();
	}
	public function catidBySlug($slug=NULL){
                $builder = $this->db->table('web_category');
		return $builder->select("cat_id")
                                ->where('slug', $slug)
                                ->where('status', 1)
                                ->get()
                                ->getRow();
	}

	public function article($id=NULL, $limit=NULL){
                $builder = $this->db->table('web_article');
		return $builder->select("*")
                                ->where('cat_id', $id)
                                ->orderBy('position_serial', 'asc')
                                ->limit($limit)
                                ->get()
                                ->getResult();
	}

	public function package(){
                $builder = $this->db->table('package');
		return $builder->select("*")
                                ->get()
                                ->getResult();
	}
/*
	public function contentDetails($slug = null)
	{       
                $builder = $this->db->table('web_article');
		return $builder->select('*')
                                ->where('slug', $slug)
                                ->get()
                                ->getRow();
	}

	public function newsDetails($slug = null)
	{
                $builder = $this->db->table('web_news');
		return $builder->select('*')
			->where('slug', $slug)
			->get()
			->getRow();
	}

	public function cryptoCoin($limit, $offset)
	{
                $builder = $this->db->table('cryptolist');
		return $builder->select("*")
			->orderBy('SortOrder', 'asc')
			->limit($limit, $offset)
			->get()
			->getResult();
	}

	public function advertisement($id=NULL){
                $builder = $this->db->table('advertisement');
		return $builder->select("*")
			->where('page', $id)
			->where('status', 1)
			->orderBy('serial_position', 'asc')
			->get()
			->getResult();
	}
	public function webLanguage(){
                $builder = $this->db->table('web_language');
		return $builder->select('*')
			->where('id', 1)
			->get()
			->getRow();
	}
	public function findById($table, $where){
                $builder = $this->db->table($table);
		return $builder->select('*')
			->where($where)
			->get()
			->getRow();
	}*/


}