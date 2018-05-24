<?php

/**
*
*/
class Checkout extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = TRUE;
		$this->load->helper(array('dump','utility'));
		$this->load->model(array('checkout_model','purchase_model','user_model','purchase_detail_model','evidence_model'));
		$this->load->library('cart');
	}

	public function address($param = NULL)
	{
		if ($param == 'getKabupaten') {
			$provinsi_id = $_GET['prov_id'];
			$data = $this->checkout_model->getKabupaten($provinsi_id);
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
			}
			die();
		} else if ($param == 'getOngkir') {
			$asal 		  = $_POST['asal'];
			$id_kabupaten = $_POST['kab_id'];
			$kurir 		  = $_POST['kurir'];
			$berat 		  = $_POST['berat'];

			$data = $this->checkout_model->getOngkir($asal, $id_kabupaten, $kurir, $berat);
			// dump($data['rajaongkir']['results']);
			//
			echo '<option value="">- Pilih Layanan - </option>';
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				for ($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {
					echo "<option value='".$data['rajaongkir']['results'][$i]['costs'][$j]['service'].".".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value']."'>".$data['rajaongkir']['results'][$i]['costs'][$j]['service']." (".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd']." Hari) ".money($data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'])."</option>";
				}
			}
			die();
		}

		$data['cart'] 	  = $this->cart->contents();

		$totalWeight = 0;
		foreach($this->cart->contents() as $item)
		{
			$totalWeight += $item['weight'];
		}
		$data['totalWeight'] = $totalWeight;
		// dump($data['cart'] );
		$data['provinsi'] = $this->checkout_model->getProvinsi();

		$this->generateCsrf();

		if (!$this->ion_auth->logged_in())
		{
			$this->render('checkout/address', $data);
		} else {
			$data['user'] = $this->ion_auth->user()->row();
			$this->render('checkout/address-login', $data);
		}
	}
	public function payment($id)
	{
		$data['detail_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
		$data['pembelian'] 	      = $this->purchase_model->get($id);

		$this->render('checkout/payment', $data);
	}

	public function confirm($id)
	{
		$data['detail_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
		$data['pembelian'] 	      = $this->purchase_model->get($id);

		$this->generateCsrf();
		$this->render('checkout/confirmation', $data);
	}

	public function proses_detail()
	{
		// form validation
		$this->form_validation->set_rules('first_name', 'Nama', 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|required|min_length[3]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('detail_alamat', 'Alamat Lengkap', 'trim|required|min_length[1]|max_length[255]');
		$this->form_validation->set_rules('catatan', 'Catatan Pelanggan', 'trim|required|min_length[1]|max_length[255]');

		if ($this->form_validation->run() == FALSE) {
			$data['cart'] 	  = $this->cart->contents();
			$data['provinsi'] = $this->checkout_model->getProvinsi();

			$this->generateCsrf();
			$this->render('checkout/address', $data);
		} else {
			$biaya_kirim = explode(".",$this->input->post('layanan'));
			// dump($biaya_kirim);
			$id_user = $this->input->post('id_user');

			$data_pembelian = array(
				'id_user' => $id_user,
				'nama_penerima' => $this->input->post('first_name'),
				'nomor_hp' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'kode_pembelian' => $this->checkout_model->kode_pembelian(),
				'biaya_kirim' => $biaya_kirim[1],
				'kabupaten_id' => $this->input->post('kabupaten'),
				'provinsi_id' => $this->input->post('provinsi'),
				'detail_alamat' => $this->input->post('detail_alamat'),
				'kurir' => $this->input->post('kurir'),
				'layanan' => $biaya_kirim[0],
				'ongkir' => $this->input->post('ongkir'),
				'jumlah_bayar' => $this->cart->total(),
				'catatan' => $this->input->post('catatan'),
				'batas_bayar' => setTimeToPay(),
			);
			$insert_pembelian = $this->purchase_model->insert($data_pembelian);

			foreach ($this->cart->contents() as $items) {
				$data_cart['id_pembelian'] = $insert_pembelian;
				$data_cart['id_produk'] = $items['id'];
				$data_cart['qty'] = $items['qty'];
				$data_cart['subtotal'] = $items['subtotal'];

				$insert_detail_pembelian = $this->purchase_detail_model->insert($data_cart);
			}

			foreach ($this->cart->contents() as $value) {
				$data['rowid'] = $value['rowid'];
				$data['qty']   = 0;
				$this->cart->update($data);
			}

			if ($insert_pembelian == FALSE) {
				echo "ada kesalahan";
			} else {
				$this->message('Silahkan melakukan pembayaran', 'success');
				$this->go('checkout/payment/'.$insert_pembelian); //redirect ke product
			}
		}
	}

	public function proses_confirm()
	{
		// form validation
		$this->form_validation->set_rules('nama_rek', 'Nama Rekening', 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('no_rek', 'Nomor Rekening', 'trim|required|min_length[3]|max_length[50]');

		if ($this->form_validation->run() == FALSE) {

			$this->generateCsrf();
			$this->render('checkout/confirmation');
		} else {
			$data 	   = $this->input->post();

			if (!empty($_FILES['foto']['tmp_name'])) {
				$foto_name    = $this->upload_bukti();
				$data['foto'] = $foto_name;
			}

			$insert = $this->evidence_model->insert($data);

			$value['status'] = '1';
			$update = $this->purchase_model->update($value, $this->input->post('id_pembelian'));

			if ($update === FALSE) {
				$this->message('Aksi Gagal', 'warning');

			} else {
				$this->message('Bukti Berhasil dikirim!', 'success');
				$this->go('purchase/detail/'.$this->input->post('id_pembelian'));
			}
		}
	}

	function upload_bukti(){
		$set_name   = fileName(1, 'TF','',8);
		$path       = $_FILES['foto']['name'];
		$extension  = ".".pathinfo($path, PATHINFO_EXTENSION);

		$config['upload_path']          = './uploads/bukti-transfer';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['max_size']             = 9024;
		$config['file_name']            = $set_name.$extension;

		$this->load->library('upload', $config);
		// proses upload
		$upload = $this->upload->do_upload('foto');

		if ($upload == FALSE) {
			$error = array('error' => $this->upload->display_errors());
			dump($error);
			dump('Gambar gagal diupload! Periksa gambar');
		}

		$upload = $this->upload->data();

		return $upload['file_name'];
	}

	public function total()
	{
		$ongkir = (int)$this->input->post('ongkir');
		$total  = $this->cart->total();
		$output = '
			<ul class="order-menu list-unstyled">
			<li class="d-flex justify-content-between"><span>Subtotal </span><strong>'.money($total).'</strong></li>
			<li class="d-flex justify-content-between"><span>Ongkos Kirim</span><strong>'.money($ongkir).'</strong></li>
			<li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">'.money($ongkir + $total).'</strong></li>
			</ul>';
		echo $output;
	}

	public function cancel($id)
	{
		$this->message('Pembelian berhasil dibatalkan!', 'success');

		$this->purchase_model->update(array('status' => '4'), $id);
		$this->go('');
	}
}
