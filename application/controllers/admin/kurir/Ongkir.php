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
		$this->load->model(array('ongkir_model', 'w_provinsi_model', 'w_kabupaten_model', 'w_kecamatan_model', 'kurir_model'));
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
			->with_kecamatan(array('with'=>array('relation'=>'kabupaten','fields'=>'name')))
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
		$data['provinsi'] = $this->w_provinsi_model->get_all();
		$data['kurir'] = $this->kurir_model->get_all();
		
		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/add', $data);
	}
	public function save()
	{ 
		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('biaya', 'Biaya', 'trim|required|max_length[5]');

		if ($this->form_validation->run() == false) {
			$data['provinsi'] = $this->w_provinsi_model->get_all();
			$data['kurir'] = $this->kurir_model->get_all();

			$this->generateCsrf();
			$this->render('admin/kurir/ongkir/add', $data);
		} else {
			$data = array(
				'id_kurir' => $this->input->post('id_kurir'), 
				'id_kecamatan' => $this->input->post('id_kecamatan'), 
				'biaya' => $this->input->post('biaya'),  
			);

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
		$data['provinsi'] = $this->w_provinsi_model->get_all();
		$data['kurir'] = $this->kurir_model->get_all();

		$kecamatan = $this->w_kecamatan_model->get($data['data']->id_kecamatan);
		$data['id_kabupaten'] = $kecamatan->regency_id;
		$kabupaten = $this->w_kabupaten_model->get($data['id_kabupaten']);
		$data['id_provinsi'] = $kabupaten->province_id;

		$this->generateCsrf();
		$this->render('admin/kurir/ongkir/edit', $data);
	}
	public function update()
	{
		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('biaya', 'Biaya', 'trim|required|max_length[5]');

		if ($this->form_validation->run() == false) {
			$data['data'] = $this->input->post();
			$data['provinsi'] = $this->w_provinsi_model->get_all();
			$data['kurir'] = $this->kurir_model->get_all();

			$this->generateCsrf();
			$this->render('admin/kurir/ongkir/edit', $data);
		} else {
			$data = array(
				'id_kurir' => $this->input->post('id_kurir'), 
				'id_kecamatan' => $this->input->post('id_kecamatan'), 
				'biaya' => $this->input->post('biaya'),  
			); 

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

	public function show($param = null)
	{ 
		if ($param == 'getKabupaten') {
			$provinsi_id = $_GET['prov_id'];
			$kab_id = $_GET['kab_id'];
			$data = $this->w_kabupaten_model->where('province_id', $provinsi_id)->get_all();

			echo '<option value="">== Pilih Kabupaten ==</option>';
			foreach ($data as $value) {
				if ($kab_id == $value->id) {
					echo '<option selected value="' . $value->id . '">' . $value->name . '</option>';
				} else { 
					echo '<option value="' . $value->id . '">' . $value->name . '</option>';
				}
			}
			die();
		} else if ($param == 'getKecamatan') {
			$kab_id = $_GET['kab_id'];
			$kec_id = $_GET['kec_id'];
			$data = $this->w_kecamatan_model->where('regency_id', $kab_id)->get_all();

			echo '<option value="">== Pilih Kecamatan</option>';
			foreach ($data as $value) {
				if ($kec_id == $value->id) {
					echo '<option selected value="' . $value->id . '">' . $value->name . '</option>';
				} else { 
					echo '<option value="' . $value->id . '">' . $value->name . '</option>';
				}
			}
			die();
		} else if ($param == 'getOngkir') {
			$kec_id = $_GET['kec_id'];

			$data = $this->ongkir_model->with_kurir()->where('id_kecamatan', $kec_id)->get_all();

			if ($data != false) {
				echo '<option value="">- Pilih Layanan - </option>';

				foreach ($data as $value) {
					echo '<option value="' . $value->id . '">' . $value->kurir->nama_kurir . ' - ' . rupiah($value->biaya) . '</option>';
				}
			} else {
				echo '<option value="">- Maaf pengiraman belum tersedia untuk daerah anda - </option>';
			}

			die();
		}
	}


}