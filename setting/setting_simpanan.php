<?php
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET[aksi];
?>

<?php
	// **STYLE FORM
?>
</head>

<?php
	if(empty($aksi)){
?>
<body>

	<div class="text-right">
	<a href="?pilih=4.1&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
	</div>
	<br>
	<div class="card mb-3">
	        <div class="card-header">
	          <i class="fa fa-table"></i> Setting Data Simpanan</div>
	        <div class="card-body">
	<div class="table-responsive">
	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
	    <th>No</th>
	    <th>Jenis Simpanan</th>
	    <th>Besar Simpanan</th>
      <th>User Entri</th>
			<th>Tanggal Entri</th>
      <th>Aksi</th>
    </tr>
    </thead>
		<tbody>
<?php
$no=1;
$sql=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan");
while($data=mysqli_fetch_array($sql, MYSQLI_ASSOC)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_simpanan'];?></td>
			<td align="right"><?php echo Rp($data['besar_simpanan']);?></td>
			<td><?php echo $data['u_entry'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
			<td align="center">
<a class="btn btn-primary" href=index.php?pilih=4.1&aksi=ubah&kode_jenis_simpan=<?php echo $data['kode_jenis_simpan'];?>><i class="fa fa-edit"></i></a>
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

<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-table"></i> Tambah Setting Simpanan</div>
	<div class="card-body">
<form action="setting/proses_setting_simpan.php?pros=tambah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode_jenis_simpan">Kode Simpanan :</label>
		<input class="form-control" type="text" name="kode_jenis_simpan" size="54" value="<?php echo nomer("S","kode_jenis_simpan","t_jenis_simpan");?>" readonly/>
	</div>
	<div class="form-group">
		<label for="nama_simpanan">Jenis Simpanan :</label>
		<input class="form-control" type="text" name="nama_simpanan" size="54"/>
	</div>
	<div class="form-group">
		<label for="besar_simpanan">Besar Simpanan :</label>
		<input class="form-control" type="text" name="besar_simpanan" size="54"/>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly>
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="tambah" id="button1" value="Tambah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_jenis_simpan'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan WHERE kode_jenis_simpan='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-table"></i> Ubah Setting Simpanan</div>
	<div class="card-body">
<form action="setting/proses_setting_simpan.php?pros=ubah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode_jenis_simpan">Kode Simpanan :</label>
		<input class="form-control" type="text" name="kode_jenis_simpan" size="54" value="<?php echo $data2['kode_jenis_simpan'];?>" readonly=""/>
	</div>
	<div class="form-group">
		<label for="nama_simpanan">Jenis Simpanan :</label>
		<input class="form-control" type="text" name="nama_simpanan" size="54" value="<?php echo $data2['nama_simpanan'];?>" readonly=""/>
	</div>
	<div class="form-group">
		<label for="besar_simpanan">Besar Simpanan :</label>
		<input class="form-control" type="text" name="besar_simpanan" size="54" value="<?php echo $data2['besar_simpanan'];?>"/>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly="">
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly=""/>
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_jenis_simpan'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan WHERE kode_jenis_simpan='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div id="box">
<h3 id="adduser">Hapus Data Simpanan</h3>
<form action="setting/proses_setting_simpan.php?pros=hapus" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_simpan">Kode Simpanan :</label></dt>
        <dd><input type="text" name="kode_jenis_simpan" size="54" value="<?php echo $data2['kode_jenis_simpan'];?>" readonly=""/></dd>
    </dl>
    <dl>
        <dt><label for="nama_simpanan">Jenis Simpanan :</label></dt>
        <dd><input type="text" name="nama_simpanan" size="54" value="<?php echo $data2['nama_simpanan'];?>" readonly/></dd>
    </dl>
	<dl>
        <dt><label for="besar_simpanan">Besar Simpanan :</label></dt>
        <dd><input type="text" name="besar_simpanan" size="54" value="<?php echo $data2['besar_simpanan'];?>" readonly/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php echo $data2['u_entry'];?>" readonly></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo $data2['tgl_entri'];?>" readonly/></dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="hapus" id="button1" value="Hapus" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}
?>
</body>
