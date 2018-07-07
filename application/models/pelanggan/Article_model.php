<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'tb_artikel';
        $this->primary_key = 'id'; 
        $this->protected = array('id');
 
        $this->has_one['kategori_article'] = array('Category_article_model','id','id_kategori');
        $this->has_one['user'] = array('User_model','id','created_by');
		parent::__construct();
	}   

	public function search($search_data)
	{ 
        $start = $this->uri->segment(4, 0);  
		$config['base_url'] = base_url() . 'article/search/';
		if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

		/*Class bootstrap pagination yang digunakan*/
		$config['full_tag_open'] = "<ul class='pagination' style='position:relative; top:-25px;'>";
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
 
        if ($search_data['sort'] == 1) {
        	$sort_by   = 'created_at';
        	$sort_with = 'DESC';
        } else if ($search_data['sort'] == 2) {
        	$sort_by   = 'created_at';
        	$sort_with = 'ASC';	 
        } else {  
        	$sort_by   = '';
        	$sort_with = '';
        } 
		$data = $this->article_model    
            ->with_kategori()
			->limit($config['per_page'],$offset=$start) 
			->where('id_kategori', 'like', $search_data['category']) 
			->order_by($sort_by, $sort_with)
			->get_all();     
   	 	$config['total_rows'] = $this->article_model  
			->where('id_kategori', 'like', $search_data['category']) 
		  	->count_rows();   
          
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array( 
        	'data' => $data, 
            'category' => $this->category_article_model->get_all(),
        	'search_data' => $search_data,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'], 
            'start' => $start,  
            'page' => $this->uri->segment(2), 
        );    
        return $data;
	}
}
