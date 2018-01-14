<?php
	include "../config/conn.php";

	$pros=$_GET['pros'];

	$kode_anggota=$_POST['kode_anggota'];
	$nama_anggota=$_POST['nama_anggota'];
	$alamat_anggota=$_POST['alamat_anggota'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$pekerjaan=$_POST['pekerjaan'];
	$tgl_masuk=$_POST['tgl_masuk'];
	$tgl_keluar=$_POST['tgl_keluar'];
	$telp=$_POST['telp'];
	$tempat_lahir=$_POST['tempat_lahir'];
	$tgl_lahir=$_POST['tgl_lahir'];
	$no_identitas=$_POST['no_identitas'];
	$photo=$_POST['photo'];
	$u_entry=$_POST['u_entry'];
	$tgl_entri=$_POST['tgl_entri'];

	/*$dir="img/";
	$foto=$_FILES[foto][name];
	move_uploaded_file($_FILES[foto][tmp_name],$dir.$foto);*/

	$lokasi = "../foto/";
	$photo = trim($_FILES['photo']['name']);
	move_uploaded_file($_FILES['photo']['tmp_name'],$lokasi.$photo);

	switch ($pros){
		case "tambah" :
			$kode = 'S0001';
			$q=mysqli_query($koneksi, "SELECT besar_simpanan AS pokok FROM t_jenis_simpan WHERE kode_jenis_simpan='$kode'");
			$data = mysql_fetch_array($q, MYSQLI_ASSOC);
			$pokok	= $data['pokok'];
			$qu=mysqli_query($koneksi, "INSERT INTO t_tabungan VALUES('',$pokok)");
			$que=mysqli_query($koneksi, "SELECT max(kode_tabungan) AS a FROM t_tabungan");
			$dt = mysqli_fetch_array($que);

				$qtambah=mysqli_query($koneksi, "INSERT INTO t_anggota values('$kode_anggota','$dt[a]','$nama_anggota','$alamat_anggota','$jenis_kelamin','$pekerjaan','$tgl_masuk','$tgl_keluar','$telp','$tempat_lahir','$tgl_lahir','$no_identitas','$photo','$u_entry','$tgl_entri')");
				$qtambah2=mysqli_query($koneksi, "INSERT INTO t_simpan VALUES('','$kode','$kode_anggota','$tgl_entri','$pokok','$u_entry','$tgl_entri')");

			header("location:../index.php?pilih=1.2");
		break;

		case "ubah" :
			if(empty($photo)){
				$qubah=mysqli_query($koneksi, "UPDATE t_anggota SET nama_anggota='$nama_anggota',alamat_anggota='$alamat_anggota',jenis_kelamin='$jenis_kelamin',pekerjaan='$pekerjaan',tgl_masuk='$tgl_masuk',tgl_keluar='$tgl_keluar',telp='$telp',tempat_lahir='$tempat_lahir',tgl_lahir='$tgl_lahir',no_identitas='$no_identitas', u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_anggota='$kode_anggota'");
			}else{
				$photo = $lokasi.$photo;
				move_uploaded_file($_FILES['photo']['tmp_name'],$photo);
				$qubah=mysqli_query($koneksi, "UPDATE t_anggota SET nama_anggota='$nama_anggota',alamat_anggota='$alamat_anggota',jenis_kelamin='$jenis_kelamin',pekerjaan='$pekerjaan',tgl_masuk='$tgl_masuk',tgl_keluar='$tgl_keluar',telp='$telp',tempat_lahir='$tempat_lahir',tgl_lahir='$tgl_lahir',no_identitas='$no_identitas',photo='$photo',simpanan_pokok='$simpanan_pokok',u_entry='$u_entry',tgl_entri='$tgl_entri' WHERE kode_anggota='$kode_anggota'");
			}
			header("location:../index.php?pilih=1.2");
		break;

		case "hapus" :
			$qdelete=mysqli_query($koneksi, "DELETE FROM t_anggota WHERE kode_anggota='$kode_anggota'");
			if($qdelete){
				header("location:../index.php?pilih=1.2");
			}else{
				echo "Hapus Data Gagal!!!!";
			}
		break;

		default : break;
	}

?>
