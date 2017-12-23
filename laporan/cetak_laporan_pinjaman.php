<?php 
header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
header("Last-Modified:". gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-Control: private");
header("Content-Type: application/vnd.ms-word; name='word'");
header("Content-disposition: attachment; filename=LapPinjaman.doc");

	include "../config/conn.php";
	include "../fungsi/fungsi.php";
	
	$bulan = explode(" ","Januari Februari Maret April Mei Juni Juli September Oktober November Desember");
	$bln = date("m");
	$bln = ($bln < 10)? $bln = substr($bln,1,1) : $bln;
?>
<link rel="stylesheet" type="text/css" href="../css/cetak.css" />
<body>
<div class="box">
	<div class="header">Jam'iyah Waqi'ah "Sunan Kalijogo"</div>
	<div class="simpanan">LAPORAN DATA PINJAMAN ANGGOTA</div>
	<div class="tgl">Per Tanggal <?php echo date("d ").$bulan[$bln-2].date(" Y");?></div>
<table align="center" border="0" width="800px">
	<tr bgcolor="#CCCCCC">
		<th>No</th>
		<th>Nama</th>
		<th>Tanggal Pinjam</th>
		<th>Jenis Pinjaman</th>
		<th>Besar Pinjaman</th>		
		<th>Besar Angsuran</th>		
		<th>Sisa Angsuran</th>	
	</tr>
<?php

$query = mysqli_query($koneksi, "SELECT P.*, A.kode_anggota,A.nama_anggota ,J.nama_pinjaman
						FROM t_pinjam P, t_anggota A, t_jenis_pinjam J
						WHERE P.kode_anggota = A.kode_anggota
						AND P.kode_jenis_pinjam = J.kode_jenis_pinjam
						GROUP BY A.nama_anggota ASC");
$no=1;
		
	while($data=mysqli_fetch_array($query)){
?>
	<tr>
		<td align="center"><?php echo $no++;?></td>
		<td><?php echo $data['nama_anggota'];?></td>
		<td align="center"><?php echo Tgl($data['tgl_pinjam']);?></td>
		<td align="center"><?php echo $data['nama_pinjaman'];?></td>
		<td align="center"><?php echo Rp($data['besar_pinjaman']);?></td>
		<td align="center"><?php echo Rp($data['besar_angsuran']);?></td>
		<td align="center"><?php echo Rp($data['sisa_angsuran']);?></td>
	</tr> 
<?php
	}
?>
</table>
<div class="ttd">( ____________________ )</div>
</div>
</body>