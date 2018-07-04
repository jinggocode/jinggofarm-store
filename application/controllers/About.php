<?php

/**
 * 
 */
class About extends MY_Controller
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
		$this->render('about');
	} 

}