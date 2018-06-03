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
		$this->root_view = "admin/";
		$this->load->model('admin/user_model');  
        $this->slug_config($this->user_model->table, 'nama'); 
	}

	public function index()
	{
		// pagination
		$filter = $this->session->userdata('filter_item'); 
        $start = $this->uri->segment(4, 0);  
		$config['base_url'] = base_url() . 'admin/user/index/';
 
		// Class bootstrap pagination yang digunakan
		$config['full_tag_open'] = "<ul class='pagination pagination-sm no-margin pull-right'>";
		$config['full_tag_close'] ="</ul>";
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
  
		$data = $this->user_model
			->where('group_id', '1')  
            ->limit($config['per_page'],$offset=$start)
			->get_all();    
   	 	$config['total_rows'] = $this->user_model 
			->where('group_id', '1')  
		    ->count_rows();  
          
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array( 
        	'data' => $data, 
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'], 
            'start' => $start, 
            'filter' => $this->session->userdata('filter_cattle'),
            'page' => $this->uri->segment(2), 
        );    

        $this->generateCsrf();       
		$this->render('admin/user/index', $data);
	}
    public function search()
    { 
    	$search_data = $this->input->get();

        $data = $this->user_model->search($search_data);
 
        $this->generateCsrf();  
		$this->render('admin/user/index', $data);
    } 

	public function add()
	{ 
		$this->generateCsrf(); 
		$this->render('admin/user/add');
	}
	public function save()
	{
		$this->form_validation->set_rules('first_name', 'Nama', 'trim|required|max_length[20]'); 
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[10]|is_unique[users.username]',
        array(
                'required'      => 'Harus di isi',
                'is_unique'     => 'Username '.$this->input->post('username').' sudah ada'
        ));   
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]'); 
		$this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'trim|required|matches[password]'); 

		if ($this->form_validation->run() == FALSE) {  
			$this->generateCsrf();
			$this->render('admin/user/add');		
		} else {
			$data = $this->input->post(); 

			$data['password'] 	= password_hash($data['password'], PASSWORD_BCRYPT); 
			$data['ip_address'] = $this->input->ip_address(); 
			$data['group_id'] 	= '1'; 

			$insert = $this->user_model->insert($data);
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else { 
	 			$this->message('Data berhasi di Simpan!', 'success');
				$this->go('admin/user'); //redirect ke user
			}	
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->user_model->get($id);
 
		$this->generateCsrf();
		$this->render('admin/user/edit', $data);
	}
	public function update()
	{
		$this->form_validation->set_rules('first_name', 'Nama', 'trim|required|max_length[20]'); 
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[10]');   
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[12]'); 
		$this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'trim|matches[password]'); 

		if ($this->form_validation->run() == FALSE) {
			$data['data'] = $this->input->post();

			$this->generateCsrf();
			$this->render('admin/user/edit', $data);		
		} else {
			$data 				= $this->input->post();

	        if (! empty($data['password'])) {
				$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
			} else {
				unset($data['password']);
			} 
			$data['ip_address'] = $this->input->ip_address();

			$update = $this->user_model->update($data, $this->input->post('id'));
			if ($update == FALSE) {
				echo "ada kesalahan";
			} else {
	 			$this->message('Data berhasi di Ubah!', 'success');
				$this->go('admin/user'); //redirect ke user
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