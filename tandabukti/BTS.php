<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="1">

<title>Bukti Transaksi Simpanan</title>
</head>

<?php
	include "../config/koneksi.php";
	include "../fungsi/fungsi.php";
	
	$a=mysql_query("SELECT S.*, J.nama_simpanan, A.nama_anggota
		FROM t_simpan S, t_jenis_simpan J, t_anggota A
		WHERE S.kode_jenis_simpan = J.kode_jenis_simpan AND S.kode_anggota = A.kode_anggota AND S.kode_simpan=(
		SELECT MAX(b.kode_simpan)
		FROM t_simpan b) AND S.kode_anggota='$_GET[kode_anggota]'");

	$data=mysql_fetch_array($a);
	
	$terbilang = new angkaTerbilang();

?>

<body>
<div style="width:800px; border:#000000 solid 3px;">
<form name="bts">
	<table border="0" align="center" width="600">
		<tr>
			<td><img src="../logo_kop.gif" width="89" height="81" /></td>
			<td colspan="3" rowspan="2"><h2>Jam'iyah Waqi'ah "Sunan Kalijogo"</h2></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6" align="center"><b>BUKTI TRANSAKSI SIMPANAN (BTS)<hr color="#000000" size="2" /></b></td>
		</tr>
	</table>
	<table border="0" align="center">
		<tr>
			<td width="100"	>Jenis Transaksi</td>
			<td width="30" align="center">:</td>
			<td width="315" colspan="3"><?php echo $data['nama_simpanan'];?></td>
		</tr>
		<tr>
			<td>Nama Penyetor</td>
			<td align="center">:</td>
			<td colspan="3"><?php echo $data['nama_anggota'];?></td>
		</tr>
		<tr>
			<td>Jumlah</td>
			<td align="center">:</td>
			<td colspan="3">Rp <?php echo Rp($data['besar_simpanan']);?></td>
		</tr>
		<tr>
			<td>Terbilang</td>
			<td align="center">:</td>
			<td colspan="3"><?php echo $terbilang->baca($data['besar_simpanan']);?> rupiah </td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</table>
	<table width="600" border="0" align="center">
		<tr align="center">
			<td width="200" colspan="2">Diketahui oleh,</td>
			<td width="200" colspan="2">Diterima oleh,</td>
			<td width="200" colspan="2">Dibayarkan oleh,</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr align="center">
			<td width="200" colspan="2">_ _ _ _ _ _ _ _ _</td>
			<td width="200" colspan="2"><?php session_start(); echo $_SESSION['kopname'];?></td>
			<td width="200" colspan="2"><?php echo $data['nama_anggota'];?></td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
  </table>
</form>
</div>
<div>
<table style="padding-top: 15px; " width="700" align="center">
    <tr>
        <td><input style="width: 100px; height: 30px;" type="button" onclick="window.print();" value="Cetak"></td>
        <td><input style="width: 100px; height: 30px;" type="button" onclick="self.close();" value="Tutup"></td>
    </tr>
</table>
</div>
</body>
</html>