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
		$this->load->model('admin/report_model'); 
		$this->load->model('admin/category_model'); 

		// $this->load->helper('utility');
	}

	public function index()
	{
		if ($this->input->get('action') == "submit") { 
			
			$date = $this->input->get('date');
			$category = $this->input->get('category');

			$newDateFormat = date('Y-m-d', strtotime($date)); 
			
			$data = $this->report_model
				->getDataReportByDate($newDateFormat, $category);
			$total = $this->report_model
				->getTotalDataReportByDate($newDateFormat, $category); 

			$data = array(
				'data' => $data, 
				'date' => $date, 
				'category_product' => $this->category_model->get_all(),
				'category_select' => $category,
				'newDateFormat' => $newDateFormat, 
				'total' => $total, 
				'action' => $this->input->get('action'), 
				'page' => $this->uri->segment(2),
			);

			$this->generateCsrf();
			$this->render('admin/report/product/index', $data);
		} else {
			$data['page'] = $this->uri->segment(2);
			$data['category_product'] = $this->category_model->get_all();
			$data['category_select'] = 0;
			$data['action'] = ""; 

			$this->generateCsrf();
			$this->render('admin/report/product/index', $data);
		} 
	}
	public function search()
	{
		$search_data = $this->input->get();

		$data = $this->cattle_model->search($search_data);

		$this->generateCsrf();
		$this->render('admin/cattle/index', $data);
	} 

	public function cetak()
	{
		$this->load->library('html2pdf');

		$date = $this->input->get('date');
		$category = $this->input->get('category');

		$newDateFormat = date('Y-m-d', strtotime($date)); 
		
		$data['data'] = $this->report_model
			->getDataReportByDate($newDateFormat, $category);
		$data['total'] = $this->report_model
			->getTotalDataReportByDate($newDateFormat, $category); 
		$data['newDateFormat'] = $newDateFormat;
		
		$category_product = $this->category_model->get($category);

		if ($category_product == FALSE) {
			$data['category'] = 'Semua Kategori';
		} else {
			$data['category'] = 'Kategori '.$category_product->nama;
		}

		// generate nama laporan
		$filename = 'Laporan Produk '.date("Y_m_d-His"); 
		
		// configurasi html2pdf
		$this->html2pdf->folder('./report/product/');
		//Set the filename to save/download as
		$this->html2pdf->filename($filename);
		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');
		
		//Load html view
		$this->html2pdf->html($this->load->view('admin/report/product/cetak_pdf', $data, true));
		// dump('asd');
		if($path = $this->html2pdf->create('save')) {
			//PDF was successfully saved or downloaded
			// echo 'PDF saved to: ' . $path;
			// $this->load->view('pdf', $data);
			$this->go($path);
			
		};
	}
}
