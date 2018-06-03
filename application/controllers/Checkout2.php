<?php

/**
 *
 */
class Checkout2 extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model(array('checkout_model', 'purchase_model', 'user_model', 'purchase_detail_model', 'evidence_model', 'w_provinsi_model', 'w_kecamatan_model', 'w_kabupaten_model', 'ongkir_model', 'product_model'));
		$this->load->library('cart');
	}

	public function address($param = null)
	{

		if ($param == 'getKabupaten') {
			$provinsi_id = $_GET['prov_id'];
			$data = $this->w_kabupaten_model->where('province_id', $provinsi_id)->get_all();

			echo '<option value="">== Pilih Kabupaten ==</option>';
			foreach ($data as $value) {
				echo '<option value="' . $value->id . '">' . $value->name . '</option>';
			}
			die();
		} else if ($param == 'getKecamatan') {
			$kab_id = $_GET['kab_id'];
			$data = $this->w_kecamatan_model->where('regency_id', $kab_id)->get_all();

			echo '<option value="">== Pilih Kecamatan</option>';
			foreach ($data as $value) {
				echo '<option value="' . $value->id . '">' . $value->name . '</option>';
			}
			die();
		} else if ($param == 'getOngkir') {
			$kec_id = $_GET['kec_id'];

			$data = $this->ongkir_model->with_kurir()->where('id_kecamatan', $kec_id)->get_all();

			if ($data != false) {
				echo '<option value="">- Pilih Layanan - </option>';

				foreach ($data as $value) {
					echo '<option value="' . $value->id . '">' . $value->kurir->nama_kurir . ' - ' . rupiah($value->biaya) . '</option>';
				}
			} else {
				echo '<option value="">- Maaf pengiraman belum tersedia untuk daerah anda - </option>';
			}

			die();
		}

		$data['qty'] = $this->input->post('qty');
		$data['id_produk'] = $this->input->post('id_produk');

		$data['provinsi'] = $this->w_provinsi_model->where('id', '35')->get_all();

		$this->generateCsrf();

		if (!$this->ion_auth->logged_in()) {
			$this->render('checkout2/address', $data);
		} else {
			$data['user'] = $this->ion_auth->user()->row();
			$this->render('checkout/address-login', $data);
		}
	}
	public function payment($id)
	{
		$data['detail_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
		$data['pembelian'] = $this->purchase_model->get($id);

		$this->render('checkout/payment', $data);
	}

	public function confirm($id)
	{
		$data['detail_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
		$data['pembelian'] = $this->purchase_model->get($id);

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

		if ($this->form_validation->run() == false) {
			$data['cart'] = $this->cart->contents();

			$this->generateCsrf();
			$this->render('checkout/address', $data);
		} else {
			$biaya_kirim = explode(".", $this->input->post('layanan'));
			// dump($biaya_kirim);
			$id_user = $this->input->post('id_user');

			$kurir = $this->ongkir_model->with_kurir()->get($this->input->post('kurir'));
			$produk = $this->product_model->get($this->input->post('id_produk'));

			// menghitung jumlah bayar tidak termasuk kurir
			$jumlah_bayar = ($this->input->post('qty') * $produk->harga_jual); 

			$data_pembelian = array(
				'id_user' => $id_user,
				'nama_penerima' => $this->input->post('first_name'),
				'nomor_hp' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'kode_pembelian' => $this->checkout_model->kode_pembelian(),
				'biaya_kirim' => $kurir->biaya,
				'kabupaten_id' => $this->input->post('kabupaten'),
				'provinsi_id' => $this->input->post('provinsi'),
				'kecamatan_id' => $this->input->post('kecamatan'),
				'detail_alamat' => $this->input->post('detail_alamat'),
				'kurir' => $kurir->kurir->nama_kurir,
				'layanan' => 'Pengiriman Susu',
				'ongkir' => $kurir->biaya,
				'jumlah_bayar' => $jumlah_bayar,
				'catatan' => $this->input->post('catatan'),
				'batas_bayar' => setTimeToPay(),
			);
			$insert_pembelian = $this->purchase_model->insert($data_pembelian);


			$data_cart['id_pembelian'] = $insert_pembelian;
			$data_cart['id_produk'] = $this->input->post('id_produk');
			$data_cart['qty'] = $this->input->post('qty');
			$data_cart['subtotal'] = $this->input->post('qty') * $produk->harga_jual; 

			$insert_detail_pembelian = $this->purchase_detail_model->insert($data_cart);
  
			if ($insert_pembelian == false) {
				echo "ada kesalahan";
			} else {
				$this->message('Silahkan melakukan pembayaran', 'success');
				$this->go('checkout/payment/' . $insert_pembelian); //redirect ke product
			}
		}
	}

	public function proses_confirm()
	{
		// form validation
		$this->form_validation->set_rules('nama_rek', 'Nama Rekening', 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('no_rek', 'Nomor Rekening', 'trim|required|min_length[3]|max_length[50]');

		if ($this->form_validation->run() == false) {

			$this->generateCsrf();
			$this->render('checkout/confirmation');
		} else {
			$data = $this->input->post();

			if (!empty($_FILES['foto']['tmp_name'])) {
				$foto_name = $this->upload_bukti();
				$data['foto'] = $foto_name;
			}

			$insert = $this->evidence_model->insert($data);

			$value['status'] = '1';
			$update = $this->purchase_model->update($value, $this->input->post('id_pembelian'));

			if ($update === false) {
				$this->message('Aksi Gagal', 'warning');

			} else {
				$this->message('Bukti Berhasil dikirim!', 'success');
				$this->go('purchase/detail/' . $this->input->post('id_pembelian'));
			}
		}
	}

	function upload_bukti()
	{
		$set_name = fileName(1, 'TF', '', 8);
		$path = $_FILES['foto']['name'];
		$extension = "." . pathinfo($path, PATHINFO_EXTENSION);

		$config['upload_path'] = './uploads/bukti-transfer';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = 9024;
		$config['file_name'] = $set_name . $extension;

		$this->load->library('upload', $config);
		// proses upload
		$upload = $this->upload->do_upload('foto');

		if ($upload == false) {
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
		$total = $this->cart->total();
		$output = '
			<ul class="order-menu list-unstyled">
			<li class="d-flex justify-content-between"><span>Subtotal </span><strong>' . money($total) . '</strong></li>
			<li class="d-flex justify-content-between"><span>Ongkos Kirim</span><strong>' . money($ongkir) . '</strong></li>
			<li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">' . money($ongkir + $total) . '</strong></li>
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
