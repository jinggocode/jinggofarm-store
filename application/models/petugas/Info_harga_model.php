<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Info_harga_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'info_harga';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

		parent::__construct();
	}   
}
