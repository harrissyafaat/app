<?php
	include "../config/koneksi.php";
	
	$pros=$_GET['pros'];
	
	$kode_jenis_pinjam=$_POST['kode_jenis_pinjam'];
	$nama_pinjaman=$_POST['nama_pinjaman'];
	$lama_angsur=$_POST['lama_angsur'];
	$keterangan=$_POST['keterangan'];
	$u_entry=$_POST['u_entry'];
	$tgl_entri=$_POST['tgl_entri'];
	
	switch ($pros){		
		case "tambah" :
			if($pros=='tambah'){
				$qtambah=mysql_query("INSERT INTO t_jenis_pinjam VALUES('$kode_jenis_pinjam','$nama_pinjaman','$lama_angsur','$keterangan','$u_entry','$tgl_entri');");
			}
			header("location:../index.php?pilih=4.2");
		break;
		
		case "ubah" :
			$qubah=mysql_query("UPDATE t_jenis_pinjam SET nama_pinjaman='$nama_pinjaman',lama_angsur='$lama_angsur',keterangan='$keterangan',u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_jenis_pinjam='$kode_jenis_pinjam'");
			if($qubah){
				header("location:../index.php?pilih=4.2");
			}else{
				echo "Edit Data Gagal!!!";
			}
		break;		
		
		case "hapus" :
			$qdelete=mysql_query("DELETE FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode_jenis_pinjam'");
			if($qdelete){
				header("location:../index.php?pilih=4.2");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;
		
		default : break; 
	}
	
?>