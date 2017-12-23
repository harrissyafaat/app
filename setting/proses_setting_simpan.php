<?php
	include "../config/conn.php";
	
	$pros=$_GET[pros];
	
	$kode_jenis_simpan=$_POST[kode_jenis_simpan];
	$nama_simpanan=$_POST[nama_simpanan];
	$besar_simpanan=$_POST[besar_simpanan];
	$u_entry=$_POST[u_entry];
	$tgl_entri=$_POST[tgl_entri];
	
	switch ($pros){	
		case "tambah" :
			if($pros=='tambah'){
				$qtambah=mysqli_query($koneksi, "INSERT INTO t_jenis_simpan VALUES('$kode_jenis_simpan','$nama_simpanan','$besar_simpanan','$u_entry','$tgl_entri');");
			}
			header("location:../index.php?pilih=4.1");
		break;	
		
		case "ubah" :
			$qubah=mysqli_query($koneksi, "UPDATE t_jenis_simpan SET nama_simpanan='$nama_simpanan',besar_simpanan='$besar_simpanan',u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_jenis_simpan='$kode_jenis_simpan'");
			if($qubah){
				header("location:../index.php?pilih=4.1");
			}else{
				echo "Edit Data Gagal!!!";
			}
		break;		
		
		case "hapus" :
			$qdelete=mysqli_query($koneksi, "DELETE FROM t_jenis_simpan WHERE kode_jenis_simpan='$kode_jenis_simpan'");
			if($qdelete){
				header("location:../index.php?pilih=4.1");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;
		
		default : break; 
	}
	
?>