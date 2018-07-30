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

	public function email()
	{
		
        $this->load->library('email');
        
        $this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_user' => 'apikey',
  'smtp_pass' => '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',
  'smtp_port' => 465,
  'crlf' => "\r\n",
  'newline' => "\r\n",
  'mailtype'=> "html",
  'smtp_crypto'=> "ssl",
  'useragent'=> "jinggofarm",
		));
$this->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.jinggofarm.com',
        'smtp_user' => 'mail@jinggofarm.com',
        'smtp_pass' => 'yowesben',
        'smtp_port' => 465,     
        'crlf' => "\r\n",
        'newline' => "\r\n",
        'mailtype'=> "html",
        'smtp_crypto'=> "ssl",
        'useragent'=> "jinggofarm",
));
        
        $this->email->from('rahmatrputra@gmail.com', 'Your Name');
        $this->email->to('rahmatramadhan.ti.poliwangi@gmail.com'); 
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();
        
        echo $this->email->print_debugger(); 
	}

}