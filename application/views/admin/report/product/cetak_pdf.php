<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PDF Created</title>

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

<h1>Laporan Produk </h1>

<p><b><?php echo $category; ?></b> <?php echo dateFormatBulan(4, $newDateFormat) ?></p>

<table width="100%">
	<tr align="center" style="font-size: 19px; font-weight: 900; ">
		<td style="width: 5%">No.</td>
		<td style="width: 80%">Nama Produk</td>
		<td>Jumlah Terjual</td>
	</tr>

	<?php $no = 1; foreach($data as $value) {  ?>
	<tr>
		<td align="center"><?php echo $no++; ?>.</td>
		<td><?php echo $value->nama; ?></td>
		<td align="center"><?php echo $value->jumlah ?></td>
	</tr>
	<?php } ?>

	<tr>
		<td colspan="2" style="font-size: 16px; font-weight: 900;" align="right">TOTAL PENJUALAN</td>
		<td align="center"><b><?php echo $total->total; ?></b></td>
	</tr>
</table>

</body>
</html>