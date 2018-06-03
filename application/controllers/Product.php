<?php

/**
 *
 */
class Product extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('testimoni_model');
		$this->load->library('cart');
	}

	public function index()
	{
		$filter = $this->session->userdata('filter_item');
		$start = $this->uri->segment(4, 0);
		$config['base_url'] = base_url() . 'product/index/';

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

		$data = $this->product_model
			->with_kategori()
			->limit($config['per_page'], $offset = $start)
			->get_all();
		$config['total_rows'] = $this->product_model
			->count_rows();

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'data' => $data,
			'category' => $this->category_model->get_all(),
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
			'filter' => $this->session->userdata('filter_cattle'),
			'page' => $this->uri->segment(2),
		);

		$this->render('product/index', $data);
	}
	public function search()
	{
		$search_data = $this->input->get();

		$data = $this->product_model->search($search_data);

		$this->generateCsrf();
		$this->render('product/index', $data);
	}

	public function detail($id)
	{
		$data['data'] = $this->product_model
			->with_kategori()
			->get($id);
		$data['testimoni'] = $this->testimoni_model->where('id_produk', $data['data']->id)->get_all();
		$data['produk_lainnya'] = $this->product_model
			->where('id', 'not like', $id)
			->where('id_kategori', $data['data']->id_kategori)
			->with_kategori()
			->get_all();

		$this->generateCsrf();
		$this->render('product/detail', $data);
	}

	function add_to_cart()
	{
		$data = array(
			'id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_name'),
			'price' => $this->input->post('product_price'),
			'qty' => $this->input->post('quantity'),
			'image' => $this->input->post('image'),
			'weight' => $this->input->post('weight'),
		);
		$this->cart->insert($data);

		echo $this->show_cart();
	}
	public function count_cart()
	{
		$rows = count($this->cart->contents());
		echo $rows;
	}
	function show_cart()
	{
		$output = '';
		$no = 0;
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $items) {
				$no++;
				$output .=
					'<div class="dropdown-item cart-product">
				<div class="d-flex align-items-center">
				<div class="img"><img src="' . $items['image'] . '" alt="..." class="img-fluid"></div>
				<div class="details d-flex justify-content-between">
				<div class="text">
				<a href="#"><strong>' . $items['name'] . '</strong></a><small>Quantity: ' . $items['qty'] . ' </small><span class="price">' . money($items['price']) . ' </span>
				</div>
				<a id="' . $items['rowid'] . '" class="delete_cart"><i class="fa fa-trash-o"></i></a>
				</div>
				</div>
				</div>';
			}

			$output .= '
			<div class="dropdown-item total-price d-flex justify-content-between"><span>Total</span><strong class="text-primary">' . number_format($this->cart->total()) . '</strong></div>
			';
			$output .=
				'<div class="dropdown-item d-flex">
			<a href="' . site_url('cart') . '" class="btn btn-primary btn-block "><i class="fa fa-shopping-cart"></i>Lihat Keranjang</a>
			</div>';
		} else {
			$output .= '<p align="center">Keranjang Kosong</p>';
		}
		return $output;
	}
	function load_cart()
	{
		echo $this->show_cart();
	}
	public function cart()
	{
		echo $this->show_cart();
	}
	public function delete_cart()
	{
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}
}
