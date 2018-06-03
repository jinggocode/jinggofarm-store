<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Ongkir_model extends MY_Model
{
	public function __construct()
	{
		$this->table = 'tb_ongkir';
		$this->primary_key = 'id';
		$this->protected = array('id');

		$this->has_one['kurir'] = array('Kurir_model', 'id', 'id_kurir');
		$this->has_one['kecamatan'] = array('W_kecamatan_model', 'id', 'id_kecamatan');

		parent::__construct();
	}
}
