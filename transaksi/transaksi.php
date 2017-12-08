<?php 
	include "config/koneksi.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="js/validasi.js"></script>

<!-- SIMPANAN -->
	<script language="JavaScript">

	$(document).ready(function(){
		$(function() {
			$( '#tanggal' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$( '#tgl' ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
		});
	});
	// fungsi untuk get besar_simpanan
	function show(kode_jenis_simpan){
		$.ajax({
			type : "POST",
			data : "kode_jenis_simpan="+kode_jenis_simpan,
			url  : "dataSimpanan.php",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.NAMA_SIMPANAN!=""){
					$('#besar_simpanan').val(hasil.BESAR_SIMPANAN);				
				}else{
					$('#besar_simpanan').val("");				
				}
			}
		})
	}
	$(document).ready(function(){
		$("#kategori").change(function(){
			var kat = $("#kategori").val();
			if (kat == "tgl_simpan"){
				$("#cari").html('<input type=\"text\" name=\"input_cari\" id=\"tgl\" onclick=\"datePicker("tgl")\"/>');
			}else{
				$("#cari").html('<input type="text" name="input_cari" id="cari"/>');
			}
		});
	});
	</script>

<!-- PINJAMAN -->
	<script language="JavaScript">
		// fungsi untuk get besar_simpanan
	function show3(kode_jenis_pinjam){
		$.ajax({
			type : "POST",
			data : "kode_jenis_pinjam="+kode_jenis_pinjam,
			url : "dataJenisPinjaman.php",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.NAMA_PINJAMAN!=""){
					$('#lama_angsuran').val(hasil.LAMA_ANGSURAN);
					$('#maks_pinjam').val(hasil.MAKS_PINJAM);
				}else{		
					$('#lama_angsuran').val("");
					$('#maks_pinjam').val("");
				}
			}
		})
	}
	// menghitung pinjaman
		function startCalc(){
			interval = setInterval("calc()",1);
		}
		function calc(){
			a = document.frmAdd.besar_pinjaman.value;
			b = document.frmAdd.lama_angsuran.value;
			c = document.frmAdd.besar_angsuran.value = Math.round(a / b);
		}
		function stopCalc(){
			clearInterval(interval);
		} 
	</script>

<!-- ANGSURAN -->
	<script language="JavaScript">
	// fungsi untuk get besar_simpanan
	function show2(kode_pinjam){
		$.ajax({
			type : "POST",
			data : "kode_pinjam="+kode_pinjam,
			url : "dataPinjaman.php",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.kode_pinjam!=""){
					$('#kode_pinjam').val(hasil.KODE_PINJAM);
					$('#tgl_pinjam').val(hasil.TGL_PINJAM);
					$('#besar_pinjaman').val(hasil.BESAR_PINJAMAN);
					$('#lama_angsuran').val(hasil.LAMA_ANGSURAN);
					$('#besar_angsuran').val(hasil.BESAR_ANGSURAN);
					$('#angsuran_ke').val(hasil.ANGSURAN_KE);
					$('#sisa_pinjaman').val(hasil.SISA_PINJAMAN);	
					$('#besar_angsurane').val(hasil.BESAR_ANGSURAN);
				
				}else{		
					$('#kode_pinjam').val("");
					$('#tgl_pinjam').val("");
					$('#besar_pinjaman').val("");
					$('#lama_angsuran').val("");
					$('#besar_angsuran').val("");
					$('#angsuran_ke').val("");	
					$('#sisa_pinjaman').val("");
					$('#besar_angsurane').val("");

				}
			}
		})
	}
	// menghitung angsuran
	function startCalc2(){
		interval = setInterval("calc()",1);
	}
	function calc2(){
		a = document.frmAdd.besar_pinjaman.value;
		b = document.frmAdd.lama_angsuran.value;
		c = document.frmAdd.besar_angsuran.value;
		d = document.frmAdd.angsuran_ke.value;
		e = document.frmAdd.sisa_angsuran.value = e - 1 ;
		f = document.frmAdd.sisa_pinjaman.value = a - c ;
	}
	function stopCalc2(){
		clearInterval(interval);
	}

	function angsuran(){
		a = document.getElementById('sisa_pinjaman').value;
		b = document.getElementById('besar_angsuran').value;
		d = document.getElementById('besar_angsurane').value;
		c = a - b;
		if (c <= 0) {
			alert("Error! Input Besar Angsuran tidak Boleh Melebihi Sisa Pinjaman.");
			$('#besar_angsuran').val(" ");
			$('#besar_angsuran').val(d);

		}
		else{

		}

	}
	</script>

</head>

<?php
	if(empty($aksi)){
?>
<body>  
         	            
<div id="box">
<h3>Transaksi</h3>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilih Anggota</option>
        <option value="kode_anggota">Kode Anggota</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari;?>"><input type="submit" value="Cari">
</form>             

<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Kode Anggota</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Pekerjaan</a></th>
             <th><a href="#">Tanggal Masuk</a></th>
             <th colspan="3"><a href="">Aksi</a></th>
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
            <td align="center"><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td align="center"><?php echo $data['tgl_masuk'];?></td>
            <td align="center">
	<a href=index.php?pilih=2.1&aksi=simpan&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/simpan.png" title="Simpan" width="30" height="30" /></a>
	<a href=index.php?pilih=2.1&aksi=pinjam&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/pinjam.png" title="Pinjam" width="30" height="30" /></a>
    <a href=index.php?pilih=2.1&aksi=angsur&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/angsur.png" title="Angsur" width="30" height="30" /></a>
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
					echo '<a href="?pilih=2.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=2.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=2.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else {
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
	}elseif($aksi=='simpan'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysql_fetch_array($qubah);
?>

<div id="box">
<h3 id="adduser">Form Input Data Simpanan</h3>
<form action="transaksi/proses_transaksi.php?pros=simpan" method="post" id="form" name="mainform" onSubmit="validasiSimpan()">
<fieldset>
    <dl>
		<dt><label for="kode_anggota">Kode Anggota :</label></dt>
        <dd><input type="text" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" value="<?php echo $data2['kode_anggota'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Anggota :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="pekerjaan">Pekerjaan :</label></dt>
        <dd><input type="text" name="pekerjaan" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/></dd>
    </dl>
	 <dl>
		<dt><label for="tgl_simpan">Tanggal Simpan :</label></dt>
        <dd><input type="text" name="tgl_simpan" size="24" id="tanggal" class="required" title="Tanggal Simpan harus diisi" required /></dd>
    </dl>
	<dl>
        <dt><label for="nama_simpan">Jenis Simpanan :</label></dt>
        <dd>
            <select name="kode_jenis_simpan" id="kode_jenis_simpan" onChange="show(this.value)" class="required" title="Jenis Simpan harus diisi" style="width: 200px;" required>
                <option value="" selected="selected">- pilih jenis simpanan -</option>
                <?php
                $q=mysql_query("SELECT * FROM t_jenis_simpan");
                while($a=mysql_fetch_array($q)){
				$disabled = ($a['kode_jenis_simpan']=="S0001")? "disabled" : "";
                ?>
                    <option value="<?php echo $a['kode_jenis_simpan'];?>" <?php echo $disabled;?>><?php echo $a['nama_simpanan'];?></option>
                <?php
                }
                ?>
            </select>
		</dd>
	</dl>
	<dl>
        <dt><label for="besar_simpanan">Besar Simpanan :</label></dt>
        <dd><input type="text" name="besar_simpanan" id="besar_simpanan" size="54" required /></dd>
    </dl>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="user_entri" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly ></dd>
    </dl>
    <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly /></dd>
    </dl>
    <div align="center">
    	<input type="submit" name="tambah" id="button1" value="Tambah" onClick="cetak();" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
<iframe src="<?php echo "tandabukti/cetak_buku.php?kode_anggota=".$kode ?>" style="display:none;" name="frame"></iframe>
<script type="text/javascript">
	function simpan(){
	controlWindow=window.open("tandabukti/BTS.php?kode_anggota=<?php echo $kode ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=850,height=500");
    }
	function cetak(){
		frames['frame'].print();
	}

</script>

<?php

	}
	elseif($aksi=='pinjam'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysql_fetch_array($qubah);
?>

<div id="box">
<h3 id="adduser">Form Input Pinjaman</h3>
<form action="transaksi/proses_transaksi.php?pros=pinjam" method="post" id="form" name="frmAdd">
<fieldset>
    <dl>
		<dt><label for="kode_anggota">Kode Anggota :</label></dt>
        <dd><input type="text" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" value="<?php echo $data2['kode_anggota'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Anggota :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/></dd>
    </dl>
	<dl>
        <dt><label for="pekerjaan">Pekerjaan :</label></dt>
        <dd><input type="text" name="pekerjaan" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/></dd>
    </dl>
	 <dl>
		<dt><label for="tgl_pinjam">Tanggal Pinjam :</label></dt>
        <dd><input id="tanggal" type="text" name="tgl_pinjam" size="54" class="required" title="Tanggal Pinjam harus diisi"/></dd>
    </dl>
	<dl>
		<dt><label for="nama_pinjaman">Jenis Pinjaman :</label></dt>
        <dd>
        	<select name="kode_jenis_pinjam" id="kode_jenis_pinjam" onChange="show3(this.value)" class="required" title="Jenis Pinjaman harus diisi" style="width: 200px;">
                <option value="nama_pinjaman" selected="selected">- pilih jenis pinjaman -</option>
                <?php
                $q=mysql_query("SELECT * FROM t_jenis_pinjam");
                while($a=mysql_fetch_array($q)){
                ?>
					<option value="<?php echo $a['kode_jenis_pinjam'];?>"><?php echo $a['nama_pinjaman'];?></option>
				<?php
                }
                ?>
            </select>
		</dd>
    </dl>
	<dl>
		<dt><label for="lama_angsuran">Jumlah Angsuran :</label></dt>
        <dd><input id="lama_angsuran" type="text" name="lama_angsuran" size="54" readonly/></dd>
    </dl>
	<dl>
		<dt><label for="maks_pinjam">Maks Pinjaman :</label></dt>
        <dd><input id="maks_pinjam" type="text" name="maks_pinjam" size="54" readonly/></dd>
    </dl>
	<dl>
		<dt><label for="besar_pinjaman">Besar Pinjam :</label></dt>
        <dd><input type="text" name="besar_pinjaman" id="besar_pinjaman" size="54" class="required" title="Besar Pinjaman harus diisi"/></dd>
    </dl>
	<dl>
		<dt><label for="besar_angsur">Angsuran :</label></dt>
        <dd><input type="text" name="besar_angsuran" id="besar_angsuran" size="54" class="required" onFocus="startCalc();" onBlur="stopCalc();" readonly="" title="Besar Angsuran harus diisi" required /></dd>
    </dl>
	<dl>
		<dt><label for="u_entry">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC"></dd>
    </dl>
    <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC" /></dd>
    </dl>
    <div align="center">
    	<input type="submit" name="tambah" id="button1" value="Tambah" onClick="pinjam();" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
<script type="text/javascript">
	function pinjam(){
		controlWindow=window.open("tandabukti/BTP.php?kode_anggota=<?php echo $kode ?>","","toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=850,height=500");
	}
</script>
<?php
	}elseif($aksi=='angsur'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysql_query("SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysql_fetch_array($qubah);
?>

<div id="box">
<h3 id="adduser">Angsuran</h3>
<form action="transaksi/proses_transaksi.php?pros=angsur" method="post" id="form" name="frmAdd">
<fieldset>
	 <dl>
		<dt><label for="kode_anggota">Kode Anggota :</label></dt>
        <dd><input type="text" name="kode_anggota" size="54" readonly value="<?php echo $data2['kode_anggota'];?>"></dd>
    </dl>
    <dl>
        <dt><label for="nama_anggota">Nama Anggota :</label></dt>
        <dd><input type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/></dd>
    </dl>
    <dl>
		<dt><label for="kode_pinjam">Kode Pinjam :</label></dt>
        <dd>
        	<select name="kode_pinjam" id="kode_pinjam" onChange="show2(this.value)" class="required" title="Jenis Simpan harus diisi" style="width: 200px;">
                <option value="kode_pinjam" selected="selected"> - pilih kode pinjaman -</option>
                <?php
				$kode2=$_GET['kode_anggota'];
				$qubah=mysql_query("SELECT P.*, A.nama_anggota FROM t_pinjam P, t_anggota A WHERE P.kode_anggota='$kode' AND P.kode_anggota = A.kode_anggota and sisa_pinjaman > 0");
                $q=mysql_query("SELECT * FROM t_pinjam");
                while($a=mysql_fetch_array($qubah)){
                ?>
					<option value="<?php echo $a['kode_pinjam'];?>"><?php echo $a['kode_pinjam'];?></option>
				<?php
                }
                ?>
            </select>
		</dd>
    </dl>
    <dl>
		<dt><label for="tgl_pinjam">Tanggal Pinjam :</label></dt>
        <dd><input id="tgl_pinjam" type="text" name="tgl_pinjam" size="54" readonly /></dd>
    </dl>
	<dl>
		<dt><label for="besar_pinjaman">Besar Pinjam :</label></dt>
        <dd><input type="text" name="besar_pinjaman" id="besar_pinjaman" size="54" readonly onFocus="startCalc();" onBlur="stopCalc();"/></dd>
	</dl>
	<dl>
		<dt><label for="lama_angsur">Lama Angsur :</label></dt>
        <dd><input type="text" name="lama_angsuran" id="lama_angsuran" size="54" readonly onFocus="startCalc();" onBlur="stopCalc();"/></dd>
    </dl>
	<dl>
		<dt><label for="besar_angsur">Angsuran :</label></dt>
        <dd><input type="text" name="besar_angsuran" onFocus="angsuran();" onBlur="angsuran();" onclick="angsuran();" id="besar_angsuran" size="54"/>
        <input type="hidden" name="besar_angsurane" id="besar_angsurane" size="54"/> - bisa edit</dd>
    </dl>
	<dl>
		<dt><label for="sisa_pinjam">Angsuran Ke :</label></dt>
        <dd><input type="text" value="" name="angsuran_ke" id="angsuran_ke" size="54" readonly /></dd>
    </dl>
	<dl>
		<dt><label for="sisa_pinjam">Sisa Pinjaman :</label></dt>
        <dd><input type="text" value="" name="sisa_pinjaman" id="sisa_pinjaman" size="54" readonly /></dd>
    </dl>    
	<dl>
		<dt><label for="tgl_angsur">Tanggal angsur :</label></dt>
        <dd><input type="text" name="tgl_angsur" size="54" id="tanggal"/></dd>
    </dl>
	<dl>
		<dt><label for="user_entri">User Entri :</label></dt>
        <dd><input type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC"></dd>
    </dl>
    <dl>
        <dt><label for="tgl_entri">Tanggal Entri :</label></dt>
        <dd><input type="text" name="tgl_entri" size="54" value="<?php echo date("Y-m-d");?>" readonly/></dd>
    </dl>
    <div align="center">
    	<input type="submit" name="tambah" id="button1" value="Tambah" />
		<input type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>

<?php
	}
?>

