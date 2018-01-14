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
</head>

<?php
	if(empty($aksi)){
?>
<body>

	<div class="text-right">
	<a href="?pilih=4.3&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
        <th>Username</th>
        <th>Nama Petugas</th>
				<th>Tanggal Entri</th>
        <th>Level</th>
    		<th>Aksi</th>
    </tr>
  	</thead>
		<tbody>
<?php
			$query=mysqli_query($koneksi, "SELECT U.*, P.nama_petugas, R.rule
								FROM t_user U, t_petugas P, user_rule R
								WHERE U.kode_petugas = P.kode_petugas
								AND U.c_rule = R.c_rule
								ORDER BY kode_user ASC");
		$no=1;

	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
      <td><?php echo $data['username'];?></td>
			<td><?php echo $data['nama_petugas'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
      <td><?php echo $data['rule'];?></td>
      <td align="center">
<a class="btn btn-primary" href=index.php?pilih=4.3&aksi=ubah&kode_user=<?php echo $data['kode_user'];?>><i class="fa fa-edit"></i></a>
<a class="btn btn-danger" href=index.php?pilih=4.3&aksi=hapus&kode_user=<?php echo $data['kode_user'];?>><i class="fa fa-trash"></i></a>
			</td>
        </tr>
	</tbody>
<?php
	} //tutup while
?>
	</table>
	</div>
	</div>
	</div>

<?php
	}elseif($aksi=='tambah'){
?>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-plus"></i> Tambah Data Petugas</div>
				<div class="card-body">
<form action="setting/proses_user.php?pros=tambah" method="post" id="form">
<fieldset>
	<div class="form-group">
		<label for="kode">Kode :</label>
        <input class="form-control" type="text" name="kode_user" size="54" value="<?php echo nomer("U","kode_user","t_user");?>" readonly title="Kode harus diisi"/>
    </div>
	<div class="form-group">
		<label for="username">Username :</label>
        <input class="form-control" type="text" name="username" size="54" class="required" title="Nama harus diisi">
    </div>
    <div class="form-group">
        <label for="password">Password :</label>
        <input class="form-control" type="password" name="password" size="54" class="required" title="Telepon harus diisi"/>
    </div>
	 <div class="form-group">
        <label for="kode_petugas">Nama Petugas :</label>
            <select class="form-control" name="kode_petugas" class="required">
                <option value="nama_petugas" selected="selected"> petugas </option>
                <?php
                $q=mysqli_query($koneksi, "SELECT * FROM t_petugas");
                while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
                ?>
                    <option value="<?php echo $a['kode_petugas'];?>"><?php echo $a['nama_petugas'];?></option>
                <?php
                }
                ?>
            </select>

    </div>
	<div class="form-group">
        <label for="tgl_entri">Tanggal Entri :</label>
        <input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly />
    </div>
	<div class="form-group">
        <label for="level">Rule :</label>
            <select class="form-control" name="c_rule" class="required">
                <option value="rule" selected="selected"> rule </option>
                <?php
                $q=mysqli_query("SELECT * FROM user_rule");
                while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
                ?>
                    <option value="<?php echo $a['c_rule'];?>"><?php echo $a['rule'];?></option>
                <?php
                }
                ?>
            </select>

    </div>
    <div class="form-group">
    	<input class="btn btn-primary" type="submit" name="tambah" id="button1" value="Tambah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_user'];
		$q=mysqli_query($koneksi, "SELECT * FROM t_user WHERE kode_user='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-edit"></i> Ubah Data Petugas</div>
				<div class="card-body">
<form action="setting/proses_user.php?pros=ubah" method="post" id="form">
<fieldset>
		<div class="form-group">
		<label for="kode">Kode :</label>
        <input class="form-control" type="text" name="kode_user" size="54" value="<?php echo $data2['kode_user'];?>"/>
    </div>
	<div class="form-group">
		<label for="username">Username :</label>
        <input class="form-control" type="text" name="username" size="54" class="required" value="<?php echo $data2['username'];?>">
    </div>
    <div class="form-group">
        <label for="password">Password :</label>
        <input class="form-control" type="text" name="password" size="54" class="required" title="Telepon harus diisi" value="<?php echo $data2['password'];?>"/>
    </div>
	 <div class="form-group">
        <label for="kode_petugas">Kode Petugas :</label>

		<select class="form-control" name="kode_petugas">
			<?php
			$q=mysqli_query($koneksi, "SELECT * FROM t_petugas");
			while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
			?>
            <option value="<?php echo $a['kode_petugas'];?>" <?php if($data2['kode_petugas']==$a['kode_petugas']){?>selected="selected"<?php }?>>
<?php echo $a['nama_petugas'];?></option>
            <?php
            }
			?>
		</select>

    </div>
	<div class="form-group">
        <label for="tgl_entri">Tanggal Entri :</label>
        <input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/>
    </div>
	<div class="form-group">
        <label for="level">Rule :</label>

		<select class="form-control" name="c_rule">
			<?php
			$q=mysqli_query($koneksi, "SELECT * FROM user_rule");
			while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
			?>
            <option value="<?php echo $a['c_rule'];?>" <?php if($data2['c_rule']==$a['c_rule']){?>selected="selected"<?php }?>>
<?php echo $a['rule'];?></option>
            <?php
            }
			?>
		</select>

    </div><br>
    <div class="form-group">
    	<input class="btn btn-primary" type="submit" name="ubah" id="button1" value="Ubah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_user'];
		$q=mysqli_query($koneksi, "SELECT U.*, P.nama_petugas, R.rule
						FROM t_user U, t_petugas P, user_rule R
						WHERE U.kode_petugas = P.kode_petugas
						AND U.c_rule = R.c_rule
						AND kode_user='$kode'");
		$data2=mysqli_fetch_array($q, MYSQLI_ASSOC);
?>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-trash"></i> Hapus Data Petugas</div>
				<div class="card-body">
<form action="setting/proses_user.php?pros=hapus" method="post" id="form">
<fieldset>
		<div class="form-group">
		<label for="kode">Kode :</label>
        <input class="form-control" type="text" name="kode_user" size="54" value="<?php echo $data2['kode_user'];?>" readonly/>
    </div>
	<div class="form-group">
		<label for="username">Username :</label>
        <input class="form-control" type="text" name="username" size="54" class="required" value="<?php echo $data2['username'];?>" readonly>
    </div>
    <div class="form-group">
        <label for="password">Password :</label>
        <input class="form-control" type="text" name="password" size="54" class="required" value="<?php echo $data2['password'];?>" readonly/>
    </div>
	 <div class="form-group">
        <label for="kode_petugas">Nama Petugas :</label>
        <input class="form-control" type="text" name="nama_petugas" size="54" class="required" value="<?php echo $data2['nama_petugas'];?>" readonly/>
    </div>
	<div class="form-group">
        <label for="tgl_entri">Tanggal Entri :</label>
        <input class="form-control" type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC"/>
    </div>
	<div class="form-group">
        <label for="level">Rule :</label>
       	<input class="form-control" type="text" name="rule" size="54" class="required" value="<?php echo $data2['rule'];?>" readonly/>
    </div><br>
    <div class="form-group">
    	<input class="btn btn-primary" type="submit" name="hapus" id="button1" value="Hapus" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}
?>
