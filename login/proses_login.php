<?php
session_start();

include "../config/koneksi.php";

// Dikirim dari form
$username=$_POST['username'];
$password=$_POST['password'];

// Melindungi dari SQL injection
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

$query=mysql_query("SELECT * FROM t_user WHERE username='$username' AND password='$password'");
$jumlah=mysql_num_rows($query);
$a=mysql_fetch_array($query);

if($jumlah > 0){
	$_SESSION['kopid']=$a['kode_user'];
	$_SESSION['kopname']=$a['username'];
	//session_register("username");
	//session_register("password");
	header("location:../index.php?pilih=home");
}else{
	header("location:login.php?err=1");
}
?>

