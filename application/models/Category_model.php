<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_kategori_produk';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

		parent::__construct();
	}   
}
