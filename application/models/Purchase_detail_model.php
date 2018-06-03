<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_detail_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_detail_pembelian';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

        $this->has_one['product'] = array('Product_model','id','id_produk');

		parent::__construct();
	}   
}
