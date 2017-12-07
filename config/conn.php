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

?>
