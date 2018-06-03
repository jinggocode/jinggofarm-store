<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class W_kabupaten_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_w_kabupaten';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

		parent::__construct();
	}   
}
