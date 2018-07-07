<?php

/**
 *
 */
class Purchase extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->root_view = "admin/";
		$this->load->model('admin/purchase_model');
		$this->load->model('admin/category_model');
		$this->load->model('evidence_model');
		$this->load->model('product_model');
		$this->load->model('purchase_detail_model');
		$this->slug_config($this->purchase_model->table, 'nama');
	}

	public function index()
	{
		// pagination
		$filter = $this->session->userdata('filter_item');
		$start = $this->uri->segment(4, 0);
		$config['base_url'] = base_url() . 'admin/purchase/index/';

		// Class bootstrap pagination yang digunakan
		$config['full_tag_open'] = "<ul class='pagination pagination-sm no-margin pull-right'>";
		$config['full_tag_close'] = "</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config['per_page'] = 10;

		$data = $this->purchase_model
			->with_user()
			->where('status', 'not like', '1')
			->where('status', 'not like', '0')
			->where('status', 'not like', '4') 
			->order_by('status', 'ASC')
			->limit($config['per_page'], $offset = $start)
			->get_all();

		$config['total_rows'] = $this->purchase_model
			->where('status', 'not like', '1')
			->where('status', 'not like', '0')
			->where('status', 'not like', '4')
			->count_rows();

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'data' => $data,
			'validasi_transfer' => $this->evidence_model->with_pembelian()->where('status', '0')->get_all(),
			'jumlah_transfer' => $this->evidence_model->where('status', '0')->count_rows(),
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
			'filter' => $this->session->userdata('filter_cattle'),
			'page' => $this->uri->segment(2),
		);

		$this->generateCsrf();
		$this->render('admin/purchase/index', $data);
	}
	public function search()
	{
		$search_data = $this->input->get();

		$data = $this->purchase_model->search($search_data);

		$this->generateCsrf();
		$this->render('admin/purchase/index', $data);
	}

	public function kirim_resi()
	{
		$data['no_resi'] = $this->input->post('no_resi');
		$data['status'] = '3';
		$this->purchase_model->update($data, $this->input->post('id'));

		$this->message('Resi berhasil di Kirim', 'success');
		$this->go('admin/purchase'); //redirect ke purchase
	}

	public function view($id)
	{
		$data['data'] = $this->purchase_model->get($id); 
		$data['list_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();

		$data['page'] = $this->uri->segment(2);
		$this->render('admin/purchase/view', $data);
	}

	public function valid($id)
	{
		$this->evidence_model->update(array('status' => '1'), $id);
		$bukti_tf = $this->evidence_model->get($id);

		$this->purchase_model->update(array('status' => '2'), $bukti_tf->id_pembelian);

		$list_pembelian = $this->purchase_detail_model->where('id_pembelian', $bukti_tf->id_pembelian)->get_all();

		foreach ($list_pembelian as $value) {
			$produk = $this->product_model->get($value->id_produk);
			$this->product_model->update(array('sisa_stok' => $produk->sisa_stok - $value->qty), $value->id_produk);
		}
		$this->message('Berhasil di Konfirmasi', 'success');
		$this->go('admin/purchase'); //redirect ke purchase
	}

	public function unvalid($id)
	{
		$this->evidence_model->update(array('status' => '1'), $id);
		$bukti_tf = $this->evidence_model->get($id);

		$this->purchase_model->update(array('status' => '4'), $bukti_tf->id_pembelian);

		$this->message('Berhasil di Konfirmasi', 'success');
		$this->go('admin/purchase'); //redirect ke purchase
	}

	public function delete($id = '')
	{
		if (!isset($id)) {
			show_404();
		}

		$this->purchase_model->delete($id);
		$this->go('admin/purchase');
	}
}
