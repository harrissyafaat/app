<?php
	include "../config/koneksi.php";
	
	$pros=$_GET[pros];
	
	$kode_user=$_POST['kode_user'];
	$kode_petugas=$_POST['kode_petugas'];
	$c_rule=$_POST['c_rule'];	
	$username=$_POST['username'];
	$password=$_POST['password'];
	$tgl_entri=$_POST['tgl_entri'];
	
		
	switch ($pros){
		case "tambah" :
			if($pros=='tambah'){
				$qtambah=mysql_query("INSERT INTO t_user VALUES('$kode_user','$kode_petugas','$c_rule','$username','$password','$tgl_entri');");
			}
			header("location:../index.php?pilih=4.3");
		break;
		
		case "ubah" :
			$qubah=mysql_query("UPDATE t_user SET username='$username',password='$password',kode_petugas='$kode_petugas',tgl_entri='$tgl_entri',c_rule='$c_rule' WHERE kode_user='$kode_user'");
			if($qubah){
				header("location:../index.php?pilih=4.3");
			}else{
				echo "Edit Data Gagal!!!";
			}
		break;
		
		case "hapus" :
			$qdelete=mysql_query("DELETE FROM t_user WHERE kode_user='$kode_user'");
			if($qdelete){
				header("location:../index.php?pilih=4.3");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;
		
		default : break; 
	}
	
?>