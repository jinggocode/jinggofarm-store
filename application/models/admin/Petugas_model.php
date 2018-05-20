<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas_model extends MY_Model
{  
	public function __construct()
	{
        $this->table = 'petugas';
        $this->primary_key = 'id'; 
        $this->protected = array('id');

        // join
        $this->has_one['relasiuser'] = array('User_model','id','iduser');
        $this->has_one['relasipercetakan'] = array('Percetakan_model','id','idpercetakan');
        // end join

		parent::__construct();
	}   
}
