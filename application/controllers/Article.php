<?php

/**
* 
*/
class article extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_accessable = TRUE;
		$this->load->helper(array('dump','utility'));  
        $this->load->model('pelanggan/article_model');  
		$this->load->model('product_model');  
		$this->load->model('category_article_model');  
		$this->load->library('cart');
	}

	public function index()
	{ 
		$filter = $this->session->userdata('filter_item'); 
        $start = $this->uri->segment(4, 0);  
		$config['base_url'] = base_url() . 'article/index/';
   
		/*Class bootstrap pagination yang digunakan*/
		$config['first_link']       = 'Awal';
		$config['last_link']        = 'Akhir';
		$config['next_link']        = 'Selanjutnya';
		$config['prev_link']        = 'Sebelumnya';
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
  
		$data = $this->article_model 
			->with_kategori()
            ->limit($config['per_page'],$offset=$start)
			->get_all();    
   	 	$config['total_rows'] = $this->article_model 
		    ->count_rows();  
          
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array( 
			'data' => $data,  
			'category' => $this->category_article_model->get_all(),
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'], 
            'start' => $start,  
            'page' => $this->uri->segment(2), 
        );    

        $this->generateCsrf();        
		$this->render('article/index', $data);
	}
    public function search()
    { 
    	$search_data = $this->input->get();

        $data = $this->article_model->search($search_data);
 
        $this->generateCsrf();  
		$this->render('article/index', $data);
    } 

	public function detail($id)
	{
		$data['data'] = $this->article_model 
			->with_kategori_article()  
            ->with_user()
			->get($id);  
 
        $data['product'] = $this->product_model 
            ->with_kategori() 
            ->limit(4)
            ->get_all();    

		$this->render('article/detail', $data);
	}  
}
