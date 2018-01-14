<?php
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<head>
<script language="JavaScript">
	$(document).ready(function(){
		$(function() {
			$( '#tanggal' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$( '#tgl_masuk' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
		});
	});
</script>
</head>

<?php
	if(empty($aksi)){
?>
<body>

	<div class="text-right">
	<a href="?pilih=1.2&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
	</div>
	<br>
	<div class="card mb-3">
	        <div class="card-header">
	          <i class="fa fa-table"></i> Data Petugas</div>
	        <div class="card-body">
	<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </thead>
		<tfoot>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </tfoot>
		<tbody>
<?php

			$query=mysqli_query($koneksi, "SELECT * FROM t_anggota
								ORDER BY kode_anggota ASC");
		$no=1;

	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>

    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo Tgl($data['tgl_masuk']);?></td>
            <td>
	<a class="btn btn-primary" href=index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-edit"></i></a>
  <a class="btn btn-danger" href=index.php?pilih=1.2&aksi=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-trash"></i></a>
	<a class="btn btn-success" href=index.php?pilih=1.2&aksi=cetak&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-print"></i></a>
			</td>
        </tr>

<?php
	} //tutup while
?>
</tbody>
</table>
</div>
</div>
</div>


<?php
	}elseif($aksi=='tambah'){
		$query=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan WHERE kode_jenis_simpan='S0001'");
		$data=mysqli_fetch_array($query, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Tambah Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=tambah" method="post" id="form" enctype="multipart/form-data">
<fieldset>
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo nomer("A","kode_anggota","t_anggota	");?>" readonly title="Kode harus diisi"/>
	</div>
    <?php
    	$kode = nomer("A","kode_anggota","t_anggota	");
    ?>
		<div class="form-group">
			<label for="tgl_masuk">Tanggal Masuk :</label>
			<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" class="required" title="Tanggal Masuk harus diisi">
		</div>
		<div class="form-group">
			<label for="simpanan_pokok">Simpanan Pokok :</label>
			<input class="form-control" type="text" name="simpanan_pokok" size="54" id="simpanan_pokok" class="required" readonly="" value="<?php echo $data['besar_simpanan'];?>">
		</div>
		<div class="form-group">
			<label for="nama_anggota">Nama Lengkap :</label>
			<input class="form-control" type="text" name="nama_anggota" size="54" class="required" title="Nama harus diisi"/>
		</div>
		<div class="form-group">
			<label for="jenis_kelamin">Jenis Kelamin :</label>
			<input type="radio" name="jenis_kelamin" value="Laki-laki" class="required" title="Jenis Kelamin harus diisi"/> Laki-laki
			<input type="radio" name="jenis_kelamin" value="Perempuan" class="required" title="Jenis Kelamin harus diisi"/> Perempuan
		</div>
		<div class="form-group">
			<label for="tempat_lahir">Tempat / Tanggal Lahir :</label>
			<input class="form-control" type="text" name="tempat_lahir" size="26" class="required" title="Tempat Lahir harus diisi" /> / <input class="form-control" type="text" name="tgl_lahir" size="21" id="tanggal" class="required" title="Tanggal Lahir harus diisi">
		</div>
		<div class="form-group">
			<label for="alamat_anggota">Alamat Anggota :</label>
			<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" class="required" title="Alamat harus diisi"></textarea>
		</div>
		<div class="form-group">
			<label for="no_identitas">No KTP/SIM :</label>
			<input class="form-control" type="text" name="no_identitas" size="54" class="required" title="No Identitas harus diisi"/>
		</div>
		<div class="form-group">
			<label for="telp">Telepon :</label>
			<input class="form-control" type="text" name="telp" size="54" class="required" title="Telepon harus diisi"/>
		</div>
		<div class="form-group">
			<label for="pekerjaan">Pekerjaan :</label>
			<input class="form-control" type="text" name="pekerjaan" size="54" class="required" title="Pekerjaan harus diisi" />
		</div>
		<div class="form-group">
			<label for="user_entri">User Entri :</label>
			<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
		</div>
		<div class="form-group">
			<label for="tgl_entri">Tanggal Entri :</label>
			<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
		</div>
		<div class="form-group text-center">
			<input class="btn btn-primary" type="submit" name="daftar" id="button1" value="Daftar" onClick="cetak_baru();" />
			<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
		</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Ubah Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=ubah" method="post" id="form" enctype="multipart/form-data">
<fieldset>
	<!-- <?php if($data2['photo']){?><img src="<?php echo $data2['photo'];?>" /><?php }else{?> <img src="img/who.gif" /> <?php }?> -->
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo $data2['kode_anggota'];?>" readonly=""/>
	</div>
	<div class="form-group">
		<label for="tgl_masuk">Tanggal Masuk :</label>
		<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data2['tgl_masuk'];?>">
	</div>
	<div class="form-group">
		<label for="nama_anggota">Nama Lengkap :</label>
		<input class="form-control" type="text" name="nama_anggota" size="54" value="<?php echo $data2['nama_anggota'];?>"/>
	</div>
	<div class="form-group">
		<label for="jenis_kelamin">Jenis Kelamin :</label>
		<?php
			if ($data2['jenis_kelamin'] == "Laki-laki"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
			}else if ($data2['jenis_kelamin'] == "Perempuan"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked>Perempuan";
			}
		?>
	</div>
	<div class="form-group">
		<label for="tempat_lahir">Tempat / Tanggal Lahir :</label>
		<input class="form-control" type="text" name="tempat_lahir" size="26" value="<?php echo $data2['tempat_lahir'];?>"/> / <input class="form-control" type="text" name="tgl_lahir" size="21" value="<?php echo $data2['tgl_lahir'];?>">
	</div>
	<div class="form-group">
		<label for="alamat_anggota">Alamat Anggota :</label>
		<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41"><?php echo $data2['alamat_anggota'];?></textarea>
	</div>
	<div class="form-group">
		<label for="no_identitas">No KTP/SIM :</label>
		<input class="form-control" type="text" name="no_identitas" size="54" value="<?php echo $data2['no_identitas'];?>"/>
	</div>
	<div class="form-group">
		<label for="telp">Telepon :</label>
		<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>"/>
	</div>
	<div class="form-group">
		<label for="pekerjaan">Pekerjaan :</label>
		<input class="form-control" type="text" name="pekerjaan" size="54" value="<?php echo $data2['pekerjaan'];?>"/>
	</div>
	<div class="form-group">
		<label for="photo">Foto :</label>
		<input class="form-control" type="file" name="photo" value="<?php echo $data2['photo'];?>"/>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly />
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_anggota'];
		$qhapus=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data3=mysqli_fetch_array($qhapus, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Hapus Data Anggota</div>
  <div class="card-body">
<form action="anggota/proses_anggota.php?pros=hapus" method="post" id="form">
<h4 id="adduser">Data Pribadi</h4>
<fieldset>
	<!-- <?php if($data2['photo']){?><img src="<?php echo $data2['photo'];?>" /><?php }else{?> <img src="img/who.gif" /> <?php }?> -->
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="54" value="<?php echo $data2['kode_anggota'];?>" readonly=""/>
	</div>
	<div class="form-group">
		<label for="tgl_masuk">Tanggal Masuk :</label>
		<input class="form-control" type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data2['tgl_masuk'];?>" readonly>
	</div>
	<div class="form-group">
		<label for="nama_anggota">Nama Lengkap :</label>
		<input class="form-control" type="text" name="nama_anggota" size="54" value="<?php echo $data2['nama_anggota'];?>" readonly/>
	</div>
	<div class="form-group">
		<label for="jenis_kelamin">Jenis Kelamin :</label>
		<?php
			if ($data2['jenis_kelamin'] == "Laki-laki"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' readonly>Perempuan";
			}else if ($data2['jenis_kelamin'] == "Perempuan"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked readonly>Perempuan";
			}
		?>
	</div>
	<div class="form-group">
		<label for="tempat_lahir">Tempat / Tanggal Lahir :</label>
		<input class="form-control" type="text" name="tempat_lahir" size="26" value="<?php echo $data2['tempat_lahir'];?>" readonly/> / <input class="form-control" type="text" name="tgl_lahir" size="21" value="<?php echo $data2['tgl_lahir'];?>" readonly>
	</div>
	<div class="form-group">
		<label for="alamat_anggota">Alamat Anggota :</label>
		<textarea class="form-control" name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" readonly><?php echo $data2['alamat_anggota'];?></textarea>
	</div>
	<div class="form-group">
		<label for="no_identitas">No KTP/SIM :</label>
		<input class="form-control" type="text" name="no_identitas" size="54" value="<?php echo $data2['no_identitas'];?>" readonly/>
	</div>
	<div class="form-group">
		<label for="telp">Telepon :</label>
		<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>" readonly/>
	</div>
	<div class="form-group">
		<label for="pekerjaan">Pekerjaan :</label>
		<input class="form-control" type="text" name="pekerjaan" size="54" value="<?php echo $data2['pekerjaan'];?>" readonly/>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly />
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="hapus" id="button1" value="Hapus" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
}elseif($aksi=='cetak'){
$kode=$_GET['kode_anggota'];
$query=mysqli_query($koneksi, "SELECT *
					FROM t_anggota
					WHERE kode_anggota = '$kode'");
$data=mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<table>
	<tr>
		<td rowspan="2" align="center"><img src="logo_kop.gif" width="50" height="45" /></td>
		<td colspan="3">Jam'iyah Waqi'ah "Sunan Kalijogo"</td>
	</tr>
	<tr>
		<td colspan="3">Jln. Puspogiwangan Dalam I No. 20 Semarang</td>
	</tr>
	 <tr>
		<td colspan="4"><hr /><hr /></td>
	</tr>
	<tr>
		<td>No Anggota</td>
		<td>:</td>
		<td><?php echo $data['kode_anggota'];?></td>
		<td rowspan="4"><?php echo $data['photo'];?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $data['nama_anggota'];?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?php echo $data['alamat_anggota'];?></td>
	</tr>
	<tr>
		<td>Tanggal Masuk</td>
		<td>:</td>
		<td><?php echo $data['tgl_masuk'];?></td>
	</tr>
</table><br />
<input type="button" value="Cetak Kartu Anggota" onclick="cetak();" title="cetak kartu anggota" name="" style="float: right; margin-right: 100px; width: 200px; height: 30px;">
<?php
	}
?>
<script type="text/javascript">
	function cetak(){
		controlWindow=window.open("anggota/kartuAnggota.php?kode_anggota=<?php echo $kode ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=650,height=550");
	}
	function cetak_baru(){
		controlWindow=window.open("anggota/kartuAnggota.php?kode_anggota=<?php echo nomer("A","kode_anggota","t_anggota	"); ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=650,height=550");
	}
</script>
