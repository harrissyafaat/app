<?php
include "config/conn.php";
$kode_pinjam = $_POST['kode_pinjam'];

if($kode_pinjam!=""){
	$sql = "SELECT *
			FROM t_pinjam
			WHERE kode_pinjam='$kode_pinjam'";
	$sql1 = "SELECT a.*
			FROM t_angsur a
			WHERE a.kode_pinjam='$kode_pinjam' and 
			a.kode_angsur=(select max(kode_angsur) from t_angsur where kode_pinjam='$kode_pinjam')";

	$data = mysqli_query($koneksi, $sql);
	$data1 = mysqli_query($koneksi, $sql1);

	if($d = mysqli_fetch_object($data)){
		$d1 = mysqli_fetch_object($data1);
		$arr = array("KODE_PINJAM"=>$d->kode_pinjam,
						"TGL_PINJAM"=>$d->tgl_pinjam,
						"BESAR_PINJAMAN"=>$d->besar_pinjaman,
						"LAMA_ANGSURAN"=>$d->lama_angsuran,
						"BESAR_ANGSURAN"=>$d->besar_angsuran,
						"ANGSURAN_KE" => $d1->angsuran_ke+1,
						"SISA_PINJAMAN"	=> $d->sisa_pinjaman,
						);			 	 	 	 	 	 	
	}else{
		$arr = array("KODE_PINJAM"=>"",
						"TGL_PINJAM"=>"",
						"BESAR_PINJAMAN"=>"",
						"LAMA_ANGSURAN"=>"",
						"BESAR_ANGSURAN"=>"",
						"SISA_PINJAMAN"	=> "",
						);
	}
	$arr = json_encode($arr);
	exit($arr);
}
?>