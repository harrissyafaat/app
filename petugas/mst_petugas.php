<?php
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<?php
	// **STYLE FORM
?>
<script language="javascript" type="text/javascript" src="js/validasi.js"></script>

</head>

<?php
	if(empty($aksi)){
?>
<body>

<div class="text-right">
<a href="?pilih=1.1&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
			 <th>Kode petugas</th>
			 <th>Nama petugas</th>
			 <th>Alamat</th>
			 <th>Telepon</th>
			 <th>Aksi</th>
			</tr>
    </thead>
		<tfoot>
			<tr>
       <th>No</th>
       <th>Kode petugas</th>
       <th>Nama petugas</th>
       <th>Alamat</th>
       <th>Telepon</th>
       <th>Aksi</th>
      </tr>
    </tfoot>
		<tbody>
<?php

		$query=mysqli_query($koneksi, "SELECT * FROM t_petugas
							ORDER BY kode_petugas ASC");

	$no=1;
	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>

    	<tr>
			<td align="center"	><?php echo $no++;?></td>
            <td><?php echo $data['kode_petugas'];?></td>
            <td><?php echo $data['nama_petugas'];?></td>
            <td><?php echo $data['alamat_petugas'];?></td>
            <td><?php echo $data['telp'];?></td>
            <td>
	<a class="btn btn-primary" href=index.php?pilih=1.1&aksi=ubah&kode_petugas=<?php echo $data['kode_petugas'];?>><i class="fa fa-edit"></i></a>
	&nbsp;
    <a class="btn btn-danger" href=index.php?pilih=1.1&aksi=hapus&kode_petugas=<?php echo $data['kode_petugas'];?>><i class="fa fa-trash"></i></a>
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
?>
<div class="row">
        <div class="col-12">
<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus"></i> Tambah Data Petugas</div>
        <div class="card-body">
<form action="petugas/proses_petugas.php?pros=tambah" method="post" onSubmit="return validasiPetugas();">
<fieldset>
<div class="form-group">
	<label for="kode_petugas">Kode Petugas :</label>
	<input class="form-control" id="kode_petugas" type="text" name="kode_petugas" size="54" value="<?php echo nomer("P","kode_petugas","t_petugas");?>" readonly title="Kode harus diisi" required/>
</div>
<div class="form-group">
	<label for="nama_petugas">Nama Petugas :</label>
	<input class="form-control" type="text" name="nama_petugas" id="nama_petugas" size="54" class="required" title="Nama harus diisi" required>
</div>
<div class="form-group">
	<label for="alamat_petugas">Alamat Petugas :</label>
	<textarea class="form-control" name="alamat_petugas" id="alamat_petugas" rows="5" cols="41" class="required" title="Alamat harus diisi" required></textarea>
</div>
<div class="form-group">
	<label for="telp">No Telp :</label>
	<input class="form-control" type="text" name="telp" id="telp" size="54" class="required" title="Telepon harus diisi" required/>
</div>
<div class="form-group">
	<label for="jenis_kelamin">Jenis Kelamin :</label>
	<input type="radio" name="jenis_kelamin" value="Laki-laki" class="required" title="Jenis Kelamin harus diisi"/> Laki-laki
	<input type="radio" name="jenis_kelamin" value="Perempuan" class="required" title="Jenis Kelamin harus diisi"/> 	Perempuan
</div>
<div class="form-group">
	<label for="user_entri">User Entri :</label>
	<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC"/>
</div>
<div class="form-group">
	<label for="tgl_entri">Tanggal Entri :</label>
	<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC"/>
</div>
<div class="form-group text-center">
	<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Tambah" />
	<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
</div>
</fieldset>
</form>
</div>
</div>
</div>
</div>


<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_petugas'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_petugas WHERE kode_petugas='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div class="row">
        <div class="col-12">
<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus"></i> Ubah Data Petugas</div>
        <div class="card-body">
<form action="petugas/proses_petugas.php?pros=ubah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="nama_petugas">Nama Petugas:</label>
		<input class="form-control" type="text" name="nama_petugas" size="54" value="<?php echo $data2['nama_petugas'];?>"/>
		<input type="hidden" value="<?php echo "$kode"; ?>" name="kode_petugas">
	</div>
	<div class="form-group">
		<label for="alamat_petugas">Alamat Petugas :</label>
		<textarea  class="form-control" name="alamat_petugas" id="alamat_petugas" rows="5" cols="41"><?php echo $data2['alamat_petugas'];?></textarea>
	</div>
	<div class="form-group">
		<label for="telp">Telepon :</label>
		<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>"/>
	</div>
	<div class="form-group">
		<label for="jenis_kelamin">Jenis Kelamin :</label>
		<?php
			if ($data2['jenis_kelamin'] == "Laki-laki"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
			}else if ($data2['jenis_kelamin'] == "Perempuan"){
				echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked> Perempuan";
			}
		?>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo $data2['tgl_entri'];?>" readonly/>
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_petugas'];
		$qhapus=mysqli_query($koneksi, "SELECT * FROM t_petugas WHERE kode_petugas='$kode'");
		$data3=mysqli_fetch_array($qhapus, MYSQLI_ASSOC);
?>


<div class="row">
        <div class="col-12">
<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus"></i> Hapus Data Petugas</div>
        <div class="card-body">
<form action="petugas/proses_petugas.php?pros=hapus" method="post" id="form">
	<fieldset>
		<div class="form-group">
			<label for="nama_petugas">Nama Petugas:</label>
			<input class="form-control" type="text" name="nama_petugas" size="54" value="<?php echo $data3['nama_petugas'];?>" readonly/>
			<input type="hidden" value="<?php echo "$kode"; ?>" name="kode_petugas">
		</div>
		<div class="form-group">
			<label for="alamat_petugas">Alamat Petugas :</label>
			<textarea  class="form-control" name="alamat_petugas" id="alamat_petugas" rows="5" cols="41" readonly><?php echo $data3['alamat_petugas'];?></textarea>
		</div>
		<div class="form-group">
			<label for="telp">Telepon :</label>
			<input class="form-control" type="text" name="telp" size="54" value="<?php echo $data3['telp'];?>" readonly/>
		</div>
		<div class="form-group">
			<label for="jenis_kelamin">Jenis Kelamin :</label>
			<?php
				if ($data3['jenis_kelamin'] == "Laki-laki"){
					echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' readonly>Perempuan";
				}else if ($data3['jenis_kelamin'] == "Perempuan"){
					echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked readonly> Perempuan";
				}
			?>
		</div>
		<div class="form-group">
			<label for="user_entri">User Entri :</label>
			<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
		</div>
		<div class="form-group">
			<label for="tgl_entri">Tanggal Entri :</label>
			<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo $data3['tgl_entri'];?>" readonly/>
		</div>
		<div class="form-group text-center">
			<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Hapus" />
			<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
		</div>
	</fieldset>
</form>
</div>
</div>
</div>

<?php
	}
?>
