<?php
	session_start();

// Proses Login
$breadcrum = "<li class='breadcrumb-item'>Home</li>";
	if(empty($_SESSION['kopname'])){
		header("location:login/login.php");
	}else{
		$pilih=$_GET['pilih'];
			switch($pilih){
				default 	: $tampil = "mst_isi.php"; break;
				case "1.1"	:
					$tampil = "petugas/mst_petugas.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Petugas</li>";
					break;
				case "1.2" 	:
					$tampil = "anggota/mst_anggota.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Anggota</li>";
					break;
				case "1.3" 	:
					$tampil = "anggota/mst_tabungan.php";
					$breadcrum = "<li class='breadcrumb-item'>Master Data</li><li class='breadcrumb-item active'>Data Tabungan</li>";
					break;
				case "2.1"	:
					$tampil = "transaksi/transaksi.php";
					$breadcrum = "<li class='breadcrumb-item'>Transaksi</li>";
					break;
				case "3.1" 	:
					$tampil = "laporan/laporan_anggota.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Anggota</li>";
					break;
				case "3.2" 	:
					$tampil = "laporan/laporan_simpanan.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Simpanan</li>";
					break;
				case "3.3" 	:
					$tampil = "laporan/laporan_pinjaman.php";
					$breadcrum = "<li class='breadcrumb-item'>Laporan</li><li class='breadcrumb-item active'>Data Pinjaman</li>";
					break;
				case "4.1"	:
					$tampil = "setting/setting_simpanan.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>Simpanan</li>";
					break;
				case "4.2"	:
					$tampil = "setting/setting_pinjaman.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>Pinjaman</li>";
					break;
				case "4.3"	:
					$tampil = "setting/setting_user.php";
					$breadcrum = "<li class='breadcrumb-item'>Setting</li><li class='breadcrumb-item active'>User</li>";
					break;
			} //tutup switch

			// Hitung Period Tampilan Set Hitung Bunga
			$conn = new mysqli("localhost", "root", "toor", "app-koperasi");
			$tgl_sekarang = date('Y-m-d');
			$qt = mysqli_query ($conn, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
			$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
			$sel_tgl_hitung = $rt['tgl_hitung'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Jamaah Waqiah | Sunan Kalijogo Kediri</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="css/sb-admin.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/logo_kop.gif" />

	<script src="vendor/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="js/validasi.js"></script>
	<script type="text/javascript">
	<!--jam-->
	window.setTimeout("waktu()",1000);
    function waktu() {
        var tanggal = new Date();
        setTimeout("waktu()",1000);
		document.getElementById("output").innerHTML = tanggal.getHours()+":"+tanggal.getMinutes()+":"+tanggal.getSeconds();
   }
</script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">Jamaah Waqiah - Sunan Kalijogo Kediri</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php?pilih=home">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Master Data">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#masterdata" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Master Data</span>
          </a>
          <ul class="sidenav-second-level collapse" id="masterdata">
            <li>
              <a href="index.php?pilih=1.1">Master Petugas</a>
            </li>
            <li>
              <a href="index.php?pilih=1.2">Master Anggota</a>
            </li>
          </ul>
        </li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Transaksi">
          <a class="nav-link" href="index.php?pilih=2.1">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Transaksi</span>
          </a>
        </li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Laporan">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#laporan" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Laporan</span>
          </a>
          <ul class="sidenav-second-level collapse" id="laporan">
            <li>
              <a href="index.php?pilih=3.1">Data Anggota</a>
            </li>
            <li>
              <a href="index.php?pilih=3.2">Data Simpanan</a>
            </li>
						<li>
              <a href="index.php?pilih=3.3">Data Pinjaman</a>
            </li>
          </ul>
        </li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Setting">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#setting" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Setting</span>
          </a>
          <ul class="sidenav-second-level collapse" id="setting">
            <li>
              <a href="index.php?pilih=4.1">Setting Simpanan</a>
            </li>
            <li>
              <a href="index.php?pilih=4.2">Setting Pinjaman</a>
            </li>
						<li>
              <a href="index.php?pilih=4.3">Setting User</a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i><?php echo $_SESSION['kopname']; ?></a>
        </li>
      </ul>
    </div>
  </nav>

	<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
        <?php echo $breadcrum ?>
    </ol>
			<?php
			// Tampilkan Button Hitung Bunga
			if ($sel_tgl_hitung >= 30){ ?>
			<div class="alert alert-warning">
				<p>Periode Hitung Bunga Sudah <?php echo $sel_tgl_hitung ?> Hari</p>
				<a href="fungsi/hitung_bunga.php" class="btn btn-danger">Hitung</a>
			</div>
		<?php } ?>
		<div class="row">
			<div class="col-12">
				<?php include("$tampil");?>
			</div>
		</div>
	</div>
	<!-- /.container-fluid-->
	<!-- /.content-wrapper-->
	<footer class="sticky-footer">
		<div class="container">
			<div class="text-center">
				<small>Copyright © Daimus Programming 2017</small>
			</div>
		</div>
	</footer>
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fa fa-angle-up"></i>
	</a>
</div>

<?php
}
?>


<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="js/sb-admin-datatables.min.js"></script>

</body>
</html>
