<?php 
	include "config/koneksi.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<head>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
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
<link rel="stylesheet" type="text/css" href="css/theme1.css" />
</head>

<?php
	if(empty($aksi)){
?>
<body>  
         	            
<div id="box">
<h3>Data Anggota</h3>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_anggota">Kode Anggota</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari;?>"><input type="submit" value="Cari">
</form>             
<div class="tambah"><a href=?pilih=1.2&aksi=tambah><input type="submit" value="Tambah"></a></div>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Kode Anggota</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Pekerjaan</a></th>
             <th><a href="#">Tanggal Masuk</a></th>
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
								FROM t_anggota
								WHERE $kategori LIKE '%$cari%'
								ORDER BY kode_anggota ASC 
								LIMIT $posisi, $batas");
		}else{
			$query=mysql_query("SELECT * FROM t_anggota 
								ORDER BY kode_anggota ASC 
								LIMIT $posisi, $batas");
		}
		$no=$posisi+1;
		
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo Tgl($data['tgl_masuk']);?></td>
            <td align="center">
	<a href=index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user_edit.png" title="Edit user" width="16" height="16" /></a>
    <a href=index.php?pilih=1.2&aksi=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user_delete.png" title="Delete user" width="16" height="16" /></a>
	<a href=index.php?pilih=1.2&aksi=cetak&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/cetak.gif" title="Cetak Kartu Anggota" width="16" height="16" /></a>
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
									FROM t_anggota
									WHERE $kategori LIKE '%$cari%'
									ORDER BY kode_anggota ASC");
			}else{
				$query2 = mysql_query("SELECT * FROM t_anggota");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=1.2&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=1.2&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=1.2&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else {
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
		$query=mysql_query("SELECT * FROM t_jenis_simpan WHERE kode_jenis_simpan='S0001'");
		$data=mysql_fetch_array($query);
?>

<div id="box">
<h3 id="adduser">Tambah Data Anggota</h3>
<form action="anggota/proses_anggota.php?pros=tambah" method="post" id="form" enctype="multipart/form-data">
<h4 id="adduser">Data Pribadi</h4>
<fieldset>
	<dl>
		<dt><label for="kode_anggota">Kode Anggota :</label></dt>
         <dd><input type="text" name="kode_anggota" size="54" value="<?php echo nomer("A","kode_anggota","t_anggota	");?>" readonly title="Kode harus diisi"/></dd>
    </dl>
    <?php
    	$kode = nomer("A","kode_anggota","t_anggota	");
    ?>
	<dl>
		<dt><label for="tgl_masuk">Tanggal Masuk :</label></dt>
        <dd><input type="text" name="tgl_masuk" size="54" id="tgl_masuk" class="required" title="Tanggal Masuk harus diisi"></dd>
    </dl>
	<dl>
		<dt><label for="simpanan_pokok">Simpanan Pokok :</label></dt>
        <dd><input type="text" name="simpanan_pokok" size="54" id="simpanan_pokok" class="required" readonly="" value="<?php echo $data['besar_simpanan'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Lengkap :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" class="required" title="Nama harus diisi"/></dd>
    </dl>
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd>
			<input type="radio" name="jenis_kelamin" value="Laki-laki" class="required" title="Jenis Kelamin harus diisi"/> Laki-laki
			<input type="radio" name="jenis_kelamin" value="Perempuan" class="required" title="Jenis Kelamin harus diisi"/> Perempuan		
		</dd>
    </dl>
	<dl>
        <dt><label for="tempat_lahir">Tempat / Tanggal Lahir :</label></dt>
        <dd><input type="text" name="tempat_lahir" size="26" class="required" title="Tempat Lahir harus diisi" /> / <input type="text" name="tgl_lahir" size="21" id="tanggal" class="required" title="Tanggal Lahir harus diisi"></dd>
    </dl>
	<dl>
        <dt><label for="alamat_anggota">Alamat Anggota :</label></dt>
        <dd><textarea name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" class="required" title="Alamat harus diisi"></textarea></dd>
    </dl>
	<dl>
        <dt><label for="no_identitas">No KTP/SIM :</label></dt>
        <dd><input type="text" name="no_identitas" size="54" class="required" title="No Identitas harus diisi"/></dd>
    </dl>
	<dl>
        <dt><label for="telp">Telepon :</label></dt>
        <dd><input type="text" name="telp" size="54" class="required" title="Telepon harus diisi"/></dd>
    </dl>   
	<dl>
        <dt><label for="pekerjaan">Pekerjaan :</label></dt>
        <dd><input type="text" name="pekerjaan" size="54" class="required" title="Pekerjaan harus diisi" /></dd>
    </dl>	
<!-- 	<dl>
        <dt><label for="photo">Foto :</label></dt>
        <dd><input type="file" name="photo" class="required" title="Foto harus diisi" /></dd>
    </dl> -->
    
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly ></dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
    </dl>
</fieldset>
   <div align="center">
    	<input type="submit" name="daftar" id="button1" value="Daftar" onClick="cetak_baru();" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</form>
</div>

<?php
	}elseif($aksi=='ubah'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysql_fetch_array($qubah);
?>

<div id="box">
<h3 id="adduser">Ubah Data Anggota</h3>
<form action="anggota/proses_anggota.php?pros=ubah" method="post" id="form" enctype="multipart/form-data">
<h4 id="adduser">Data Pribadi</h4>
<fieldset>
	<!-- <?php if($data2['photo']){?><img src="<?php echo $data2['photo'];?>" /><?php }else{?> <img src="img/who.gif" /> <?php }?> -->
	<dl>
		<dt>
		<label for="kode_anggota">Kode Anggota :</label>
		</dt>
        <dd><input type="text" name="kode_anggota" size="54" value="<?php echo $data2['kode_anggota'];?>" readonly=""/></dd>
    </dl>
	<dl>
		<dt><label for="tgl_masuk">Tanggal Masuk :</label></dt>
        <dd><input type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data2['tgl_masuk'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Lengkap :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" value="<?php echo $data2['nama_anggota'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd>
<?php	
	if ($data2['jenis_kelamin'] == "Laki-laki"){
		echo "<input type='radio' name='jenis_kelamin' value='Laki-laki' checked>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan'>Perempuan";
	}else if ($data2['jenis_kelamin'] == "Perempuan"){
		echo "<input type='radio' name='jenis_kelamin' value='Laki-laki'>Laki-laki <input type='radio' name='jenis_kelamin' value='Perempuan' checked>Perempuan";
	}
?>		
		</dd>
    </dl>
	<dl>
        <dt><label for="tempat_lahir">Tempat / Tanggal Lahir :</label></dt>
        <dd><input type="text" name="tempat_lahir" size="26" value="<?php echo $data2['tempat_lahir'];?>"/> / <input type="text" name="tgl_lahir" size="21" value="<?php echo $data2['tgl_lahir'];?>"></dd>
    </dl>
	<dl>
        <dt><label for="alamat_anggota">Alamat Anggota :</label></dt>
        <dd><textarea name="alamat_anggota" id="alamat_anggota" rows="5" cols="41"><?php echo $data2['alamat_anggota'];?></textarea></dd>
    </dl>
	<dl>
        <dt><label for="no_identitas">No KTP/SIM :</label></dt>
        <dd><input type="text" name="no_identitas" size="54" value="<?php echo $data2['no_identitas'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="telp">Telepon :</label></dt>
        <dd><input type="text" name="telp" size="54" value="<?php echo $data2['telp'];?>"/></dd>
    </dl>   	
	<dl>
        <dt><label for="pekerjaan">Pekerjaan :</label></dt>
        <dd><input type="text" name="pekerjaan" size="54" value="<?php echo $data2['pekerjaan'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="photo">Foto :</label></dt>
        <dd><input type="file" name="photo" value="<?php echo $data2['photo'];?>"/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly ></dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly /></dd>
    </dl>
</fieldset>
   <div align="center">
    	<input type="submit" name="ubah" id="button1" value="Ubah" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</form>
</div>

<?php
	}elseif($aksi=='hapus'){
		$kode=$_GET['kode_anggota'];
		$qhapus=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data3=mysql_fetch_array($qhapus);
?>

<div id="box">
<h3 id="adduser">Hapus Data Anggota</h3>
<form action="anggota/proses_anggota.php?pros=hapus" method="post" id="form">
<h4 id="adduser">Data Pribadi</h4>
<fieldset>
	<dl>
		<dt><label for="kode_anggota">Kode Anggota :</label></dt>
        <dd><input type="text" name="kode_anggota" size="54" value="<?php echo $data3['kode_anggota'];?>" readonly=""/></dd>
    </dl>
	<dl>
		<dt><label for="tgl_masuk">Tanggal Masuk :</label></dt>
        <dd><input type="text" name="tgl_masuk" size="54" id="tgl_masuk" value="<?php echo $data3['tgl_masuk'];?>" readonly=""></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Lengkap :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" value="<?php echo $data3['nama_anggota'];?>" readonly=""/></dd>
    </dl>
	<dl>
        <dt><label for="jenis_kelamin">Jenis Kelamin :</label></dt>
        <dd><input type="text" name="jenis_kelamin" size="54" value="<?php echo $data3['jenis_kelamin'];?>" readonly=""/></dd>
    </dl>
	<dl>
        <dt><label for="tempat_lahir">Tempat / Tanggal Lahir :</label></dt>
        <dd><input type="text" name="tempat_lahir" size="26" value="<?php echo $data3['tempat_lahir'];?>" readonly=""/> / <input type="text" name="tgl_lahir" size="21" value="<?php echo $data3['tgl_lahir'];?>" readonly=""></dd>
    </dl>
	<dl>
        <dt><label for="alamat_anggota">Alamat Anggota :</label></dt>
        <dd><textarea name="alamat_anggota" id="alamat_anggota" rows="5" cols="41" readonly=""><?php echo $data3['alamat_anggota'];?></textarea></dd>
    </dl>
	<dl>
        <dt><label for="no_identitas">No KTP/SIM :</label></dt>
        <dd><input type="text" name="no_identitas" size="54" value="<?php echo $data3['no_identitas'];?>" readonly=""/></dd>
    </dl>
	<dl>
        <dt><label for="telp">Telepon :</label></dt>
        <dd><input type="text" name="telp" size="54" value="<?php echo $data3['telp'];?>" readonly=""/></dd>
    </dl>   
	<dl>
        <dt><label for="pekerjaan">Pekerjaan :</label></dt>
        <dd><input type="text" name="pekerjaan" size="54" value="<?php echo $data3['pekerjaan'];?>" readonly=""/></dd>
    </dl>	
	<dl>
        <dt><label for="photo">Foto :</label></dt>
        <dd><input type="file" name="photo" value="<?php echo $data3['photo'];?>" readonly=""/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly></dd>
    </dl>
	<dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
    </dl>
</fieldset>
   <div align="center">
    	<input type="submit" name="hapus" id="button1" value="Hapus" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</form>
</div>

<?php
}elseif($aksi=='cetak'){
$kode=$_GET['kode_anggota'];
$query=mysql_query("SELECT * 
					FROM t_anggota
					WHERE kode_anggota = '$kode'");
$data=mysql_fetch_array($query);
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