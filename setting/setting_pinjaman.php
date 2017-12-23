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
<h3>Setting Data Pinjaman</h3><br>
<div class="tambah"><a href=?pilih=4.2&aksi=tambah><input type="submit" value="Tambah"></a></div>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Jenis Pinjaman</a></th>
             <th><a href="#">Lama Angsur</a></th>
			 <th><a href="#">Maksimal Pinjam</a></th>
             <th><a href="#">User Entri</a></th>
			 <th><a href="#">Tanggal Entri</a></th>
             <th colspan="3"><a>Aksi</a></th>
       	</tr>
    </thead>
<?php
$no=1;
$sql=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam");
while($data=mysqli_fetch_array($sql, MYSQLI_ASSOC)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_pinjaman'];?></td>
			<td><?php echo $data['lama_angsuran'];?></td>
			<td><?php echo Rp($data['maks_pinjam']);?></td>
			<td><?php echo $data['u_entry'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
			<td align="center">
<a href=index.php?pilih=4.2&aksi=ubah&kode_jenis_pinjam=<?php echo $data['kode_jenis_pinjam'];?>><img src="img/user_edit.png" alt="" title="Ubah Data" border="0" /></a>
<a href=index.php?pilih=4.2&aksi=hapus&kode_jenis_pinjam=<?php echo $data['kode_jenis_pinjam'];?>><img src="img/user_delete.png" alt="" title="Hapus Data" border="0" /></a>
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
<h3 id="adduser">Tambah Data Pinjaman</h3>
<form action="setting/proses_setting_pinjam.php?pros=tambah" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_pinjam">Kode Pinjaman :</label></dt>
        <dd><input type="text" name="kode_jenis_pinjam" size="54" value="<?php echo nomer("P","kode_jenis_pinjam","t_jenis_pinjam");?>" readonly/></dd>
    </dl>
    <dl>
        <dt><label for="nama_pinjaman">Jenis Pinjaman :</label></dt>
        <dd><input type="text" name="nama_pinjaman" size="54"/></dd>
    </dl>
	<dl>
        <dt><label for="lama_angsuran">Lama Angsur :</label></dt>
        <dd><input type="text" name="lama_angsuran" size="54"/></dd>
    </dl>
	<dl>
        <dt><label for="maks_pinjam">Maksimal Pinjam :</label></dt>
        <dd><input type="text" name="maks_pinjam" size="54"/></dd>
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
		$kode=$_GET['kode_jenis_pinjam'];
		$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div id="box">
<h3 id="adduser">Ubah Data Pinjaman</h3>
<form action="setting/proses_setting_pinjam.php?pros=ubah" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_pinjam">Kode Pinjaman :</label></dt>
        <dd><input type="text" name="kode_jenis_pinjam" size="54" value="<?php echo $data2['kode_jenis_pinjam'];?>" readonly=""/></dd>
    </dl>
    <dl>
        <dt><label for="nama_pinjaman">Jenis Pinjaman :</label></dt>
        <dd><input type="text" name="nama_pinjaman" size="54" value="<?php echo $data2['nama_pinjaman'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="lama_angsuran">Lama Angsur :</label></dt>
        <dd><input type="text" name="lama_angsuran" size="54" value="<?php echo $data2['lama_angsuran'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="maks_pinjam">Maksimal Pinjam :</label></dt>
        <dd><input type="text" name="maks_pinjam" size="54" value="<?php echo $data2['maks_pinjam'];?>"/></dd>
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
    	<input type="submit" name="ubah" id="button1" value="Ubah" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_jenis_pinjam'];
		$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam WHERE kode_jenis_pinjam='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div id="box">
<h3 id="adduser">Hapus Data Pinjaman</h3>
<form action="setting/proses_setting_pinjam.php?pros=hapus" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_jenis_pinjam">Kode Pinjaman :</label></dt>
        <dd><input type="text" name="kode_jenis_pinjam" size="54" value="<?php echo $data2['kode_jenis_pinjam'];?>" readonly=""/></dd>
    </dl>
    <dl>
        <dt><label for="nama_pinjaman">Jenis Pinjaman :</label></dt>
        <dd><input type="text" name="nama_pinjaman" size="54" value="<?php echo $data2['nama_pinjaman'];?>" readonly/></dd>
    </dl>
	<dl>
        <dt><label for="lama_angsuran">Lama Angsur :</label></dt>
        <dd><input type="text" name="lama_angsuran" size="54" value="<?php echo $data2['lama_angsuran'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="maks_pinjam">Maksimal Pinjam :</label></dt>
        <dd><input type="text" name="maks_pinjam" size="54" value="<?php echo $data2['maks_pinjam'];?>" readonly/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php echo $data2['u_entry'];?>" readonly></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
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

