<?php

/** 
* 
*/
class Petugas extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_accessable = TRUE;
		$this->load->helper(array('dump'));
		$this->root_view = "admin/";
		$this->load->model('admin/Petugas_model');
		$this->load->model('admin/User_model');
		$this->load->model('admin/Percetakan_model');
		$this->load->model(array('petugas_model','user_model','percetakan_model'));
	}

	public function index()
	{
		// pagination
		$filter = $this->session->userdata('filter_item');
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->input->get('per_page'));
		// dump($start);
		if ($q <> '') {
			$config['base_url'] = base_url() . 'admin/petugas/?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'admin/petugas/?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'admin/petugas/';
			$config['first_url'] = base_url() . 'admin/petugas/';
		}

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

        $config['per_page'] = 2;
        $config['page_query_string'] = TRUE;
  
		$data = $this->petugas_model
            ->where($filter, 'like', '%')
            ->limit($config['per_page'],$offset=$start)
			->with_relasiuser()
			->with_relasipercetakan()
			->get_all();   

    	$total_cari =  $this->petugas_model
            ->where($filter, 'like', '%')
			->with_relasiuser()
			->with_relasipercetakan()
			->count_rows(); 
   	 	$config['total_rows'] = $this->petugas_model 
		    ->count_rows();  
          
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array( 
        	'tampildata' => $data,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'total_cari' => $total_cari,
            'start' => $start, 
            'filter' => $this->session->userdata('filter_cattle'),
            'page' => $this->uri->segment(2), 
        );    

        $this->generateCsrf();     

		$this->render('admin/petugas/index', $data);
	}

	public function add()
	{
		// manggil kategori pada form tambah
		$data['tampiluser'] = $this->user_model->get_all();
		$data['tampilpercetakan'] = $this->percetakan_model->get_all();
		// end manggil
		$this->generateCsrf();
		$this->render('admin/petugas/add', $data);
	}
		public function save()
	{
		// form validation
		$this->form_validation->set_rules('iduser', 'iduser', 'trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('idpercetakan', 'idpercetakan', 'trim|required|min_length[1]|max_length[50]');
		// end form validation

		if ($this->form_validation->run() == FALSE) {
			$data['tampiluser'] = $this->user_model->get_all();
			$data['tampilpercetakan'] = $this->percetakan_model->get_all();

			$this->generateCsrf();
			$this->render('petugas/add', $data);		
		} else {
			$data = $this->input->post();
			$insert = $this->petugas_model->insert($data);
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else {
				$this->go('admin/petugas'); //redirect ke petugas
			}	
		}

	}

		public function edit($id)
	{
		$data['tampiluser'] = $this->user_model->get_all();
		$data['tampilpercetakan'] = $this->percetakan_model->get_all();
		$data['data'] = $this->petugas_model->get($id);

		$this->generateCsrf();
		$this->render('petugas/edit', $data);
	}
	public function update()
	{
		// form validation
		$this->form_validation->set_rules('iduser', 'iduser', 'trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('idpercetakan', 'idpercetakan', 'trim|required|min_length[1]|max_length[50]');
		// end form validation

		if ($this->form_validation->run() == FALSE) {
			$data['tampiluser'] = $this->user_model->get_all();
			$data['tampilpercetakan'] = $this->percetakan_model->get_all();
			$data['data'] = $this->input->post();

			$this->generateCsrf();
			$this->render('petugas/add', $data);		
		} else {
			$data = $this->input->post();
			$insert = $this->petugas_model->update($data, $this->input->post('id'));
			if ($insert == FALSE) {
				echo "ada kesalahan";
			} else {
				$this->go('admin/petugas'); //redirect ke petugas
			}	
		}

	}

	public function delete($id='')
	{
		if (!isset($id)) {
			show_404();
		}

		$this->petugas_model->delete($id);
		$this->go('admin/petugas');
	}
}