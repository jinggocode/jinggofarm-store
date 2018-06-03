<?php

/**
* 
*/
class Cart extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct(); 
		$this->_accessable = TRUE;
		$this->load->helper(array('dump','utility'));
		$this->load->model(array('product_model'));
		$this->load->library('cart');
	}

	public function index()
	{
		$this->render('cart/index');
	} 
	public function show()
	{
		dump($this->cart->contents());
	}

	function show_cart()
	{
        $output = '';
        $no = 0;
        if (!empty($this->cart->contents())) {
            foreach ($this->cart->contents() as $items) {
            	$data = $this->product_model->get($items['id']);
                $no++;
                $output .= 
                '<div class="item"> 
		            <div class="row d-flex align-items-center">
		              <div class="col-5">
		                <div class="d-flex align-items-center"><img src="'.$items['image'].'" alt="..." class="img-fluid">
		                  <div class="title"><a href="detail.html">
		                      <h5>'.$items['name'].'</h5><span class="text-muted">Sisa stok <b>'.$data->sisa_stok.'</b></span></a></div>
		                </div>
		              </div>
		              <div class="col-2"><span>'.money($items['price']).'</span></div>
		              <div class="col-2">
		                <div class="d-flex align-items-center"> 
		                    <input type="number" class="form-control update_cart col-6 '.$items['rowid'].'" name="'.$items['rowid'].'" id="'.$items['rowid'].'" data-rowid="'.$items['rowid'].'" data-price="'.$data->harga_jual.'" data-weight="'.$data->berat.'" value="'.$items['qty'].'" max="'.$data->sisa_stok.'" data-max="'.$data->sisa_stok.'">  
		                </div>
		              </div>
		              <div class="col-2"><span>'.money($items['subtotal']).'</span></div>
		              <div class="col-1 text-center"><a id="'.$items['rowid'].'" class="delete_cart"><i class="delete fa fa-trash"></i></a></div>
		            </div> 
		          </div> '; 
            } 
        } else {
            $output .='<p align="center">Keranjang Kosong</p>';
        } 
        echo $output;
	}
    function update_cart(){ 
        $data = array(
            'rowid' => $this->input->post('rowid'), 
            'price' => $this->input->post('price'), 
            'qty'   => $this->input->post('qty'),  
            'weight'=> $this->input->post('weight'),  
        );
        $this->cart->update($data);   
    }
    function total_pay(){   
        echo money($this->cart->total()); 
    }
}