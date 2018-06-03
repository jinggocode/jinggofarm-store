<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class W_kecamatan_model extends MY_Model
{
	public function __construct()
	{
		$this->table = 'tb_w_kecamatan';
		$this->primary_key = 'id';
		$this->protected = array('id');

		$this->has_one['kabupaten'] = array('W_kabupaten_model', 'id', 'regency_id');

		parent::__construct();
	}
}
