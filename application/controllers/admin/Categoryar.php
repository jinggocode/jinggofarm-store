<?php

/**
* 
*/
class Categoryar extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_accessable = TRUE;
		$this->load->helper(array('dump','utility'));
		$this->root_view = "admin/";
		$this->load->model('admin/category_article_model'); 
		$this->load->model('admin/category_article_model'); 
        $this->slug_config($this->category_article_model->table, 'nama'); 
	}

	public function index()
	{
		// pagination
		$filter = $this->session->userdata('filter_item'); 
        $start = $this->uri->segment(4, 0);  
		$config['base_url'] = base_url() . 'admin/categoryar/index/';
 
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
  
		$data = $this->category_article_model  
            ->limit($config['per_page'],$offset=$start)
			->get_all();    
   	 	$config['total_rows'] = $this->category_article_model 
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
		$this->render('admin/categoryar/index', $data);
	}
    public function search()
    { 
    	$search_data = $this->input->get();

        $data = $this->category_article_model->search($search_data);
 
        $this->generateCsrf();  
		$this->render('admin/categoryar/index', $data);
    } 

	public function add()
	{
		$this->generateCsrf();
		$this->render('admin/categoryar/add');
	}

	public function save()
	{
		// form validation
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[3]|max_length[70]');
		

		if ($this->form_validation->run() == FALSE) { 

			$this->generateCsrf();
			$this->render('admin/categoryar/add');	

		} else {
			$data = $this->input->post();
			
			$insert = $this->category_article_model->insert($data);
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else { 
	 			$this->message('Data berhasi di Simpan!', 'success');
				$this->go('admin/categoryar'); //redirect ke categoryar
			}	
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->category_article_model->get($id);
		$data['categoryar'] = $this->category_article_model->get_all();
 
		$this->generateCsrf();
        $data['page'] = $this->uri->segment(2);
		$this->render('admin/categoryar/edit', $data);
	}
	public function update()
	{
		// form validation
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[3]|max_length[70]');
		

		if ($this->form_validation->run() == FALSE) {
			$this->generateCsrf();
			$this->render('admin/categoryar/edit');	

		} else {
			$data 				= $this->input->post();
			$insert = $this->category_article_model->update($data, $this->input->post('id'));
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else {
	 			$this->message('Data berhasi di Ubah!', 'success');
				$this->go('admin/categoryar'); //redirect ke categoryar
			}	
		} 
	}

	public function view($id)
	{
		$data['data'] = $this->category_article_model->get($id); 
 
        $data['page'] = $this->uri->segment(2);
		$this->render('admin/categoryar/view', $data);
	}

    
    function upload_foto(){ 
        $set_name   = fileName(1, 'PRD','',8);
        $path       = $_FILES['foto']['name'];
        $extension  = ".".pathinfo($path, PATHINFO_EXTENSION); 

        $config['upload_path']          = './uploads/categoryar/';
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

		$this->category_article_model->delete($id);
		$this->go('admin/categoryar');
	}
}