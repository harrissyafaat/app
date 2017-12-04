<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Login Page</title>
	<link rel="shortcut icon" href="../images/logo_kop.gif" />
       <link rel="stylesheet" href="../css/multi_form/style.css">
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- polaris icheck -->
        <link href="../css/iCheck/polaris/polaris.css" rel="stylesheet" type="text/css" />
        <!-- Datepicker -->
        <link href="../css/datepicker/datepicker.css" rel="stylesheet" type="text/css" />

        <style type="text/css">
		<style type="text/css">

		.content{

			display:none;

		}

		</style>

          <!-- jQuery 2.0.2 -->

          <script src="../js/jquery-2.2.4.js" crossorigin="anonymous"></script>          

          <!-- jQuery UI 1.10.3 -->

          <script src="../js/jquery-ui.js"></script>


	<script language="javascript">
	//pengecekan input password
	function cekforms(frm){
		var username=frm['username'].value;
		var password=frm['password'].value;
		if(username.length==0 || password.length==0){
			alert("Username dan Password harus diisi !");
			frm['username'].focus();
			return false;
		}
	}
	<?php
		if($_REQUEST['logout']==1){
			echo "setTimeout(\"alert('Logout Sukses')\",200);";
		}else if($_REQUEST['err']==1){
			echo "setTimeout(\"alert('Maaf Username atau Password Salah, silahkan ulangi lagi')\",200);";
		}else if($_REQUEST['login']==1){
			echo "setTimeout(\"alert('Anda Harus login terlebih dahulu')\",200);";
		}
	?>
	</script>
</head>

<body>
	<div align="center" style="margin-top:60px;">
		<img width="90" src="../images/logo.png"/>
		<h4 style="color:#bfb91e; text-shadow: 1px 1px #1A1111;">UNIT SIMPAN PINJAM<br>JAM'IYAH WAQI'AH SUNAN KALIJOGO</h4>
	</div>
	<div class="form-box" id="login-box" style="margin-top:10px;">
		<div class="header"><h3>Aplikasi
Simpan Pinjam</h3></div>
	<form id="login-form" action="proses_login.php" method="post" onsubmit="return cekforms(this)">
			<div class="body bg-gray">
				<div class="error"><strong>
					
				</strong></div>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="User Name" autocomplete="off" /><i class="fa fa-user" style="float:right; margin-top:-25px; margin-right:12px;"></i>
					
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password"/><i class="fa fa-lock" style="float:right; margin-top:-25px; margin-right:12px;"></i>
					 
				</div>    

			</div>
			<div class="footer" style="height:80px; padding-top:20px;">    
                                                       
			<div style="float:right;">
				<button style="font-size:18px; width:125px;" type="submit" class="btn btn-success"> Masuk</button>
			</div> 	
			</div>
			<div class="bantuan" style="background: #B4B118; color: #000; height:25px;">
				<center style="padding-top:2px;">@ 2016 Jam'iyah Waqi'ah Sunan Kalijogo</center>
			</div>
			<br>
		</form>
	</div>

	<style type="text/css">
		.bantuan {
			-webkit-border-top-left-radius: 0;
		    -webkit-border-top-right-radius: 0;
		    -webkit-border-bottom-right-radius: 4px;
		    -webkit-border-bottom-left-radius: 4px;
		    -moz-border-radius-topleft: 0;
		    -moz-border-radius-topright: 0;
		    -moz-border-radius-bottomright: 4px;
		    -moz-border-radius-bottomleft: 4px;
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;
		    border-bottom-right-radius: 4px;
		    border-bottom-left-radius: 4px;
		}
	</style>