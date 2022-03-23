<?php 
namespace App\Modules\Exchange\Models\Customer;
class Sell_model{
        
        function __construct() {
            $this->db = db_connect();
        }
	public function create($data = array())
	{
                $builder=$this->db->table('ext_exchange');
                return $builder->insert($data);
	}
	public function documentcreate($data = array())
	{       
                $builder=$this->db->table('ext_document');
                return $builder->insert($data);
	}

	public function single($ext_exchange_id = null)
	{
                $builder=$this->db->table('ext_exchange');
		return $builder->select('*')
			->where('ext_exchange_id', $ext_exchange_id)
			->get()
			->getRow();
	}

	public function update($data = array())
	{
                 $builder=$this->db->table('ext_exchange');
                 return $builder->where('ext_exchange_id',$data["ext_exchange_id"])
                                ->update($data);
	}

	public function findCurrency($cid = null)
	{
                $builder = $this->db->table('crypto_currency');
		return $builder->select('price_usd')
			->where('cid', $cid)
			->where('status', 1)
			->get()
			->getRow();
	}
        
	public function findExcCurrency()
	{
                $builder = $this->db->table('ext_exchange_wallet');
		return $builder->select('*')
			->where('status', 1)
			->get()
			->getResult();
	}
        
	public function findlocalCurrency()
	{
                $builder = $this->db->table('local_currency');
		return $builder->select('usd_exchange_rate, currency_name, currency_iso_code, currency_symbol, currency_position')
			->where('currency_id', 1)
			->get()
			->getRow();
	}
        
	public function findExchangeCurrency($coin_id = null)
	{
                $builder = $this->db->table('ext_exchange_wallet');
		return $builder->select('sell_adjustment, wallet_data, coin_name')
			->where('coin_id', $coin_id)
			->where('status', 1)
			->get()
			->getRow();
	}
}
