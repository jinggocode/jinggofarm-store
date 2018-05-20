<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends MY_Model
{
	public function __construct()
	{
        $this->table = 'tb_pembelian';
        $this->primary_key = 'id';
        $this->protected = array('id');

		parent::__construct();
	}

	public function getProvinsi($id_provinsi='')
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.rajaongkir.com/starter/province?id=".$id_provinsi,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "key: 05e80c32fca42d47810467cd2f87f297"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$data = json_decode($response, true);

		curl_close($curl);
        return $data['rajaongkir']['results']['province'];
	}

	public function getKabupaten($id_kabupaten, $id_provinsi)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
  		  CURLOPT_URL => "https://api.rajaongkir.com/starter/city?id=".$id_kabupaten."&province=".$id_provinsi,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "key: 05e80c32fca42d47810467cd2f87f297"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$data = json_decode($response, true);

		curl_close($curl);

        return $data['rajaongkir']['results'];
	}

	public function checkTime($selesai, $id)
	{
    date_default_timezone_set('Asia/jakarta');

		$mulai=date("H:i:s");
		$tgl_mulai = date("Y-m-d");
		$tgl_akhir = date('Y-m-d', strtotime($selesai));

		$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
		$selesai_time=(is_string($selesai)?strtotime($selesai):$selesai);

		$detik=$selesai_time-$mulai_time; //hitung selisih dalam detik
		if ($detik <= 60) {
		    $sisa_menit = 0;
		    $sisa_detik=$detik%1; //hitung sisa detik
		} else {
		    $sisa_menit=floor($detik/60); //hitung menit
		    $sisa_detik=$detik%$sisa_menit; //hitung sisa detik
		}

		// apakah hari ini
		if (strtotime($tgl_mulai) != strtotime($tgl_akhir)) {
			// melakukan pengubahan status
			$this->purchase_model->update(array('status' => '4'), $id);
		} else {
			if ($sisa_menit == 0 && $sisa_detik == 0) {
				// melakukan pengubahan status
				$this->purchase_model->update(array('status' => '4'), $id);
			} else {
			}
		}
	}
}
