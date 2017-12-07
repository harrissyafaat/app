<?php
	ini_set('display_errors',TRUE);
	$host	= "localhost";
	$user	= "root";
	$pass	= "toor";
	$db	= "app-koperasi";
	
	
	$koneksi=mysql_connect($host,$user,$pass);
	$db=mysql_select_db($db);
	
	if ($koneksi&&$db){
		//echo "berhasil : )";
	}else{
?>
	<script language="javascript">alert("Gagal Koneksi Database MySql !!")</script>
<?php
	}
	
	
	class Tabungan{
		private $saldo;
		function Tabungan($a){
			$this->saldo = $a;
		}
		function simpan($sim){
			$this->saldo = $this->saldo + $sim;
		}
		function pinjam($pin){
			$this->saldo = $this->saldo - $pin;
		}
		function cek_saldo(){
			return $this->saldo;
		}
	};
?>