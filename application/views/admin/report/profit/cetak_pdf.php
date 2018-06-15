<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Keuntungan</title>

	<style type="text/css">

	body {
	background-color: #fff;
	margin: 40px;
	font-family: Lucida Grande, Verdana, Sans-serif;
	font-size: 14px;
	color: #4F5155;
	}

	a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
	}

	h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: bold;
	margin: 24px 0 2px 0;
	padding: 5px 0 6px 0;
	}

	code {
	font-family: Monaco, Verdana, Sans-serif;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
	}
	table,th,td { border:1px solid black; border-collapse:collapse; } th,td { padding:5px; }

	</style>
</head>
<body>

<h1>Laporan Keuntungan Penjualan </h1>

<p><b>Bulan <?php echo bulan($month); ?> 2019</b></p>

<table width="100%">
	<tr align="center" style="font-size: 19px; font-weight: 900; ">
		<td style="width: 5%">No.</td>
		<td style="width: 10%">Kode Pembelian</td>
		<td>Waktu</td>
		<td style="width: 20%">Jumlah</td>
	</tr>

	<?php $no = 1; foreach($data as $value) {  ?>
	<tr> 
		<td align="center"><?php echo $no++; ?>.</td>
		<td align="center"><?php echo $value->kode_pembelian; ?></td>
		<td><?php echo dateFormatBulan(4, $value->created_at) ?></td>
		<td align="left"><?php echo money($value->jumlah_bayar) ?></td>
	</tr>
	<?php } ?>

	<tr>
		<td colspan="3" align="right">TOTAL PENJUALAN</td>
		<td align="left"><b><?php echo money($total->jumlah); ?></b></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 16px; font-weight: 900;" align="right">TOTAL KEUNTUNGAN</td>
		<td align="left"><b><?php echo money($total_profit->biaya_jual - $total_profit->biaya_produksi); ?></b></td>
	</tr>
</table>

</body>
</html>