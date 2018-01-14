<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Jam'iyah Waqi'ah | Sunan Kalijoro Kediri</title>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="../css/sb-admin.css" rel="stylesheet">


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

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form id="login-form" action="proses_login.php" method="post" onsubmit="return cekforms(this)">
          <div class="form-group">
            <label for="username">Username</label>
            <input name="username" class="form-control" id="username" type="text" placeholder="Masukan Username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input name="password" class="form-control" id="password" type="password" placeholder="Masukan Password">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
