<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_produk';
        $this->primary_key = 'id'; 
        $this->protected = array('id');
 
        $this->has_one['kategori'] = array('Category_model','id','id_kategori');
		parent::__construct();
	}   

	public function search($search_data)
	{ 
        $start = $this->uri->segment(4, 0);  
		$config['base_url'] = base_url() . 'product/search/';
		if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        
		/*Class bootstrap pagination yang digunakan*/
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';
		$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav></div>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close'] = '</span>Next</li>';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close'] = '</span></li>';
		$config['per_page'] = 10;
 
        if ($search_data['sort'] == 1) {
        	$sort_by   = 'created_at';
        	$sort_with = 'DESC';
        } else if ($search_data['sort'] == 2) {
        	$sort_by   = 'created_at';
        	$sort_with = 'ASC';	
        } else if ($search_data['sort'] == 3) {
        	$sort_by   = 'harga_jual';
        	$sort_with = 'ASC';	
        } else if ($search_data['sort'] == 4) {
        	$sort_by   = 'harga_jual';
        	$sort_with = 'DESC';	
        } else {  
        	$sort_by   = '';
        	$sort_with = '';
        }  

		$data = $this->product_model    
            ->with_kategori()
			->limit($config['per_page'],$offset=$start)
			->where('nama', 'like', $search_data['keyword']) 
            ->where('id_kategori', 'like', $search_data['category'])
			->order_by($sort_by, $sort_with)
			->get_all();     
   	 	$config['total_rows'] = $this->product_model  
			->where('nama', 'like', $search_data['keyword']) 
            ->where('id_kategori', 'like', $search_data['category']) 
		  	->count_rows();   
          
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array( 
        	'data' => $data, 
            'category' => $this->category_model->get_all(),
        	'search_data' => $search_data,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'], 
            'start' => $start,  
            'page' => $this->uri->segment(2), 
        );    
        return $data;
	}
}
