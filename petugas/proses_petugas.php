<?php
	include "../config/conn.php";
	
	$pros=$_GET[pros];
	
	$kode_petugas=$_POST[kode_petugas];
	$nama_petugas=$_POST[nama_petugas];
	$alamat_petugas=$_POST[alamat_petugas];
	$telp=$_POST[telp];
	$jenis_kelamin=$_POST[jenis_kelamin];
	$u_entry=$_POST[u_entry];
	$tgl_entri=$_POST[tgl_entri];
	
	switch ($pros){
		case "tambah" :
			if($pros=='tambah'){
				$qtambah=mysqli_query($koneksi, "INSERT INTO t_petugas values('$kode_petugas','$nama_petugas','$alamat_petugas','$telp','$jenis_kelamin','$u_entry','$tgl_entri');");
			}
			header("location:../index.php?pilih=1.1");
		break;
		
		case "ubah" :
			$qubah=mysqli_query($koneksi, "UPDATE t_petugas SET nama_petugas='$nama_petugas',alamat_petugas='$alamat_petugas',telp='$telp',jenis_kelamin='$jenis_kelamin',u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_petugas='$kode_petugas'");

			if($qubah){
				header("location:../index.php?pilih=1.1");
			}else{
				echo "Edit Data Gagal!!!";
			}
		break;
		
		case "hapus" :
			$qdelete=mysqli_query($koneksi, 	"DELETE FROM t_petugas WHERE kode_petugas='$kode_petugas'");
			if($qdelete){
				header("location:../index.php?pilih=1.1");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;
		
		default : break; 
	}
	
?>