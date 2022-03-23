<?php 
namespace App\Modules\Exchange\Models\Admin;

class Exchange_wallet_model  {
        
        public function __construct(){
            $this->db = db_connect();
        }

	public function activeCurrency()
	{
                $builder = $this->db->table('crypto_currency');
		return $builder->select('*')
			->where('status', 1)
			->get()
			->getResult();
	}
	public function findCurrency($cid = null)
	{
                $builder = $this->db->table('crypto_currency');
		return $builder->select('price_usd, id, name')
			->where('cid', $cid)
			->where('status', 1)
			->get()
			->getRow();
	}
}
