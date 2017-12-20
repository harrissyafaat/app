<?php
	session_start();

// Proses Login
	if(empty($_SESSION['kopname'])){	
		header("location:login/login.php");
	}else{
		$pilih=$_GET['pilih'];
			switch($pilih){
				default 	: $tampil = "mst_isi.php"; break;
				case "1.1"	: $tampil = "petugas/mst_petugas.php"; break;
				case "1.2" 	: $tampil = "anggota/mst_anggota.php"; break;	
				case "1.3" 	: $tampil = "anggota/mst_tabungan.php"; break;
				case "2.1"	: $tampil = "transaksi/transaksi.php"; break;
				case "3.1" 	: $tampil = "laporan/laporan_anggota.php"; break;
				case "3.2" 	: $tampil = "laporan/laporan_simpanan.php"; break;
				case "3.3" 	: $tampil = "laporan/laporan_pinjaman.php"; break;	
				case "4.1"	: $tampil = "setting/setting_simpanan.php"; break;
				case "4.2"	: $tampil = "setting/setting_pinjaman.php"; break;
				case "4.3"	: $tampil = "setting/setting_user.php"; break;
			} //tutup switch
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Jam'iyah Waqi'ah | Sunan Kalijoro Kediri</title>
	<link rel="shortcut icon" href="images/logo_kop.gif" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link type="text/css" href="jquery/jquery.ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/ddaccordion.js"></script>
	<script type="text/javascript" src="js/validasi.js"></script>
	<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

	<!--jam-->
	window.setTimeout("waktu()",1000);   
    function waktu() {    
        var tanggal = new Date();   
        setTimeout("waktu()",1000);   
		document.getElementById("output").innerHTML = tanggal.getHours()+":"+tanggal.getMinutes()+":"+tanggal.getSeconds(); 
   }
</script>
</head>
<style type="text/css">
/* Firefox old*/
@-moz-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 

@-webkit-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
}
/* IE */
@-ms-keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 
/* Opera and prob css3 final iteration */
@keyframes blink {
    0% {
        opacity:1;
    }
    50% {
        opacity:0;
    }
    100% {
        opacity:1;
    }
} 
.blink-image {
    -moz-animation: blink normal 0.7s infinite ease-in-out; /* Firefox */
    -webkit-animation: blink normal 0.7s infinite ease-in-out; /* Webkit */
    -ms-animation: blink normal 0.7s infinite ease-in-out; /* IE */
    animation: blink normal 0.7s infinite ease-in-out; /* Opera and prob css3 final iteration */
}
</style>
</style>
<body>

	<div class="header">
	<div style=" padding-left: 25px;">
		<img style="width: 50px; float: left;" src="images/logo.png">
		<div style="float: left; padding-top: 5px; padding-left: 10px;">
		Jam'iyah Waqi'ah<br> 
		<h4>Sunan Kalijogo</h4>

		</div>
		<a href="fungsi/hitung_bunga.php" style=" float: right; padding-right: 25px; ">
			<?php
				$conn = new mysqli("localhost", "root", "toor", "app-koperasi");
				$tgl_sekarang = date('Y-m-d');
				$qt = mysqli_query ($conn, "SELECT DATEDIFF('$tgl_sekarang', tgl_hitung) AS tgl_hitung FROM t_bagihasil ORDER BY id DESC LIMIT 1");
				$rt = mysqli_fetch_array($qt, MYSQLI_ASSOC);
				$sel_tgl_hitung = $rt['tgl_hitung'];

				if ($sel_tgl_hitung >= 30){
					echo "<img style=\" margin-left: 13px;\" class=\"blink-image\" width=\"45px\" src=\"images/push.png\"><div style=\"font-size: 10px; color: white; margin-top: -5px;\">Hitung bunga</div>";
				}
			?>
		</a>
	</div>
	</div>
	<div class="sidebarmenu"></div>
	<div id="menutbar">
		<div class="satu">
 				<span class="label">Selamat Datang : </span> <?php echo $_SESSION['kopname'];?> &nbsp;&nbsp;
			</div>
			<div class="dua">
			<?php
					/*$namaHari   = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"); 
					$namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); 
					$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y'); 
					echo "<font color=#000><b>".$sekarang."</b><font>";*/
                ?>
			<div id="output"></div></div>
	</div>
	<div class="main-content">
		<div class="left-content">
			<?php include "kiri.php";?>
		</div>
		
		<div class="right-content"><br /><?php include("$tampil");?></div>  
	</div>              
	<div class="footer"><a>@ 2017 Jam'iyah Waqi'ah Sunan Kalijogo Kediri.</a></div>

	
		
</body>
<?php
}
?>
</html>