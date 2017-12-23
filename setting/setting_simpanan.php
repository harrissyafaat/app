<?php 
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET[aksi];
?>

<?php
	// **STYLE FORM
?>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />
</head>

<?php
	if(empty($aksi)){
?>
<body>  
         	            
<div id="box">
<h3>Setting Data Simpanan</h3><br>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Jenis Simpanan</a></th>
             <th><a href="#">Besar Simpanan</a></th>
             <th><a href="#">User Entri</a></th>
			 <th><a href="#">Tanggal Entri</a></th>
             <th><a>Aksi</a></th>
       	</tr>
    </thead>
<?php
$no=1;
$sql=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan");
while($data=mysqli_fetch_array($sql, MYSQLI_ASSOC)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_simpanan'];?></td>
			<td align="right"><?php echo Rp($data['besar_simpanan']);?></td>
			<td><?php echo $data['u_entry'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
			<td align="center">
<a href=index.php?pilih=4.1&aksi=ubah&kode_jenis_simpan=<?php echo $data['kode_jenis_simpan'];?>><img src="img/user_edit.png" alt="" title="Ubah Data" border="0" /></a>
			</td>
		</tr>
	</tbody>   
<?php
	} //tutup while
?>
	</table>
	</div>
    
<?php
	}elseif($aksi=='tambah'){
?>

<div id="box">
<h3 id="adduser">Tambah Data Simpanan</h3>
<form action="setting/proses_setting_simpan.php?pros=tambah" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_simpan">Kode Simpanan :</label></dt>
        <dd><input type="text" name="kode_jenis_simpan" size="54" value="<?php echo nomer("S","kode_jenis_simpan","t_jenis_simpan");?>" readonly/></dd>
    </dl>
    <dl>
        <dt><label for="nama_simpanan">Jenis Simpanan :</label></dt>
        <dd><input type="text" name="nama_simpanan" size="54"/></dd>
    </dl>
	<dl>
        <dt><label for="besar_simpanan">Besar Simpanan :</label></dt>
        <dd><input type="text" name="besar_simpanan" size="54"/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="tambah" id="button1" value="Tambah" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
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

<div id="box">
<h3 id="adduser">Ubah Data Simpanan</h3>
<form action="setting/proses_setting_simpan.php?pros=ubah" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_simpan">Kode Simpanan :</label></dt>
        <dd><input type="text" name="kode_jenis_simpan" size="54" value="<?php echo $data2['kode_jenis_simpan'];?>" readonly=""/></dd>
    </dl>
    <dl>
        <dt><label for="nama_simpanan">Jenis Simpanan :</label></dt>
        <dd><input type="text" name="nama_simpanan" size="54" value="<?php echo $data2['nama_simpanan'];?>" readonly=""/></dd>
    </dl>
	<dl>
        <dt><label for="besar_simpanan">Besar Simpanan :</label></dt>
        <dd><input type="text" name="besar_simpanan" size="54" value="<?php echo $data2['besar_simpanan'];?>"/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly=""></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly=""/></dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="ubah" id="button1" value="Ubah" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
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

