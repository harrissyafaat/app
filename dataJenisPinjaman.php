<?php
include "config/conn.php";
$kode_jenis_pinjam = $_POST['kode_jenis_pinjam'];

if($kode_jenis_pinjam!=""){
	$sql = "SELECT *
			FROM t_jenis_pinjam
			WHERE kode_jenis_pinjam='$kode_jenis_pinjam'";
	$data = mysqli_query($koneksi, $sql);
	if($d = mysqli_fetch_object($data)){
		$arr = array("KODE_JENIS_PINJAM"=>$d->kode_jenis_pinjam,
						"NAMA_PINJAMAN"=>$d->nama_pinjaman,
						"LAMA_ANGSURAN"=>$d->lama_angsuran,
						"MAKS_PINJAM"=>$d->maks_pinjam
						);			 	 	 	 	 	 	
	}else{
		$arr = array("KODE_JENIS_PINJAM"=>"",
						"NAMA_PINJAMAN"=>"",
						"LAMA_ANGSURAN"=>"",
						"MAKS_PINJAM"=>""
						);
	}
	$arr = json_encode($arr);
	exit($arr);
}
?>