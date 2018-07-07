<?php

/**
 *
 */
class Purchase extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->_accessable = true;
		$this->load->helper(array('dump', 'utility'));
		$this->load->model(array('product_model', 'article_model', 'purchase_model', 'purchase_detail_model', 'testimoni_model', 'w_provinsi_model', 'w_kecamatan_model', 'w_kabupaten_model', 'ongkir_model'));
	}

	public function detail($id = null)
	{
		if ($this->input->get('kode') != '') {
			$kode = $this->input->get('kode');
			$purchase = $this->purchase_model->where('kode_pembelian', $kode)->get();
			$id = $purchase->id;
			if ($purchase->status == '0') {
				$this->go('checkout/payment/'.$id);
			}
		} else {
			$purchase = $this->purchase_model->get($id);
		}

		if ($purchase->tipe_beli == '1') { 
			$data['pembelian'] = $purchase; 
			$data['list_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
			$data['provinsi'] = $this->w_provinsi_model->where('id', $purchase->provinsi_id)->get();
			$data['kabupaten'] = $this->w_kabupaten_model->where('id', $purchase->kabupaten_id)->get();
			$data['kecamatan'] = $this->w_kecamatan_model->where('id', $purchase->kecamatan_id)->get();
			$this->generateCsrf();
			$this->render('purchase/detail-susu', $data);
		} else {
			$data['pembelian'] = $this->purchase_model->get($id);
			$data['list_pembelian'] = $this->purchase_detail_model->with_product()->where('id_pembelian', $id)->get_all();
			$data['provinsi'] = $this->purchase_model->getProvinsi($data['pembelian']->provinsi_id);
			$data['kabupaten'] = $this->purchase_model->getKabupaten($data['pembelian']->kabupaten_id, $data['pembelian']->provinsi_id);

			$this->generateCsrf();
			$this->render('purchase/detail', $data);

		}
	}

	public function check()
	{
		$this->render('purchase/check');
	}

	public function checking_transaction()
	{
		$transaksi = $this->purchase_model->where('status', '0')->get_all(); 
		if ($transaksi) {
			foreach ($transaksi as $value) {
				$this->purchase_model->checkTime($value->batas_bayar, $value->id);
			}
			echo "Berhasil di cek";
		} else {
			echo "Tidak ada Tranksaksi";
		}
	}

	public function testimoni()
	{
		$data['id_produk'] = $this->input->post('id_produk');
		$data['ulasan'] = $this->input->post('ulasan');
		$data['nama_pelanggan'] = $this->input->post('nama_pelanggan'); 

		$this->testimoni_model->insert($data);

		$this->purchase_detail_model->update(array('status_testimoni' => '1'), $this->input->post('id'));

		$this->message('Testimoni Berhasil di kirim! Terima Kasih', 'success');
		$this->go('purchase/detail/' . $this->input->post('id_pembelian'));
	}

}
