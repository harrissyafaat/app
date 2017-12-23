<?php
	include "../config/conn.php";
	
	$pros=$_GET['pros'];
	
	$kode_jenis_pinjam=$_POST['kode_jenis_pinjam'];
	$nama_pinjaman=$_POST['nama_pinjaman'];
	$lama_angsuran=$_POST['lama_angsuran'];
	$maks_pinjam=$_POST['maks_pinjam'];
	$keterangan=$_POST['keterangan'];
	$u_entry=$_POST['u_entry'];
	$tgl_entri=$_POST['tgl_entri'];
	
	switch ($pros){		
		case "tambah" :
			if($pros=='tambah'){
				$qtambah=mysqli_query($koneksi, "INSERT INTO t_jenis_pinjam VALUES('$kode_jenis_pinjam','$nama_pinjaman','$lama_angsuran','$maks_pinjam','$u_entry','$tgl_entri');");
			}
			header("location:../index.php?pilih=4.2");
		break;
		
		case "ubah" :
			$qubah=mysqli_query($koneksi, "UPDATE t_jenis_pinjam SET nama_pinjaman='$nama_pinjaman',lama_angsuran='$lama_angsuran',u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_jenis_pinjam='$kode_jenis_pinjam'");
			if($qubah){
				header("location:../index.php?pilih=4.2");
			}else{
				echo "Edit Data Gagal!!!";
			}
		break;		
		
		case "hapus" :
			$qdelete=mysqli_query($koneksi, "DELETE FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode_jenis_pinjam'");
			if($qdelete){
				header("location:../index.php?pilih=4.2");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;
		
		default : break; 
	}
	
?>