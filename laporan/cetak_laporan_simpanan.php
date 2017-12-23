<?php 
header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
header("Last-Modified:". gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-Control: private");
header("Content-Type: application/vnd.ms-word; name='word'");
header("Content-disposition: attachment; filename=LapSimpanan.doc");

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
	<div class="simpanan">LAPORAN DATA SIMPANAN ANGGOTA</div>
	<div class="tgl">Per Tanggal <?php echo date("d ").$bulan[$bln-2].date(" Y");?></div>
<table align="center" border="0" width="800px">
	<tr bgcolor="#CCCCCC">
		<th rowspan="2">No</th>
		<th rowspan="2" width="220">Nama</th>
		<th colspan="3">Simpanan</th>
		<th rowspan="2">Total Simpanan</th>					
	</tr>
	<tr bgcolor="#CCCCCC">
		<th>Pokok</th>
		<th>Wajib</th>
		<th>Sukarela</th>
	</tr>
<?php

$query = mysqli_query($koneksi, "SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
					FROM t_simpan S, t_anggota A, t_jenis_simpan J
					WHERE S.kode_anggota = A.kode_anggota
					AND S.kode_jenis_simpan = J.kode_jenis_simpan
					GROUP BY A.kode_anggota");
$no=1;
		
	while($data=mysqli_fetch_array($query)){
		$kode=$data['kode_anggota'];
		$query1=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND S.kode_jenis_simpan='S0001'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qpokok=mysqli_fetch_array($query1);
		
		$query2=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0002'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qwajib=mysqli_fetch_array($query2);
		
		$query3=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0003'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qsukarela=mysqli_fetch_array($query3);
		
		$total = $qpokok['total'] + $qwajib['total'] + $qsukarela['total'];

?>
	<tr>
		<td align="center"><?php echo $no++;?></td>
		<td><?php echo $data['nama_anggota'];?></td>
		<td align="center"><?php echo Rp($qpokok['total']?$qpokok['total']:0);?></td>
		<td align="center"><?php echo Rp($qwajib['total']?$qwajib['total']:0);?></td>
		<td align="center"><?php echo Rp($qsukarela['total']?$qsukarela['total']:0);?></td>
		<td align="center"><?php echo Rp($total);?></td>
	</tr> 
<?php
	}
?>
</table>
<div class="ttd">( ____________________ )</div>
</div>
</body>