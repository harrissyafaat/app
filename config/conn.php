<?php

$dbname = "app-koperasi";
$host = "localhost";
$username = "root";
$passwd = "toor";

$koneksi = mysqli_connect($host, $username, $passwd, $dbname);

if (mysqli_connect_errno()) {
    echo "Koneksi gagal";
    exit ();
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
