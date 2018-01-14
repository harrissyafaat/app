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
</head>

<body>

<?php
	if(empty($aksi)){
?>
<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Laporan Anggota</div>
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
       <th>Tanggal Keluar</th>
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
       <th>Tanggal Keluar</th>
			 <th>Aksi</th>
    </tr>
	</tfoot>
	<tbody>
<?php
			$query = mysqli_query($koneksi, "SELECT * FROM t_anggota
								ORDER BY kode_anggota ASC");
	$no=1;
	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo $data['tgl_masuk'];?></td>
            <td><?php echo $data['tgl_keluar'];?></td>
            <td align="center"><a class="btn btn-default"><i class="fa fa-user"></i></a></td>
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
		<a class="btn btn-primary" href="laporan/cetak_laporan_anggota.php">Export Word</a>
		<a class="btn btn-success" href="#">Export Excel</a>
		<a class="btn btn-danger" href="#">Print</a>
	</div>
	<div class="col-6 text-right">
		<input class="btn btn-warning" type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>
<br>

<?php
}
?>

</body>
