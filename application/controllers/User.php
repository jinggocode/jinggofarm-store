<?php

/**
*
*/
class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = TRUE;
		$this->load->helper(array('dump','utility'));
		$this->load->model('purchase_model');
		$this->load->model('user_model');
		$this->load->model('checkout_model');
	}

	public function order()
	{
		$user = $this->ion_auth->user()->row();

		$start = $this->uri->segment(3, 0);
		$config['base_url'] = base_url() . 'investor/purchase/index/';

		/*Class bootstrap pagination yang digunakan*/
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		$config['per_page'] = 10;

		$data = $this->purchase_model
		->where('id_user', $user->id)
		->limit($config['per_page'],$offset=$start)
		->order_by('created_at', 'DESC')
		->get_all();
		$config['total_rows'] = $this->purchase_model
		->where('id_user', $user->id)
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
		$this->render('user/order', $data);
	}

	public function profile($param='')
	{
		if ($param == 'getKabupaten') {
			$provinsi_id = $_GET['prov_id'];
			$kab_id = $_GET['kab_id'];
			$data = $this->checkout_model->getKabupaten($provinsi_id);
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				if ($data['rajaongkir']['results'][$i]['city_id'] == $kab_id) {
					echo "<option selected  value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
				} else {
					echo "<option  value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
				}
			}
			die();
		}
		$data['provinsi'] = $this->checkout_model->getProvinsi();
		$data['user'] = $this->ion_auth->user()->row();
		
		$this->generateCsrf();
		$this->render('user/profile', $data);
	}

	public function change_password()
	{
		if (!empty($this->input->post())) {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('reenter_password', 'Ulangi Password', 'trim|required|max_length[8]|matches[password]');
			$data = $this->input->post();

			if ($this->form_validation->run() == FALSE)
			{
				$data['user'] = (object)$data;

				$this->generateCsrf();
				$this->render('user/change_password', $data);
			} else {
				$data['password'] 	= password_hash($data['password'], PASSWORD_BCRYPT);

				$update = $this->user_model->update($data, $this->input->post('id'));

				if ($update === FALSE) {
					$this->message('Aksi Gagal', 'warning');

					$this->go('user/change_password');
				} else {
					$this->message('Password Berhasil di Ubah!', 'success');
					$this->go('user/change_password');
				}
			}
		}

		$this->generateCsrf();
		$this->render('user/change_password');
	}

	public function sign_up()
	{
		$data['provinsi'] = $this->checkout_model->getProvinsi();

		$this->generateCsrf();
		$this->render('user/sign_up', $data);
	}
	public function save()
	{
		$this->form_validation->set_rules('first_name', 'Nama', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[20]|is_unique[users.username]',
		array(
			'required'      => 'Harus di isi',
			'is_unique'     => 'Email '.$this->input->post('username').' sudah ada'
		));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('reenter_password', 'Konfirmasi Password', 'trim|required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->generateCsrf(); 
			$this->render('user/sign_up');
		} else {
			$data = $this->input->post();

			$data['password'] 	= password_hash($data['password'], PASSWORD_BCRYPT);
			$data['ip_address'] = $this->input->ip_address();
			$data['group_id'] 	= '2';

			$insert = $this->user_model->insert($data);
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else {
				$this->message('Data berhasi di Simpan!', 'success');
				$this->go('auth/sign_in'); //redirect ke user
			}
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('first_name', 'Nama', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('detail_alamat', 'Alamat', 'trim|required|max_length[200]');

		if ($this->form_validation->run() == FALSE) {
			$data['user'] = (object)$this->input->post();

			$this->generateCsrf();
			$this->render('user/profile', $data);
		} else {
			$data 				= $this->input->post();

			$data['ip_address'] = $this->input->ip_address();

			$update = $this->user_model->update($data, $this->input->post('id'));
			if ($update == FALSE) {
				echo "ada kesalahan";
			} else {
				$this->message('Data berhasi di Ubah!', 'success');
				$this->go('user/profile'); //redirect ke user
			}
		}
	}

	public function view($id)
	{
		$data['data'] = $this->user_model->get($id);

		$data['page'] = $this->uri->segment(2);
		$this->render('admin/user/view', $data);
	}


	function upload_foto(){
		$set_name   = fileName(1, 'PRD','',8);
		$path       = $_FILES['foto']['name'];
		$extension  = ".".pathinfo($path, PATHINFO_EXTENSION);

		$config['upload_path']          = './uploads/user/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['max_size']             = 9024;
		$config['file_name']            = $set_name.$extension;
		$this->load->library('upload', $config);
		// proses upload
		$upload = $this->upload->do_upload('foto');

		if ($upload == FALSE) {
			dump('Gambar gagal diupload! Periksa gambar');
		}

		$upload = $this->upload->data();

		return $upload['file_name'];
	}

	public function delete($id='')
	{
		if (!isset($id)) {
			show_404();
		}

		$this->user_model->delete($id);
		$this->go('admin/user');
	}
}
