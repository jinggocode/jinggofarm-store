<?php

/**
 * 
 */
class Homepage extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model(array('product_model', 'article_model'));
	}

	public function index()
	{
		$data['product'] = $this->product_model
			->with_kategori()
			->limit(4)
			->get_all();

		$data['article'] = $this->article_model
			->with_kategori_article()
			->limit(2)
			->get_all();
		$this->render('home', $data);
	}

	public function tambah()
	{
		dump('ini tambah');
	}

}