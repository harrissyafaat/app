<?php

include '../config/conn.php';

$u_entry = 'admin';
$tgl_sekarang = date('Y-m-d');

$qt = mysqli_query ($koneksi, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
$sel_tgl_hitung = $rt['tgl_hitung'];

$listAnggota = mysqli_query ($koneksi, "SELECT kode_anggota FROM t_simpan GROUP BY kode_anggota");
while ($row = $listAnggota->fetch_assoc()) {
	$qSelisih = mysqli_query ($koneksi, "SELECT DATEDIFF('$tgl_sekarang', tgl_masuk) AS selisih FROM t_anggota WHERE kode_anggota='$row[kode_anggota]'");
	$rSelisih = mysqli_fetch_array($qSelisih, MYSQLI_ASSOC);
	$selisih = $rSelisih['selisih'];

	$qSaldo = mysqli_query ($koneksi, "SELECT SUM(besar_simpanan) AS saldo FROM t_simpan WHERE kode_anggota='$row[kode_anggota]'");
	$rSaldo = mysqli_fetch_array($qSaldo, MYSQLI_ASSOC);

	if ($selisih < 30){
		$hasilBagi = 0.0005 * $selisih * $rSaldo['saldo'];
		if ($hasilBagi > 0){
			$qBagiHasil = mysqli_query ($koneksi, "INSERT INTO t_simpan (kode_simpan, kode_jenis_simpan, kode_anggota, tgl_simpan, besar_simpanan, u_entry, tgl_entri) VALUES('','1051','$row[kode_anggota]', CURDATE() ,'$hasilBagi','$u_entry', CURDATE())");	
		}		

	} else {
		$hasilBagi = 0.0005 * $sel_tgl_hitung * $rSaldo['saldo'];
		$qBagiHasil = mysqli_query ($koneksi, "INSERT INTO t_simpan (kode_simpan, kode_jenis_simpan, kode_anggota, tgl_simpan, besar_simpanan, u_entry, tgl_entri) VALUES('','1051','$row[kode_anggota]', CURDATE() ,'$hasilBagi','$u_entry', CURDATE())");
		echo "<script>alert('Bunga Telah Ditambahkan'); window.location.replace('../index.php');</script>";
	}
}

?>