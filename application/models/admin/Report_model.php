<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends MY_Model
{
	public function __construct()
	{
		$this->table = 'tb_produk';
		$this->primary_key = 'id';
		$this->protected = array('id');

		$this->has_one['kategori'] = array('Category_model', 'id', 'id_kategori');
		parent::__construct();
	}
	public function getDataReport($month = '', $year = '', $limit = '', $offset = '')
	{
		$query = $this->db->query("SELECT kode_pembelian, created_at, jumlah_bayar from tb_pembelian where month(`created_at`) =  '$month' AND year(`created_at`) =  '$year' AND status = '1' OR status = '2' OR status = '3' LIMIT $limit OFFSET $offset");

		return $query->result();
	}

	public function getRowReport($month = '', $year = '')
	{
		$query = $this->db->query("SELECT * FROM `tb_pembelian` where month(`created_at`) =  '$month' AND year(`created_at`) =  '$year' AND status = '0'");

		return $query->num_rows();
	}

	public function getTotal($month = '', $year = '')
	{
		$query = $this->db->query("SELECT sum(jumlah_bayar) as jumlah from tb_pembelian where month(`created_at`) = '$month' AND year(`created_at`) =  '$year' AND status = '1' OR status = '2' OR status = '3'");
 
		return $query->row();
	}

	public function getTotalProfit($month = '', $year = '')
	{
		$query = $this->db->query("SELECT sum(qty*harga_produksi) as biaya_produksi,  sum(qty*harga_jual) as biaya_jual from tb_detail_pembelian 
		JOIN tb_pembelian ON tb_pembelian.id = tb_detail_pembelian.id_pembelian
		JOIN tb_produk ON tb_produk.id = tb_detail_pembelian.id_produk
		WHERE tb_pembelian.`status` ='1' or  tb_pembelian.`status` ='2' or  tb_pembelian.`status` ='3'
		and month(tb_pembelian.created_at) = '$month' 
		AND year(tb_pembelian.created_at) =  '$year'
		");
 
		return $query->row();
	}
}
