<?php
session_start();
include '../config/conn.php';

$u_entry = $_SESSION['kopname'];
$tgl_sekarang = date('Y-m-d');

$qt = mysqli_query ($koneksi, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
$sel_tgl_hitung = $rt['tgl_hitung'];

$listAnggota = mysqli_query ($koneksi, "SELECT kode_anggota FROM t_simpan GROUP BY kode_anggota");
while ($row = $listAnggota->fetch_assoc()) {
	// Hitung Bunga Pinjam
	$qselsih_simpan = mysqli_query ($koneksi, "SELECT DATEDIFF('$tgl_sekarang', tgl_masuk) AS selisih FROM t_anggota WHERE kode_anggota='$row[kode_anggota]'");
	$rselisih_simpan = mysqli_fetch_array($qselsih_simpan, MYSQLI_ASSOC);

	$qsaldo_simpan = mysqli_query ($koneksi, "SELECT SUM(besar_simpanan) AS saldo FROM t_simpan WHERE kode_anggota='$row[kode_anggota]'");
	$rsaldo_simpan = mysqli_fetch_array($qsaldo_simpan, MYSQLI_ASSOC);

	if ($rselisih_simpan['selisih'] < 30){
		$bunga_simpan = ceil(0.0005 * $rselisih_simpan['selisih'] * $rsaldo_simpan['saldo']);
		if ($bunga_simpan > 0){
			$qSimpan = mysqli_query ($koneksi, "INSERT INTO t_simpan (kode_simpan, kode_jenis_simpan, kode_anggota, tgl_simpan, besar_simpanan, u_entry, tgl_entri) VALUES('','1051','$row[kode_anggota]', CURDATE() ,'$bunga_simpan','$u_entry', CURDATE())");	
		}
	} else {
		$bunga_simpan = ceil(0.0005 * $sel_tgl_hitung * $rsaldo_simpan['saldo']);
		if ($bunga_simpan > 0){
			$qtambah_bunga_simpan = mysqli_query ($koneksi, "INSERT INTO t_simpan (kode_simpan, kode_jenis_simpan, kode_anggota, tgl_simpan, besar_simpanan, u_entry, tgl_entri) VALUES('','1051','$row[kode_anggota]', CURDATE() ,'$bunga_simpan','$u_entry', CURDATE())");
		}
	}

	// Hitung Bunga Pinjam
	$qselisih_pinjam = mysqli_query ($koneksi, "SELECT DATEDIFF('$tgl_sekarang', tgl_masuk) AS selisih FROM t_anggota WHERE kode_anggota='$row[kode_anggota]'");
	$rselisih_pinjam = mysqli_fetch_array($qselisih_pinjam, MYSQLI_ASSOC);
	$qsaldo_pinjam = mysqli_query ($koneksi, "SELECT SUM(besar_pinjaman) AS saldo FROM t_pinjam WHERE kode_anggota='$row[kode_anggota]'");
	$rsaldo_pinjam = mysqli_fetch_array($qsaldo_pinjam, MYSQLI_ASSOC);

	if ($rselisih_pinjam['selisih'] < 30){
		$bp = ceil(0.005 * $rsp['selisih'] * $rsalp['saldo']);
		$bunga_pinjam = 0 - $bp;
		if ($bunga_pinjam < 0){
			//$qBunga_pinjam = mysqli_query ($koneksi, "INSERT INTO t_pinjam (kode_pinjam, kode_anggota, kode_jenis_pinjam, tgl_pinjam, )")
		}
	} else {
		// Insert Bunga Pinjam
	}
}

$qtbh = mysqli_query ($koneksi, "INSERT INTO t_bagihasil (id, tgl_hitung, u_entry) VALUES ('', CURDATE(), '$u_entry')");
echo "<script>alert('Bunga Telah Ditambahkan'); window.location.replace('../index.php');</script>";


?>