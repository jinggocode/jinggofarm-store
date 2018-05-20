<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Kurir_model extends MY_Model
{
	public function __construct()
	{
		$this->table = 'tb_kurir';
		$this->primary_key = 'id';
		$this->protected = array('id');
   
		parent::__construct();
	}
}
