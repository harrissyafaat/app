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
	          <i class="fa fa-table"></i> Laporan Pinjaman</div>
	        <div class="card-body">
	<div class="table-responsive">
	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
		<tr>
       <th>No</th>
       <th>Nama Anggota</th>
       <th>Jumlah Pinjaman</th>
			 <th>Sisa Pinjaman</th>
			 <th>Aksi</th>
   	</tr>
    </thead>
		<tbody>
<?php
			$query = mysqli_query($koneksi, "SELECT P.*, SUM(P.besar_pinjaman) AS total, A.kode_anggota,A.nama_anggota ,T.besar_tabungan
								FROM t_pinjam P, t_anggota A, t_tabungan T
								WHERE P.kode_anggota = A.kode_anggota
								AND A.kode_tabungan = T.kode_tabungan
								GROUP BY A.nama_anggota ASC");
		$no=1;
	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
    	<tr>
			<td align="center"><?php echo $no++;?></td>
			<td><?php echo $data['nama_anggota'];?></td>
			<td align="center"><?php echo "Rp. ".($data['total']);?></td>
			<td align="center"><?php echo "Rp. ".($data['sisa_pinjaman']);?></td>
			<td align="center">
			<a href=index.php?pilih=3.3&aksi=show&kode_anggota=<?php echo $data['kode_anggota'];?>><i class="fa fa-user"></i></a>
			</td>
      </tr>
<?php
	}
?>
</tbody>
</table>
</div>
</div>
</div>


<?php
	}elseif($aksi=='show'){
	$kode=$_GET['kode_anggota'];
	$q=mysqli_query($koneksi, "SELECT P.*, A.nama_anggota FROM t_pinjam P, t_anggota A
					WHERE P.kode_anggota = A.kode_anggota AND P.kode_anggota = '$kode'");
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
       <th>Nama</th>
       <th>Tanggal Pinjam</th>
       <th>Jumlah Pinjaman</th>
       <th>Lama Angsuran</th>
       <th>Besar Angsuran</th>
			 <th>Sisa Angsuran</th>
			 <th>Sisa Pinjaman</th>
   	</tr>
    </thead>
		<tbody>
<?php
		$query = mysqli_query($koneksi, "SELECT P.*, A.nama_anggota
								FROM t_pinjam P, t_anggota A
								WHERE P.kode_anggota = '$kode'
								AND P.kode_anggota = A.kode_anggota
								ORDER BY kode_pinjam ASC");
		$no=1;

	while($data=mysqli_fetch_array($query)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_anggota'];?></td>
			<td><?php echo Tgl($data['tgl_pinjam']);?></td>
			<td><?php echo Rp($data['besar_pinjaman']);?></td>
      <td><?php echo $data['lama_angsuran'];?></td>
			<td><?php echo Rp($data['besar_angsuran']);?></td>
			<td><?php echo $data['sisa_angsuran'];?></td>
			<td><?php echo Rp($data['sisa_pinjaman']);?></td>
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
		<a class="btn btn-primary" href="laporan/cetak_laporan_pinjaman.php">Export Word</a>
		<a class="btn btn-success" href="#">Export Excel</a>
		<a class="btn btn-danger" href="#">Print</a>
	</div>
	<div class="col-6 text-right">
		<input class="btn btn-warning" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>


<?php
}
?>

</body>
