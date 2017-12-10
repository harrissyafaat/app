<?php
	include "../config/koneksi.php";

$kode_anggota		= $_POST['kode_anggota'];	
// SIMPAN
$kode_simpan		= $_POST['kode_simpan'];
$tgl_simpan			= $_POST['tgl_simpan'];
$kode_jenis_simpan	= $_POST['kode_jenis_simpan'];
$besar_simpanan		= $_POST['besar_simpanan'];
$user_entri			= $_POST['user_entri'];
$tgl_entri			= $_POST['tgl_entri'];

// PINJAM
$kode_pinjam		= $_POST['kode_pinjam'];
$tgl_pinjam			= $_POST['tgl_pinjam'];
$kode_jenis_pinjam	= $_POST['kode_jenis_pinjam'];
$besar_pinjaman		= $_POST['besar_pinjaman'];
$besar_angsuran		= $_POST['besar_angsuran'];
$lama_angsuran		= $_POST['lama_angsuran'];
$u_entry			= $_POST['u_entry'];
$tgl_entri			= $_POST['tgl_entri'];

// ANGSUR
$kode_angsur		= $_POST['kode_angsur'];
$tgl_angsur			= $_POST['tgl_angsur'];
$angsuran_ke		= $_POST['angsuran_ke'];
$sisa_angsuran		= $_POST['sisa_angsuran'];
$sisa_pinjaman		= $_POST['sisa_pinjaman'];
$u_entry			= $_POST['u_entry'];
$tgl_entri			= $_POST['tgl_entri'];
	
$pros=$_GET['pros'];

if($pros=="simpan" || $pros=="pinjam"){	
	$q=mysql_query("SELECT T.besar_tabungan, A.kode_tabungan
					FROM t_tabungan T, t_anggota A
					WHERE T.kode_tabungan = A.kode_tabungan
					AND A.kode_anggota = '$kode_anggota'");

	$data=mysql_fetch_array($q);
	$tb = new Tabungan($data['besar_tabungan']);
	
} elseif($pros=="angsur"){
	$q=mysql_query("SELECT T.besar_tabungan, A.kode_tabungan
					FROM t_tabungan T, t_anggota A
					WHERE T.kode_tabungan = A.kode_tabungan
					AND A.kode_anggota = '$kode_anggota'");
	$data=mysql_fetch_array($q);
	$tb = new Tabungan($data['besar_tabungan']);	
	
	$qu=mysql_query("SELECT * 
					FROM t_pinjam
					WHERE kode_anggota='$kode_anggota'");
	$data2=mysql_fetch_array($qu);
	
	$sisang = $data2['lama_angsuran'] - $angsuran_ke;
	$sipin	= $data2['sisa_pinjaman'] - $besar_angsuran;
}

	switch($pros){
		case "simpan"	:	$tb->simpan($besar_simpanan);
					  		$saldo_baru = $tb->cek_saldo();
							$qtambah=mysql_query("INSERT INTO t_simpan VALUES('','$kode_jenis_simpan','$kode_anggota','$tgl_simpan','$besar_simpanan','$user_entry','$tgl_entri')");

							$q=mysql_query("UPDATE t_tabungan SET besar_tabungan = '$saldo_baru' 
					  						WHERE kode_tabungan='$data[kode_tabungan]'");
							
							echo "<iframe  src=\"../tandabukti/cetak_buku.php?kode_anggota=".$kode_anggota."\" style=\"display:none;\" name=\"frame\"></iframe>";
							echo "<script>frames['frame'].print(); window.location.replace('../index.php?pilih=2.1');</script>";
							//header("location:../index.php?pilih=2.1");
							break;
		
		case "pinjam"	:	$tb->pinjam($besar_pinjaman);
							$saldo_baru = $tb->cek_saldo();
							$qtambah=mysql_query("INSERT INTO t_pinjam
							VALUES('','$kode_anggota','$kode_jenis_pinjam','$tgl_pinjam','$besar_pinjaman','$besar_pinjaman','$besar_angsuran','$lama_angsuran','$lama_angsuran','$u_entry','$tgl_entri')");
							$q=mysql_query("UPDATE t_tabungan SET besar_tabungan = '$saldo_baru'
							 				WHERE kode_tabungan='$data[kode_tabungan]'");

							header("location:../index.php?pilih=2.1");
							break;
		
		case "angsur"	:	
							// $tb = new Tabungan($data['besar_angsuran']);
							$tb->simpan($besar_angsuran);
					  		$saldo_baru = $tb->cek_saldo();
							
							//INSERT data angsur
							$qtambah=mysql_query("INSERT INTO t_angsur
												VALUES('','$kode_pinjam','$kode_anggota','$tgl_angsur','$besar_angsuran','$angsuran_ke','$u_entry','$tgl_entri')");

							$qubah=mysql_query("UPDATE t_pinjam SET sisa_angsuran = '$sisang', sisa_pinjaman = '$sipin' WHERE kode_pinjam='$kode_pinjam'");	
							$q=mysql_query("UPDATE t_tabungan SET besar_tabungan = '$saldo_baru'
											WHERE kode_tabungan='$data[kode_tabungan]'");

							header("location:../index.php?pilih=2.1");
							break;
	}
?>