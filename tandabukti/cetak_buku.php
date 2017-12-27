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
$jenis_transaksi = $_GET['jenis_transaksi'];

$squery = "SELECT * FROM t_simpan WHERE kode_anggota='$kode_anggota' AND status=1";
$s=mysqli_query($koneksi,$squery);
$jumlahRow = mysqli_num_rows($s);

// max rows
// $maxRow = floor($ph - ($mt + $mb) / ($fs + $sa + $sb));
$spasi = $jumlahRow % 27;

if ($jenis_transaksi == 'simpan') {
  $data = mysqli_query ($koneksi, "SELECT kode_simpan, kode_jenis_simpan, tgl_simpan, besar_simpanan FROM t_simpan WHERE kode_anggota='$kode_anggota' AND status=0 ORDER BY kode_simpan ASC");
  $sq = mysqli_query ($koneksi, "SELECT sum(besar_simpanan) AS total_saldo FROM t_simpan WHERE kode_anggota='$kode_anggota'");
  $d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
  $total_saldo = $d['total_saldo'];
} elseif ($jenis_transaksi == 'pinjam') {
  $data = mysqli_query ($koneksi, "SELECT kode_jenis_pinjam, tgl_pinjam, besar_pinjaman FROM t_pinjam WHERE kode_anggota='$kode_anggota' OR status=0 ORDER BY kode_pinjam ASC");
  $sq = mysqli_query ($koneksi, "SELECT sum(besar_pinjaman) AS total_saldo FROM t_pinjam WHERE kode_anggota='$kode_anggota'");
  $d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
  $total_saldo = $d['total_saldo'];
} elseif ($jenis_transaksi == 'angsur'){
  $data = mysqli_query ($koneksi, "SELECT * FROM t_angsur WHERE kode_anggota='$kode_anggota' OR status=0 ORDER BY kode_angsur ASC");
  $sq = mysqli_query ($koneksi, "SELECT sum(besar_pinjaman) AS total_saldo FROM t_pinjam WHERE kode_anggota='$kode_anggota'");
  $d = mysqli_fetch_array($sq, MYSQLI_ASSOC);
  $total_saldo = $d['total_saldo'];
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
  	<?php
      echo "<div style='max-width:".$pw."px; max-height:".$ph."px; margin:".$mt."px ".$mr."px ".$mb."px ".$ml."px;'>"; 
  		$spaceTengah = $spasi;
      $n = 0;
  		for ($i=0; $i<$spasi; $i++){
  			echo "<span id='row'>&nbsp;</span>";
        $n++;

  		}

      	echo "<table width=\"100%\" style=\"text-align: right;\">"; 
      		if ($data->num_rows > 0){
      			if ($spasiTengah == 12){
      				echo "<span id='row'>&nbsp;</span>";
      				echo "<span id='row'>&nbsp;</span>";
              $n += 2;
      			}
        		while ($row = $data->fetch_assoc()){
        			if ($jenis_transaksi == 'simpan'){ 
                echo "<tr>";
                echo "<td width=\"20%\"><span id='row'>".$row["tgl_simpan"]."</span></td>"; 
                echo "<td width=\"15%\"><span id='row'>".$row["kode_jenis_simpan"]."</span></td>"; 
                if ($kode_jenis_simpan == 2){
                  echo "<td width=\"30%\"><span id='row'>".abs($row["besar_simpanan"])."</span></td>"; 
                  echo "<td width=\"30%\"><span id='row'></span></td>";   
                } else {
                  echo "<td width=\"30%\"><span id='row'></span></td>";   
                  echo "<td width=\"30%\"><span id='row'>".$row["besar_simpanan"]."</span></td>"; 
                }
                echo "<td width=\"35%\"><span id='row'>".$total_saldo."</span></td>";
                echo "</tr>";
                $n++;
                if ($n => 27){
                  echo "<div style='margin:".$mt."px 0px ".$mb."px 0px;'></div>"
                }
                // Update Status Print
                $qus = mysqli_query ($koneksi, "UPDATE t_simpan SET status='1' WHERE kode_simpan='$row[kode_simpan]'");

              } else if ($jenis_transaksi == 'pinjam') {
                // Display pnjam
                echo "<tr>";
                echo "<td width=\"20%\"><span id='row'>".$row["tgl_pinjam"]."</span></td>"; 
                echo "<td width=\"15%\"><span id='row'>".$row["kode_jenis_pinjam"]."</span></td>"; 
                echo "<td width=\"15%\"><span id='row'></span></td>"; 
                echo "<td width=\"15%\"><span id='row'>".$row["besar_pinjaman"]."</span></td>"; 
                echo "<td width=\"35%\"><span id='row'>".$total_saldo."</span></td>";
                echo "</tr>";
                $n++;
                if ($n => 27){
                  echo "<div style='margin:".$mt."px 0px ".$mb."px 0px;'></div>"
                }
                // Update Status Print
                $qus = mysqli_query ($koneksi, "UPDATE t_pinjam
                 SET status='1' WHERE kode_simpan='$row[kode_simpan]'");
              } else if ($jenis_transaksi == 'angsur'){
                // Display angsur
                echo "<tr>";
                echo "<td width=\"20%\"><span id='row'>".$row["tgl_angsur"]."</span></td>"; 
                echo "<td width=\"15%\"><span id='row'></span></td>"; 
                echo "<td width=\"15%\"><span id='row'>".$row["besar_angsuran"]."</span></td>";
                echo "<td width=\"15%\"><span id='row'></span></td>";  
                echo "<td width=\"35%\"><span id='row'>".$total_saldo."</span></td>";
                echo "</tr>";
                $n++;
                if ($n => 27){
                  echo "<div style='margin:".$mt."px 0px ".$mb."px 0px;'></div>"
                }
                // Update Status Print
                $qus = mysqli_query ($koneksi, "UPDATE t_simpan SET status='1' WHERE kode_simpan='$row[kode_simpan]'");
              }
      			}
      		}
      echo "</tr>"; 
		  echo "</table>";
  		echo "</div>"
  	?>
  </body>
</html>