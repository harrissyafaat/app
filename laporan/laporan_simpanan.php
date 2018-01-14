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
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

<?php
	if(empty($aksi)){
?>
<body>
	<div class="card mb-3">
	        <div class="card-header">
	          <i class="fa fa-table"></i> Laporan Data Simpanan</div>
	        <div class="card-body">
	<div class="table-responsive">
	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Simpanan Pokok</th>
			<th>Simpanan Wajib</th>
			<th>Simpanan Sukarela</th>
			<th>Total Simpanan</th>
			<th>Aksi</th>
		</tr>
    </thead>
<?php
			$query = mysqli_query($koneksi, "SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								GROUP BY A.kode_anggota");
		$no=1;

	while($data=mysqli_fetch_array($query)){
		$kode=$data['kode_anggota'];
		$query1=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND S.kode_jenis_simpan='S0001'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qpokok=mysqli_fetch_array($query1);

		$query2=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0002'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qwajib=mysqli_fetch_array($query2);

		$query3=mysqli_query($koneksi, "SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0003'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qsukarela=mysqli_fetch_array($query3);

		$total = $qpokok['total'] + $qwajib['total'] + $qsukarela['total'];
		//echo $qwajib;echo $data['kode_anggota'];
		//echo $kode;
		//echo $total;
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td style="text-align:left"><?php echo $data['nama_anggota'];?></td>
			<td align="center"><?php echo Rp($qpokok['total']?$qpokok['total']:0);?></td>
			<td align="center"><?php echo Rp($qwajib['total']?$qwajib['total']:0);?></td>
			<td align="center"><?php echo Rp($qsukarela['total']?$qsukarela['total']:0);?></td>
			<td align="center"><?php echo Rp($total);?></td>
			<td align="center">
	<a class="btn btn-primary" href=index.php?pilih=3.2&aksi=show&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-user"></i></a></td>
        </tr>
	</tbody>
<?php
	}
?>
	</table>
</div>

<?php
	}elseif($aksi=='show'){
	$kode=$_GET['kode_anggota'];
	$q=mysqli_query($koneksi, "SELECT S.*, A.nama_anggota FROM t_simpan S, t_anggota A
					WHERE S.kode_anggota = A.kode_anggota AND S.kode_anggota = '$kode'");
	$ang=mysqli_fetch_array($q);
?>

<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Laporan Simpanan Anggota <?php echo $ang['nama_anggota'];?></div>
        <div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
       <th>No</th>
       <th>Tanggal Simpan</th>
       <th>Nama Simpanan</th>
			 <th>Besar Simpanan</th>
			 <th>Petugas</th>
      </tr>
    </thead>

		<tbody>
<?php
		$query = mysqli_query($koneksi, "SELECT S.*, A.nama_anggota, J.nama_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE S.kode_anggota = '$kode'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								ORDER BY kode_simpan ASC");
		$no=1;

	while($data=mysqli_fetch_array($query)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo Tgl($data['tgl_simpan']);?></td>
			<td><?php echo $data['nama_simpanan'];?></td>
      <td><?php echo Rp($data['besar_simpanan']);?></td>
			<td><?php echo $data['u_entry'];?></td>
      </tr>
<?php
	}
?>
</tbody>
</table>
</div>
</div>
</div>

<div class="row">
	<div class="col-6">
		<a class="btn btn-primary" href="laporan/cetak_laporan_simpanan.php">Export Word</a>
		<a class="btn btn-success" href="">Export Excel</a>
		<a class="btn btn-danger" href="">Print</a>
	</div>
	<div class="col-6 text-right">
		<input class="btn btn-warning" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>

<?php
}
?>

</body>
