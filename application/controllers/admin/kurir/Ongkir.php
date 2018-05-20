<?php

/**
 * 
 */
class Ongkir extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model('ongkir_model');
	}

	public function index()
	{
		// pagination
		$filter = $this->session->userdata('filter_item');
		$start = $this->uri->segment(4, 0);
		$config['base_url'] = base_url() . 'admin/kurir/ongkir/index/';
 
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

		$data = $this->ongkir_model
			->with_kurir()
			->with_kecamatan()
			->limit($config['per_page'], $offset = $start)
			->get_all();
		$config['total_rows'] = $this->ongkir_model
			->count_rows();

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'data' => $data,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
			'page' => $this->uri->segment(2),
		);

		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/index', $data);
	}
	public function search()
	{
		$search_data = $this->input->get();

		$data = $this->ongkir_model->search($search_data);

		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/index', $data);
	}

	public function add()
	{
		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/add');
	}
	public function save()
	{
		$this->form_validation->set_rules('nama_kurir', 'Nama', 'trim|required|max_length[80]');

		if ($this->form_validation->run() == false) {
			$this->generateCsrf();
			$this->render('admin/kurir/ongkir/add');
		} else {
			$data = $this->input->post();

			$insert = $this->ongkir_model->insert($data);
			if ($insert == false) {
				echo "ada kesalahan";
			} else {
				$this->message('Data berhasi di Simpan!', 'success');
				$this->go('admin/kurir/ongkir');
			}
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->ongkir_model->get($id);

		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/edit', $data);
	}
	public function update()
	{
		$this->form_validation->set_rules('nama_kurir', 'Nama', 'trim|required|max_length[80]');

		if ($this->form_validation->run() == false) {
			$data['data'] = $this->input->post();

			$this->generateCsrf();
			$this->render('admin/kurir/ongkir/edit', $data);
		} else {
			$data = $this->input->post();

			$update = $this->ongkir_model->update($data, $this->input->post('id'));
			if ($update == false) {
				echo "ada kesalahan";
			} else {
				$this->message('Data berhasi di Ubah!', 'success');
				$this->go('admin/kurir/ongkir');
			}
		}
	}

	public function view($id)
	{
		$data['data'] = $this->ongkir_model->get($id);

		$data['page'] = $this->uri->segment(2);
		$this->render('admin/user/view', $data);
	} 

	public function delete($id = '')
	{
		if (!isset($id)) {
			show_404();
		}

		$this->ongkir_model->delete($id);
		$this->message('Data berhasi di Hapus!', 'success');
		$this->go('admin/kurir/ongkir');
	}
}