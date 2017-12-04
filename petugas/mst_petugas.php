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
<script language="javascript" type="text/javascript" src="js/validasi.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

</head>

<?php
	if(empty($aksi)){
?>
<body>  
         	            
<div id="box">
<h3>Data petugas</h3>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_petugas">Kode Petugas</option>
        <option value="nama_petugas">Nama Petugas</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari ;?>">
    <input type="submit" value="Cari">
</form>
<div class="tambah"><a href=?pilih=1.1&aksi=tambah><input type="submit" value="Tambah"></a></div>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Kode petugas</a></th>
             <th><a href="#">Nama petugas</a></th>
             <th><a href="#">Alamat</a></th>
             <th><a href="#">Telepon</a></th>
             <th colspan="3"><a>Aksi</a></th>
       	</tr>
		
    </thead>
<?php

		// PAGING
		$batas=10;
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
			$posisi=0;
			$halaman=1;
		}else{
			$posisi=($halaman-1)*$batas;
		}
		if($kategori!=""){
			$query = mysql_query("SELECT * 
								FROM t_petugas
								WHERE $kategori LIKE '%$cari%'
								ORDER BY kode_petugas ASC 
								LIMIT $posisi, $batas");
		}else{
		$query=mysql_query("SELECT * FROM t_petugas 
							ORDER BY kode_petugas ASC 
							LIMIT $posisi, $batas");
		}
	$no=$posisi+1;
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td align="center"	><?php echo $no++;?></td>
            <td><?php echo $data['kode_petugas'];?></td>
            <td><?php echo $data['nama_petugas'];?></td>
            <td><?php echo $data['alamat_petugas'];?></td>
            <td><?php echo $data['telp'];?></td>
            <td align="center">
	<a href=index.php?pilih=1.1&aksi=ubah&kode_petugas=<?php echo $data['kode_petugas'];?>><img src="img/user_edit.png" title="Edit user" width="16" height="16" /></a>
    <a href=index.php?pilih=1.1&aksi=hapus&kode_petugas=<?php echo $data['kode_petugas'];?>><img src="img/user_delete.png" title="Delete user" width="16" height="16" /></a>
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
				$query2 = mysql_query("SELECT * 
									FROM t_petugas
									WHERE $kategori LIKE '%$cari%'
									ORDER BY kode_petugas ASC");
			}else{
				$query2 = mysql_query("SELECT * 
									FROM t_petugas
									ORDER BY kode_petugas ASC");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=1.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;';
                    }else{ 
                        echo '<a href=?pilih=1.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=1.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else{
					echo '<span class="prn">Next &gt;</span>&nbsp;';
				}
				
				if ($jmldata != 0){
					echo '<p id="total_count">(total '.$jmldata.' data)</p></div>';
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
<h3 id="adduser">Tambah Data petugas</h3>
<form action="petugas/proses_petugas.php?pros=tambah" method="post" id="form" onSubmit="return validasiPetugas();">
<fieldset>
	<dl>
		<dt><label for="kode_petugas">Kode Petugas :</label></dt>
       <dd><input type="text" name="kode_petugas" size="54" value="<?php echo nomer("P","kode_petugas","t_petugas");?>" readonly title="Kode harus diisi" required/></dd>
    </dl>
	<dl>
		<dt><label for="nama_petugas">Nama Petugas :</label></dt>
        <dd><input type="text" name="nama_petugas" id="nama_petugas" size="54" class="required" title="Nama harus diisi" required></dd>
    </dl>
    <dl>
        <dt><label for="alamat_petugas">Alamat Petugas :</label></dt>
        <dd><textarea name="alamat_petugas" id="alamat_petugas" rows="5" cols="41" class="required" title="Alamat harus diisi" required></textarea></dd>
    </dl>
	 <dl>
        <dt><label for="telp">No Telp :</label></dt>
        <dd><input type="text" name="telp" id="telp" size="54" class="required" title="Telepon harus diisi" required/></dd>
    </dl>
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd>
			<input type="radio" name="jenis_kelamin" value="Laki-laki" class="required" title="Jenis Kelamin harus diisi"/> Laki-laki
			<input type="radio" name="jenis_kelamin" value="Perempuan" class="required" title="Jenis Kelamin harus diisi"/> 	Perempuan		
		</dd>
    </dl>
	<dl>
        <dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC"/></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC"/></dd>
    </dl><br>
    <div align="center">
    	<input type="submit" name="ubah" id="button1" value="Tambah" />
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_petugas'];
		$qubah=mysql_query("SELECT * FROM t_petugas WHERE kode_petugas='$kode'");
		$data2=mysql_fetch_array($qubah);
?>

<div id="box">
<h3 id="adduser">Ubah Data petugas</h3>
<form action="petugas/proses_petugas.php?pros=ubah" method="post" id="form">
<fieldset>
    <dl>
        <dt><label for="nama_petugas">Nama Petugas:</label></dt>
        <dd><input type="text" name="nama_petugas" size="54" value="<?php echo $data2['nama_petugas'];?>"/></dd>
    </dl>
    <input type="hidden" value="<?php echo "$kode"; ?>" name="kode_petugas">
	<dl>
        <dt><label for="alamat_petugas">Alamat Petugas :</label></dt>
        <dd><textarea name="alamat_petugas" id="alamat_petugas" rows="5" cols="41"><?php echo $data2['alamat_petugas'];?></textarea></dd>
    </dl>
	<dl>
        <dt><label for="telp">Telepon :</label></dt>
        <dd><input type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>"/></dd>
    </dl> 
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd>
<?php	
	if ($data2['jenis_kelamin'] == "Laki-laki"){
		echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
	}else if ($data2['jenis_kelamin'] == "Perempuan"){
		echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked> Perempuan";
	}
?>
		</dd>
    </dl>  	
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo $data2['tgl_entri'];?>" readonly/></dd>
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
		$kode=$_GET['kode_petugas'];
		$qhapus=mysql_query("SELECT * FROM t_petugas WHERE kode_petugas='$kode'");
		$data3=mysql_fetch_array($qhapus);
?>

<div id="box">
<h3 id="adduser">Hapus Data petugas</h3>
<form action="petugas/proses_petugas.php?pros=hapus" method="post" id="form">
<fieldset>
	<dl>
		<dt><label for="kode_petugas">Kode Petugas :</label></dt>
        <dd><input type="text" name="kode_petugas" size="54" value="<?php echo $data3['kode_petugas'];?>" readonly=""/></dd>
    </dl>
        <input type="hidden" value="<?php echo "$kode"; ?>" name="kode_petugas">
        <dl>
        <dt><label for="nama_petugas">Nama Petugas:</label></dt>
        <dd><input type="text" name="nama_petugas" size="54" value="<?php echo $data3['nama_petugas'];?>" readonly=""/></dd>
    </dl>
	<dl>
        <dt><label for="alamat_petugas">Alamat Petugas :</label></dt>
        <dd><textarea name="alamat_petugas" id="alamat_petugas" rows="5" cols="41" readonly><?php echo $data3['alamat_petugas'];?></textarea></dd>
    </dl>
	<dl>
        <dt><label for="telp">Telepon :</label></dt>
        <dd><input type="text" name="telp" size="54" value="<?php echo $data3['telp'];?>" readonly=""/></dd>
    </dl> 
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd><input type="text" name="telp" size="54" value="<?php echo $data3['jenis_kelamin'];?>" readonly=""/></dd>
    </dl>  	
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php echo $data3['u_entry'];?>" readonly=""></dd>
    </dl>
	 <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo $data3['tgl_entri'];?>" readonly=""/></dd>
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

