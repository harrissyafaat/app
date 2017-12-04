<?php 
	include "config/koneksi.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
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
<h3>Data Setting User</h3>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_anggota">Kode Anggota</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari;?>"><input type="submit" value="Cari">
</form>
<div class="tambah"><a href=?pilih=4.3&aksi=tambah><input type="submit" value="Tambah"></a></div>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Username</a></th>
             <th><a href="#">Nama Petugas</a></th>
			 <th><a href="#">Tanggal Entri</a></th>
             <th><a href="#">Level</a></th>
             <th colspan="3"><a>Aksi</a></th>
       	</tr>
		
    </thead>
<?php

		// PAGING
		$batas=5;
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
			$posisi=0;
			$halaman=1;
		}else{
			$posisi=($halaman-1)*$batas;
		}
		if($kategori!=""){
			$query = mysql_query("SELECT U.*, P.nama_petugas, R.rule 
								FROM t_user U, t_petugas P, user_rule R 
								WHERE $kategori LIKE '%$cari%'
								AND U.kode_petugas = P.kode_petugas
								AND U.c_rule = R.c_rule 
								ORDER BY kode_user ASC 
								LIMIT $posisi, $batas");
		}else{
			$query=mysql_query("SELECT U.*, P.nama_petugas, R.rule 
								FROM t_user U, t_petugas P, user_rule R 
								WHERE U.kode_petugas = P.kode_petugas
								AND U.c_rule = R.c_rule 
								ORDER BY kode_user ASC 
								LIMIT $posisi, $batas");
		}
		$no=$posisi+1;
		
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['username'];?></td>
			<td><?php echo $data['nama_petugas'];?></td>
			<td><?php echo Tgl($data['tgl_entri']);?></td>
            <td><?php echo $data['rule'];?></td>
            <td align="center">
<a href=index.php?pilih=4.3&aksi=ubah&kode_user=<?php echo $data['kode_user'];?>><img src="img/user_edit.png" title="Edit user" width="16" height="16" /></a>
<a href=index.php?pilih=4.3&aksi=hapus&kode_user=<?php echo $data['kode_user'];?>><img src="img/user_delete.png" title="Delete user" width="16" height="16" /></a>
			</td>
        </tr> 
	</tbody>   
<?php
	} //tutup while
?>
	<tr class="paging">
            <td colspan="12">
         <?php
            // PAGING
			if($kategori!=""){
				$query2 = mysql_query("SELECT U.*, P.nama_petugas, R.rule 
									FROM t_user U, t_petugas P, user_rule R 
									WHERE $kategori LIKE '%$cari%'
									AND U.kode_petugas = P.kode_petugas
									AND U.c_rule = R.c_rule 
									ORDER BY kode_user ASC ");
			}else{
				$query2 = mysql_query("SELECT U.*, P.nama_petugas, R.rule 
									FROM t_user U, t_petugas P, user_rule R 
									WHERE U.kode_petugas = P.kode_petugas
									AND U.c_rule = R.c_rule 
									ORDER BY kode_user ASC ");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=4.3&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=4.3&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=4.3&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else{
					echo '<span class="prn">Next &gt;</span>&nbsp;';
				}
				
				if ($jmldata != 0){
					echo '<p id="total_count">(total '.$jmldata.' records)</p></div>';
				}
	
            ?>
            </td>
        </tr>
	</table>
	</div>
    
<?php
	}elseif($aksi=='tambah'){
?>

<div id="box">
<h3 id="adduser">Tambah Data</h3>
<form action="setting/proses_user.php?pros=tambah" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode">Kode :</label></dt>
        <dd><input type="text" name="kode_user" size="54" value="<?php echo nomer("U","kode_user","t_user");?>" readonly title="Kode harus diisi"/></dd>
    </dl>
	<dl>
		<dt><label for="username">Username :</label></dt>
        <dd><input type="text" name="username" size="54" class="required" title="Nama harus diisi"></dd>
    </dl>
    <dl>
        <dt><label for="password">Password :</label></dt>
        <dd><input type="password" name="password" size="54" class="required" title="Telepon harus diisi"/></dd>
    </dl>
	 <dl>
        <dt><label for="kode_petugas">Nama Petugas :</label></dt>
        <dd>
            <select name="kode_petugas" class="required">
                <option value="nama_petugas" selected="selected"> petugas </option>
                <?php
                $q=mysql_query("SELECT * FROM t_petugas");
                while($a=mysql_fetch_array($q)){
                ?>
                    <option value="<?php echo $a['kode_petugas'];?>"><?php echo $a['nama_petugas'];?></option>
                <?php
                }
                ?>
            </select>
		</dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly /></dd>
    </dl>
	<dl>
        <dt><label for="level">Rule :</label></dt>
        <dd>
            <select name="c_rule" class="required">
                <option value="rule" selected="selected"> rule </option>
                <?php
                $q=mysql_query("SELECT * FROM user_rule");
                while($a=mysql_fetch_array($q)){
                ?>
                    <option value="<?php echo $a['c_rule'];?>"><?php echo $a['rule'];?></option>
                <?php
                }
                ?>
            </select>
		</dd>
    </dl>
    <div align="center">
    	<input type="submit" name="tambah" id="button1" value="Tambah" />
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_user'];
		$q=mysql_query("SELECT * FROM t_user WHERE kode_user='$kode'");
		$data2=mysql_fetch_array($q);
?>

<div id="box">
<h3 id="adduser">Ubah Data petugas</h3>
<form action="setting/proses_user.php?pros=ubah" method="post" id="form">
<fieldset>
		<dl>
		<dt><label for="kode">Kode :</label></dt>
        <dd><input type="text" name="kode_user" size="54" value="<?php echo $data2['kode_user'];?>"/></dd>
    </dl>
	<dl>
		<dt><label for="username">Username :</label></dt>
        <dd><input type="text" name="username" size="54" class="required" value="<?php echo $data2['username'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="password">Password :</label></dt>
        <dd><input type="text" name="password" size="54" class="required" title="Telepon harus diisi" value="<?php echo $data2['password'];?>"/></dd>
    </dl>
	 <dl>
        <dt><label for="kode_petugas">Kode Petugas :</label></dt>
        <dd>
		<select name="kode_petugas">
			<?php
			$q=mysql_query("SELECT * FROM t_petugas");
			while($a=mysql_fetch_array($q)){
			?>
            <option value="<?php echo $a['kode_petugas'];?>" <?php if($data2['kode_petugas']==$a['kode_petugas']){?>selected="selected"<?php }?>>
<?php echo $a['nama_petugas'];?></option>
            <?php
            }
			?>
		</select>
		</dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
    </dl>
	<dl>
        <dt><label for="level">Rule :</label></dt>
        <dd>
		<select name="c_rule">
			<?php
			$q=mysql_query("SELECT * FROM user_rule");
			while($a=mysql_fetch_array($q)){
			?>
            <option value="<?php echo $a['c_rule'];?>" <?php if($data2['c_rule']==$a['c_rule']){?>selected="selected"<?php }?>>
<?php echo $a['rule'];?></option>
            <?php
            }
			?>
		</select>
		</dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="ubah" id="button1" value="Ubah" />
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_user'];
		$q=mysql_query("SELECT U.*, P.nama_petugas, R.rule 
						FROM t_user U, t_petugas P, user_rule R 
						WHERE U.kode_petugas = P.kode_petugas
						AND U.c_rule = R.c_rule 
						AND kode_user='$kode'");
		$data2=mysql_fetch_array($q);
?>

<div id="box">
<h3 id="adduser">Data petugas yang akan dihapus</h3>
<form action="setting/proses_user.php?pros=hapus" method="post" id="form">
<fieldset>
		<dl>
		<dt><label for="kode">Kode :</label></dt>
        <dd><input type="text" name="kode_user" size="54" value="<?php echo $data2['kode_user'];?>" readonly/></dd>
    </dl>
	<dl>
		<dt><label for="username">Username :</label></dt>
        <dd><input type="text" name="username" size="54" class="required" value="<?php echo $data2['username'];?>" readonly></dd>
    </dl>
    <dl>
        <dt><label for="password">Password :</label></dt>
        <dd><input type="text" name="password" size="54" class="required" value="<?php echo $data2['password'];?>" readonly/></dd>
    </dl>
	 <dl>
        <dt><label for="kode_petugas">Nama Petugas :</label></dt>
        <dd><input type="text" name="nama_petugas" size="54" class="required" value="<?php echo $data2['nama_petugas'];?>" readonly/></dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC"/></dd>
    </dl>
	<dl>
        <dt><label for="level">Rule :</label></dt>
       	<dd><input type="text" name="rule" size="54" class="required" value="<?php echo $data2['rule'];?>" readonly/></dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="hapus" id="button1" value="Hapus" />
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}
?>

