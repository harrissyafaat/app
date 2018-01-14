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
	<a href="?pilih=4.2&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
      <th>Jenis Pinjaman</th>
      <th>Lama Angsur</th>
			<th>Maksimal Pinjam</th>
      <th>User Entri</th>
			<th>Tanggal Entri</th>
      <th>Aksi</th>
    </tr>
    </thead>
		<tbody>
<?php
$no=1;
$sql=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam");
while($data=mysqli_fetch_array($sql, MYSQLI_ASSOC)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_pinjaman'];?></td>
			<td><?php echo $data['lama_angsuran'];?></td>
			<td><?php echo Rp($data['maks_pinjam']);?></td>
			<td><?php echo $data['u_entry'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
			<td align="center">
<a class="btn btn-primary" href=index.php?pilih=4.2&aksi=ubah&kode_jenis_pinjam=<?php echo $data['kode_jenis_pinjam'];?>><i class="fa fa-edit"></i></a>
<a class="btn btn-danger" href=index.php?pilih=4.2&aksi=hapus&kode_jenis_pinjam=<?php echo $data['kode_jenis_pinjam'];?>><i class="fa fa-trash"></i></a>
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
					<i class="fa fa-table"></i> Tambah Data Pinjaman</div>
				<div class="card-body">
<form action="setting/proses_setting_pinjam.php?pros=tambah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode_jenis_pinjam">Kode Pinjaman :</label>
		<input class="form-control" type="text" name="kode_jenis_pinjam" size="54" value="<?php echo nomer("P","kode_jenis_pinjam","t_jenis_pinjam");?>" readonly/>
	</div>
	<div class="form-group">
		<label for="nama_pinjaman">Jenis Pinjaman :</label>
		<input class="form-control" type="text" name="nama_pinjaman" size="54"/>
	</div>
	<div class="form-group">
		<label for="lama_angsuran">Lama Angsur :</label>
		<input class="form-control" type="text" name="lama_angsuran" size="54"/>
	</div>
	<div class="form-group">
		<label for="maks_pinjam">Maksimal Pinjam :</label>
		<input class="form-control" type="text" name="maks_pinjam" size="54"/>
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
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_jenis_pinjam'];
		$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i> Ubah Data Pinjaman</div>
				<div class="card-body">
<form action="setting/proses_setting_pinjam.php?pros=ubah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode_jenis_pinjam">Kode Pinjaman :</label>
		<input class="form-control" type="text" name="kode_jenis_pinjam" size="54" value="<?php echo $data2['kode_jenis_pinjam'];?>" readonly=""/>
	</div>
	<div class="form-group">
		<label for="nama_pinjaman">Jenis Pinjaman :</label>
		<input class="form-control" type="text" name="nama_pinjaman" size="54" value="<?php echo $data2['nama_pinjaman'];?>"/>
	</div>
	<div class="form-group">
		<label for="lama_angsuran">Lama Angsur :</label>
		<input class="form-control" type="text" name="lama_angsuran" size="54" value="<?php echo $data2['lama_angsuran'];?>"/>
	</div>
	<div class="form-group">
		<label for="maks_pinjam">Maksimal Pinjam :</label>
		<input class="form-control" type="text" name="maks_pinjam" size="54" value="<?php echo $data2['maks_pinjam'];?>"/>
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
		<input class="btn btn=primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_jenis_pinjam'];
		$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-trash"></i> Hapus Data Pinjaman</div>
				<div class="card-body">
<form action="setting/proses_setting_pinjam.php?pros=hapus" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode_jenis_pinjam">Kode Pinjaman :</label>
        <input class="form-control" type="text" name="kode_jenis_pinjam" size="54" value="<?php echo $data2['kode_jenis_pinjam'];?>" readonly=""/>
    </div>
    <div class="form-group">
        <label for="nama_pinjaman">Jenis Pinjaman :</label>
        <input class="form-control" type="text" name="nama_pinjaman" size="54" value="<?php echo $data2['nama_pinjaman'];?>" readonly/>
    </div>
	<div class="form-group">
        <label for="lama_angsuran">Lama Angsur :</label>
        <input class="form-control" type="text" name="lama_angsuran" size="54" value="<?php echo $data2['lama_angsuran'];?>"/>
    </div>
	<div class="form-group">
        <label for="maks_pinjam">Maksimal Pinjam :</label>
        <input class="form-control" type="text" name="maks_pinjam" size="54" value="<?php echo $data2['maks_pinjam'];?>" readonly/>
    </div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
        <input class="form-control" type="text" name="u_entry" size="54" value="<?php echo $data2['u_entry'];?>" readonly>
    </div>
	 <div class="form-group">
        <label for="tgl_entri">Tanggal Entri :</label>
        <input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
    </div>
		<div class="form-group text-center">
			<input class="btn btn-primary" type="submit" name="hapus" id="button1" value="Hapus" />
	 <input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
     </div>
</fieldset>
</form>
</div>
</div>

<?php
	}
?>
</body>
