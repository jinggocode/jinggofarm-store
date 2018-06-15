<?php

/**
 *
 */
class Profit extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model('admin/report_model'); 

		// $this->load->helper('utility');
	}

	public function index()
	{
		if ($this->input->get('action') == "submit") {

			$data = $this->report_model
				->getDataReport($this->input->get('month'), $this->input->get('year'));

			$config['total_rows'] = $this->report_model->getRowReport($this->input->get('month'), $this->input->get('year'));

			$total = $this->report_model->getTotal($this->input->get('month'), $this->input->get('year'));

			$total_profit = $this->report_model->getTotalProfit($this->input->get('month'), $this->input->get('year'));
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			$data = array(
				'data' => $data,
				'total' => $total,
				'month' => $this->input->get('month'),
				'year' => $this->input->get('year'),
				'total_profit' => $total_profit,
				'action' => $this->input->get('action'), 
				'page' => $this->uri->segment(2),
			);

			$this->generateCsrf();
			$this->render('admin/report/profit/index', $data);
		} else {
			$data['page'] = $this->uri->segment(2);
			$data['action'] = "";

			$this->generateCsrf();
			$this->render('admin/report/profit/index', $data);
		}

	}
	

	public function cetak()
	{
		$this->load->library('html2pdf');
		
		$data['data'] = $this->report_model
		->getDataReport($this->input->get('month'), $this->input->get('year'));
 
		$data['total'] = $this->report_model->getTotal($this->input->get('month'), $this->input->get('year'));

		$data['total_profit'] = $this->report_model->getTotalProfit($this->input->get('month'), $this->input->get('year')); 

		$data['month'] = $this->input->get('month');
		$data['year'] = $this->input->get('year');
		
		// generate nama laporan
		$filename = 'Laporan Keuntungan per Bulan ' . date("Y_m_d-His"); 
		
		// configurasi html2pdf
		$this->html2pdf->folder('./report/profit/');
		//Set the filename to save/download as
		$this->html2pdf->filename($filename);
		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');
		
		//Load html view
		$this->html2pdf->html($this->load->view('admin/report/profit/cetak_pdf', $data, true));
		// dump('asd');
		if ($path = $this->html2pdf->create('save')) {
			//PDF was successfully saved or downloaded
			// echo 'PDF saved to: ' . $path; 
			// $this->load->view('admin/report/profit/cetak_pdf', $data);
			$this->go($path); 
		} else {
			dump('asd');
		}
	}
}
