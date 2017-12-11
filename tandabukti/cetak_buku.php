<?php
include '../config/conn.php';

// Quality in DPI
$quality = 96;

// Page Ratio in CM
$pageWidth = 13;
$pageHeight = 18;

// Page Margin in CM
$marginTop = 2.1;
$marginRight = 0.3;
$marginBottom = 0.8;
$marginLeft = 0.3;

// Font in PT
$fontSize = 12;
$spaceBefore;
$spaceAfter = 8;

// Convert All Settings to Pixel
$pw = ($pageWidth * $quality) / 2.54;
$ph = ($pageHeight * $quality) / 2.54;

$mt = ($marginTop * $quality) / 2.54;
$mr = ($marginRight * $quality) / 2.54;
$mb = ($marginBottom * $quality) / 2.54;
$ml = ($marginLeft * $quality) / 2.54;

$fs = $fontSize / 0.75;
$sb = $spaceBefore / 0.75;
$sa = $spaceAfter / 0.75;

$kode_anggota = $_GET['kode_anggota'];

$squery = "SELECT * FROM t_simpan WHERE kode_anggota='$kode_anggota' AND status=1";
$s=mysqli_query($koneksi,$squery);
$jumlahRow = mysqli_num_rows($s);

// max rows
// $maxRow = floor($ph - ($mt + $mb) / ($fs + $sa + $sb));
$spasi = $jumlahRow % 27;

$data = mysqli_query ($koneksi, "SELECT kode_jenis_simpan, tgl_simpan, besar_simpanan FROM t_simpan WHERE kode_anggota='$kode_anggota' AND kode_jenis_simpan='S0001' ORDER BY kode_simpan DESC LIMIT 1");

$saldo = mysqli_query ($koneksi, "SELECT sum(besar_simpanan) AS total_saldo FROM t_simpan WHERE kode_anggota='$kode_anggota'");
while ($row = $saldo->fetch_assoc()){
	$total_saldo = $row["total_saldo"];
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      @media print {
      	#row {
      		display: block;
          font-size: 9pt;
      		-webkit-margin-after:5pt;
      	}
      }
      #row {
      		display: block;
          font-size: 9pt;
      		-webkit-margin-after:5pt;
    </style>
  </head>
  <body>
  	<?php echo "<div style='max-width:".$pw."px; max-height:".$ph."px; margin:".$mt."px ".$mr."px ".$mb."px ".$ml."px;'>"; 
  		$spaceTengah = $spasi;

  		for ($i=0; $i<$spasi; $i++){
  			echo "<span id='row'>&nbsp;</span>";

  		}

      	echo "<table width=\"100%\" style=\"text-align: right;\">"; 
		echo "<tr>";
      		if ($data->num_rows > 0){
      			if ($spasi = 12){
      				echo "<span id='row'>&nbsp;</span>";
      				echo "<span id='row'>&nbsp;</span>";
      			}
        		while ($row = $data->fetch_assoc()){
      			echo "<td width=\"8%\"><span id='row'>01</span></td>"; 
				echo "<td width=\"20%\"><span id='row'>".$row["tgl_simpan"]."</span></td>"; 
				echo "<td width=\"12%\"><span id='row'>".$row["kode_jenis_simpan"]."</span></td>"; 
				echo "<td width=\"30%\"><span id='row'>".$row["besar_simpanan"]."</span></td>"; 
				echo "<td width=\"30%\"><span id='row'>".$total_saldo."</span></td>";
      			}
      		}
      	echo "</tr>"; 
		echo "</table>";
  		echo "</div>"
  	?>
  </body>
</html>