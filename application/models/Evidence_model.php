<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Evidence_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_bukti_transfer';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

		$this->has_one['pembelian'] = array('Purchase_model', 'id', 'id_pembelian');
		parent::__construct();
	}   
}
