<?php
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];

	$kd_anggota = $_GET['kode_anggota'];
?>

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

<!-- TABEL ANGGOTA -->

<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Data Transaksi</div>
        <div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </thead>
		<tfoot>
			<tr>
       <th>No</th>
       <th>Kode Anggota</th>
       <th>Nama Anggota</th>
       <th>Pekerjaan</th>
       <th>Tanggal Masuk</th>
       <th>Aksi</th>
       </tr>
    </tfoot>
		<tbody>
<?php
	$query=mysqli_query($koneksi, "SELECT * FROM t_anggota
						ORDER BY kode_anggota ASC");
	$no=0;

	while($data=mysqli_fetch_array($query)){
?>

    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td align="center"><?php echo $data['tgl_masuk'];?></td>
            <td align="center">
	<a class="btn btn-primary" href=index.php?pilih=2.1&aksi=simpan&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-save"></i></a>
	<a class="btn btn-warning" href=index.php?pilih=2.1&aksi=pinjam&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-save"></i></a>
  <a class="btn btn-success" href=index.php?pilih=2.1&aksi=angsur&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-save"></i></a>
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
	}elseif($aksi=='simpan'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<!-- FORM SIMPANAN -->
<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Input Data Simpanan</div>
  <div class="card-body">
<form action="transaksi/proses_transaksi.php?pros=simpan" method="post" id="form" name="mainform" >
<fieldset>
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" value="<?php echo $data2['kode_anggota'];?>">
	</div>
	<div class="form-group">
		<label for="nama_anggota">Nama Anggota :</label>
		<input class="form-control" type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
	</div>
	<div class="form-group">
		<label for="pekerjaan">Pekerjaan :</label>
		<input class="form-control" type="text" name="pekerjaan" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/>
	</div>
	<div class="form-group">
		<label for="tgl_simpan">Tanggal Simpan :</label>
		<input class="form-control" type="text" value="<?php echo date('Y-m-d'); ?>" name="tgl_simpan" size="10" id="tanggal" class="required" title="Tanggal Simpan harus diisi" required />
	</div>
	<div class="form-group">
		<label for="tgl_simpan">Jenis Transaksi :</label>
		<select class="form-control" name="jenis_transaksi" id="jenis_transaksi">
			<option value="simpan">Simpanan</option>
			<option value="pinjam">Pengambilan</option>
		</select>
	</div>
	<div class="form-group">
		<label for="nama_simpan">Jenis Simpanan :</label>
		<select class="form-control" name="kode_jenis_simpan" id="kode_jenis_simpan" onChange="show(this.value)" class="required" title="Jenis Simpan harus diisi" style="width: 200px;">
				<option value="" selected="selected">- pilih jenis simpanan -</option>
				<?php
				$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_simpan");
				while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
				?>
						<option value="<?php echo $a['kode_jenis_simpan'];?>" <?php echo $disabled;?>><?php echo $a['nama_simpanan'];?></option>
				<?php
				}
				?>
		</select>
	</div>
	<script type="text/javascript">
	$( "#jenis_transaksi" ).change(function() {
		if (this.value == "simpan"){
			$("#jenis_simpanan").show();
		} else {
			$("#jenis_simpanan").hide();
		}

	});
	</script>
	<div class="form-group">
		<label for="nominal">Nominal :</label>
		<input class="form-control" type="text" name="nominal" id="besar_simpanan" size="54" required />
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly >
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="10" value="<?php echo date("Y-m-d");?>" readonly />
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="tambah" id="button1" value="Tambah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>
</div>

<br>
<!-- DATA SIMPANAN -->
<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Tabel Data Simpanan</div>
  <div class="card-body">

		<div class="table-responsive">
	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
	     <th>No</th>
	     <th>Tanggal Entri</th>
	     <th>Jenis Simpanan</th>
	     <th>Nominal</th>
	     <th>Aksi</th>
    </tr>
    </thead>
		<tbody>
<?php
if ($_GET['aksi'] == "simpan"){
		$query=mysqli_query($koneksi, "SELECT * FROM t_simpan
						WHERE kode_anggota='$kd_anggota'
						ORDER BY kode_simpan ASC");
	$no=1;
	while($data=mysqli_fetch_array($query)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['tgl_entri'];?></td>
            <td><?php echo $data['kode_jenis_simpan'];?></td>
            <td><?php echo $data['besar_simpanan'];?></td>
            <td align="center">
	<a href=transaksi/proses_transaksi.php?pros=hapus&kode_simpan=<?php echo $data['kode_simpan'];?>><i class="fa fa-trash"></i></a>
			</td>
        </tr>

<?php
	} //tutup while
?>
</tbody>
	<?php } ?>
</table>
</div>
</div>
</div>
</div>
</div>


<?php

	}
	elseif($aksi=='pinjam'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<!-- FORM PINJAAN -->
<div class="row">
  <div class="col-12">
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Input Data Pinjaman</div>
  <div class="card-body">
<form action="transaksi/proses_transaksi.php?pros=pinjam" method="post" id="form" name="frmAdd">
<fieldset>
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="34" title="Kode Anggota harus diisi" readonly="" value="<?php echo $data2['kode_anggota'];?>">
	</div>
	<div class="form-group">
		<label for="nama_anggota">Nama Anggota :</label>
		<input class="form-control" type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
	</div>
	<div class="form-group">
		<label for="pekerjaan">Pekerjaan :</label>
		<input class="form-control" type="text" name="pekerjaan" size="54" readonly value="<?php echo $data2['pekerjaan'];?>"/>
	</div>
	<div class="form-group">
		<label for="tgl_pinjam">Tanggal Pinjam :</label>
		<input class="form-control" id="tanggal" value="<?php echo date('Y-m-d'); ?>" type="text" name="tgl_pinjam" size="10" class="required" title="Tanggal Pinjam harus diisi"/>
	</div>
	<div class="form-group">
		<label for="nama_pinjaman">Jenis Pinjaman :</label>
		<select class="form-control" name="kode_jenis_pinjam" id="kode_jenis_pinjam" onChange="show3(this.value)" class="required" title="Jenis Pinjaman harus diisi" style="width: 200px;">
					<option value="nama_pinjaman" selected="selected">- pilih jenis pinjaman -</option>
					<?php
					$q=mysqli_query($koneksi, "SELECT * FROM t_jenis_pinjam");
					while($a=mysqli_fetch_array($q, MYSQLI_ASSOC)){
					?>
		<option value="<?php echo $a['kode_jenis_pinjam'];?>"><?php echo $a['nama_pinjaman'];?></option>
	<?php
					}
					?>
			</select>
	</div>
	<div class="form-group">
		<label for="lama_angsuran">Jumlah Angsuran :</label>
		<input class="form-control" id="lama_angsuran" type="text" name="lama_angsuran" size="54" readonly/>
	</div>
	<div class="form-group">
		<label for="maks_pinjam">Maks Pinjaman :</label>
		<input class="form-control" id="maks_pinjam" type="text" name="maks_pinjam" size="54" readonly/>
	</div>
	<div class="form-group">
		<label for="besar_pinjaman">Besar Pinjam :</label>
		<input class="form-control" type="text" name="besar_pinjaman" id="besar_pinjaman" size="54" class="required" title="Besar Pinjaman harus diisi"/>
	</div>
	<div class="form-group">
		<label for="besar_angsur">Angsuran :</label>
		<input class="form-control" type="text" name="besar_angsuran" id="besar_angsuran" size="54" class="required" onFocus="startCalc();" onBlur="stopCalc();" readonly="" title="Besar Angsuran harus diisi" required />
	</div>
	<div class="form-group">
		<label for="u_entry">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC">
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="10" value="<?php echo date("Y-m-d");?>" readonly style="background-color:#CCCCCC" />
	</div>
	<div class="form-group text">
		<input class="btn btn-primary" type="submit" name="tambah" id="button1" value="Tambah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>
</div>

<!-- DATA PINJAMAN -->
<br>
<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i> Data Pinjaman</div>
				<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
             <th>No</th>
             <th>Tanggal Entri</th>
             <th>Kode Jenis Simpanan</th>
             <th>Nominal</th>
             <th>Aksi</th>
       	</tr>
    </thead>
		<tbody>
<?php
if ($_GET['aksi'] == "pinjam"){
		$query=mysqli_query($koneksi, "SELECT * FROM t_pinjam
						WHERE kode_anggota='$kd_anggota'
						ORDER BY kode_pinjam ASC");
	$no=1;
	while($data=mysqli_fetch_array($query)){

?>
    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['tgl_entri'];?></td>
            <td><?php echo $data['kode_jenis_pinjam'];?></td>
            <td><?php echo $data['besar_pinjaman'];?></td>
            <td align="center">
	<a class="btn btn-danger" href=transaksi/proses_transaksi.php?pros=hapus&kode_pinjam=<?php echo $data['kode_pinjam'];?>><i class="fa fa-trash"></i></a>
			</td>
        </tr>

<?php
	} //tutup while
?>
</tbody>
	</table>
	<?php } ?>
</div>
</div>
</div>




<!-- FORM ANGSURAN -->
<?php
	}elseif($aksi=='angsur'){
		$kode=$_GET['kode_anggota'];
		$qubah=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE kode_anggota='$kode'");
		$data2=mysqli_fetch_array($qubah, MYSQLI_ASSOC);
?>

<div class="row">
        <div class="col-12">
<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-plus"></i> Input Data Angsuran</div>
        <div class="card-body">
<form action="transaksi/proses_transaksi.php?pros=angsur" method="post" id="form" name="frmAdd">
<fieldset>
	<div class="form-group">
		<label for="kode_anggota">Kode Anggota :</label>
		<input class="form-control" type="text" name="kode_anggota" size="54" readonly value="<?php echo $data2['kode_anggota'];?>">
	</div>
	<div class="form-group">
		<label for="nama_anggota">Nama Anggota :</label>
		<input class="form-control" type="text" name="nama_anggota" size="54" readonly value="<?php echo $data2['nama_anggota'];?>"/>
	</div>
	<div class="form-group">
		<label for="kode_pinjam">Kode Pinjam :</label>
		<select class="form-control" name="kode_pinjam" id="kode_pinjam" onChange="show2(this.value)" class="required" title="Jenis Simpan harus diisi" style="width: 200px;">
					<option value="kode_pinjam" selected="selected"> - pilih kode pinjaman -</option>
					<?php
	$kode2=$_GET['kode_anggota'];
	$qubah=mysqli_query($koneksi, "SELECT P.*, A.nama_anggota FROM t_pinjam P, t_anggota A WHERE P.kode_anggota='$kode' AND P.kode_anggota = A.kode_anggota and sisa_pinjaman > 0");
					$q=mysql_query("SELECT * FROM t_pinjam");
					while($a=mysqli_fetch_array($qubah, MYSQLI_ASSOC)){
					?>
		<option value="<?php echo $a['kode_pinjam'];?>"><?php echo $a['kode_pinjam'];?></option>
	<?php
					}
					?>
			</select>
	</div>
	<div class="form-group">
		<label for="tgl_pinjam">Tanggal Pinjam :</label>
		<input class="form-control" id="tgl_pinjam" type="text" name="tgl_pinjam" size="10" readonly />
	</div>
	<div class="form-group">
		<label for="besar_pinjaman">Besar Pinjam :</label>
		<input class="form-control" type="text" name="besar_pinjaman" id="besar_pinjaman" size="54" readonly onFocus="startCalc();" onBlur="stopCalc();"/>
	</div>
	<div class="form-group">
		<label for="lama_angsur">Lama Angsur :</label>
		<input class="form-control" type="text" name="lama_angsuran" id="lama_angsuran" size="54" readonly onFocus="startCalc();" onBlur="stopCalc();"/>
	</div>
	<div class="form-group">
		<label for="besar_angsur">Angsuran :</label>
		<input class="form-control" type="text" name="besar_angsuran" onFocus="angsuran();" onBlur="angsuran();" onclick="angsuran();" id="besar_angsuran" size="54"/>
		<input class="form-control" type="hidden" name="besar_angsurane" id="besar_angsurane" size="54"/> - bisa edit
	</div>
	<div class="form-group">
		<label for="sisa_pinjam">Angsuran Ke :</label>
		<input class="form-control" type="text" value="" name="angsuran_ke" id="angsuran_ke" size="54" readonly />
	</div>
	<div class="form-group">
		<label for="sisa_pinjam">Sisa Pinjaman :</label>
		<input class="form-control" type="text" value="" name="sisa_pinjaman" id="sisa_pinjaman" size="54" readonly />
	</div>
	<div class="form-group">
		<label for="tgl_angsur">Tanggal angsur :</label>
		<input class="form-control" type="text" value="<?php echo date('Y-m-d'); ?>" name="tgl_angsur" size="10" id="tanggal"/>
	</div>
	<div class="form-group">
		<label for="user_entri">User Entri :</label>
		<input class="form-control" type="text" name="u_entry" size="54" value="<?php session_start(); echo $_SESSION['kopname'];?>" readonly style="background-color:#CCCCCC">
	</div>
	<div class="form-group">
		<label for="tgl_entri">Tanggal Entri :</label>
		<input class="form-control" type="text" name="tgl_entri" size="10" value="<?php echo date("Y-m-d");?>" readonly/>
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" name="tambah" id="button1" value="Tambah" />
		<input class="btn btn-danger" type="button" name="back" id="button1" value="Back" onClick="self.history.back()"/>
	</div>
</fieldset>
</form>
</div>
</div>
</div>
</div>

<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i> Tabel Data Angsuran</div>
				<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
             <th>No</th>
             <th>Tanggal Entri</th>
             <th>Jenis Simpanan</th>
             <th>Nominal</th>
             <th>Aksi</th>
       	</tr>
    </thead>
		<tbody>
<?php
if ($_GET['aksi'] == "angsur"){
	$query=mysqli_query($koneksi, "SELECT * FROM t_angsur
						WHERE kode_anggota='$kd_anggota'
						ORDER BY kode_angsur ASC");
	$no=1;
	while($data=mysqli_fetch_array($query)){

?>
    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['tgl_entri'];?></td>
            <td><?php echo $data['kode_pinjam'];?></td>
            <td><?php echo $data['besar_angsuran'];?></td>
            <td align="center">
	<a class="btn btn-danger" href=transaksi/proses_transaksi.php?pros=hapus&kode_angsur=<?php echo $data['kode_angsur'];?>><i class="fa fa-trash"></i></a>
			</td>
        </tr>
<?php
	} //tutup while
?>
</tbody>
	</table>
	<?php } ?>
</div>
</div>
</div>

<?php
	}
?>
