<?php
/**
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Andre Hardika (andrehardika@gmail.com)
 */
if (!function_exists('cek_stok')) {
	/**
     * Cek keberadaan file di dalam direktori yang bersangkutan
     *
     * @param string $filename, string $path, $default
     *
     * @return string $filename
     */
	function cek_stok($id_produk){ 
        $ci =& get_instance();
        $ci->load->database();

		$query = $ci->db->query("select id_produk, qty, (sisa_stok - sum(qty)) as sisa_stok, tb_pembelian.`status` from tb_detail_pembelian
        join tb_pembelian ON tb_detail_pembelian.id_pembelian = tb_pembelian.id
        join tb_produk ON tb_detail_pembelian.id_produk = tb_produk.id
        where (tb_pembelian.`status` = '0' OR tb_pembelian.`status` = '1') AND tb_detail_pembelian.id_produk = ".$id_produk); 
        $result = $query->row();

		$qproduk = $ci->db->query("select * from tb_produk where id = ".$id_produk); 
        $produk = $qproduk->row();

        if ($result->sisa_stok == NULL) {
            $sisa_stok = $produk->sisa_stok;
        } else {
            $sisa_stok = $result->sisa_stok;
        }

		return $sisa_stok;
	}
}
?>