<?php 
header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
header("Last-Modified:". gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-Control: private");
header("Content-Type: application/vnd.ms-word; name='word'");
header("Content-disposition: attachment; filename=LapAnggota.doc");

	include "../config/conn.php";
	include "../fungsi/fungsi.php";

	$bulan = explode(" ","Januari Februari Maret April Mei Juni Juli September Oktober November Desember");
	$bln = date("m");
	$bln = ($bln < 10)? $bln = substr($bln,1,1) : $bln;

?>

<link rel="stylesheet" type="text/css" href="../css/cetak.css" />
</head>

<body>
<div class="box">
	<div class="header">Jam'iyah Waqi'ah "Sunan Kalijogo"</div>
	<div class="anggota">LAPORAN DATA ANGGOTA</div>
	<div class="tgl">Per Tanggal <?php echo date("d ").$bulan[$bln-2].date(" Y");?></div>
	<table align="center">
		<thead>
			<tr bgcolor="#CCCCCC">
				<th>No</th>
				<th>Kode Anggota</th>
				<th>Nama Anggota</th>
				<th>Jenis Kelamin</th>
				<th>Alamat</th>
				<th>Tempat / Tanggal Lahir</th>
				<th>Pekerjaan</th>
				<th>Tanggal Masuk</th>
			</tr>
		</thead>	
<?php
	$no=1;
	$a=mysqli_query($koneksi, "SELECT * FROM t_anggota");
	while($data=mysqli_fetch_array($a, MYSQLI_ASSOC)){
?>
		<tr>
			<td align="center"><?php echo $no++;?></td>
			<td align="center"><?php echo $data['kode_anggota'];?></td>
			<td><?php echo $data['nama_anggota'];?></td>
			<td><?php echo $data['jenis_kelamin'];?></td>
			<td><?php echo $data['alamat_anggota'];?></td>
			<td><?php echo $data['tempat_lahir'].' / '.$data['tgl_lahir'];?></td>
			<td><?php echo $data['pekerjaan'];?></td>
			<td align="center"><?php echo Tgl($data['tgl_masuk']);?></td>
		</tr>
<?php
}
?>
	</table>
<div class="ttd">( ____________________ )</div>

</div>
</body>
