<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_model extends MY_Model
{  
	public function __construct()
	{
        // $this->table = 'uang_gedung';
        // $this->primary_key = 'id'; 
        // // $this->soft_deletes = TRUE;
        // $this->protected = array('id');
 

		parent::__construct();
	}  

    public function getProvinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
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

        return json_decode($response, true);  
    }

    public function getKabupaten($provinsi_id=NULL)
    { 
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$provinsi_id",
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

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          //echo $response;
        }

        return json_decode($response, true); 
    }

    public function getOngkir($asal=NULL, $id_kabupaten=NULL, $kurir=NULL, $berat=NULL)
    { 
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 05e80c32fca42d47810467cd2f87f297"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          // echo $response;
        }
 
        return json_decode($response, true); 
    } 

    public function kode_pembelian()
    { 
      $this->db->select('RIGHT(tb_pembelian.kode_pembelian,3) as kode', FALSE);
      $this->db->order_by('kode_pembelian','DESC');    
      $query = $this->db->get('tb_pembelian');      

      if($query->num_rows() <> 0) {             
          $data = $query->row();      
          $kode = intval($data->kode) + 1;     
      } else {          
          $kode = 1;     
      }

      $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);    
      $kodejadi = "OR-".$kodemax;  
      return $kodejadi;   
    }
}
