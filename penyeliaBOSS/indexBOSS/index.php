<?php require('../conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'bos')
{
	header('Location:../../index.php');
}

?>
<?php

date_default_timezone_set("asia/kuala_lumpur");
$date = date('d-F-Y');
$datePHP = date('Y-m-d');

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
	$colname_Recordset = $_SESSION['user'];
}


$Recordset = $mysqli->query("SELECT login.username,login.nama,login.jawatan,dataSekolah.kodSekolah,dataSekolah.namaSekolah,dataSekolah.daerah,dataSekolah.negeri
	FROM login
	INNER JOIN dataSekolah ON login.remark = dataSekolah.kodSekolah 
	WHERE login.username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$namaSekolah = $_POST['namaSekolah'];
if (isset($_POST['submit'])) {
	$mysqli->query ("SELECT * FROM dataSekolah WHERE namaSekolah LIKE '$namaSekolah'");
	header("location:searching.php?namaSekolah=$namaSekolah");
}
$a = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>SPBT negeri</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<a href="../../logout.php">
					<i class="fas fa-times"></i>
				</a>
			</ul>
		</nav>
		<!-- /.navbar -->


		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-t-90 p-b-30">
					<form class="login200-form validate-form">
						<span class="login100-form-title p-b-40">
							<a href="../../logout.php"><img src="../img/myspbt_logo.png" style="max-width: 55%; max-height: 40%"></a>
						</span>

						<span class="login100-form-title p-b-40">
							Halaman Utama <br>(SPBT Negeri)
							<p>Selamat datang <strong><?php echo strtoupper($row_Recordset['nama']);?></strong> ke sistem mySPBT. Mohon klik pada pautan sistem berkenaan.</p>
							<p style="text-transform: uppercase;"><strong><?php echo strtoupper($row_Recordset['namaSekolah']).','.strtoupper($row_Recordset['daerah']).','.strtoupper($row_Recordset['negeri']);?></strong></p>
						</span>

						<div>
							<a href="../main3.php?kodSekolah=<?php echo strtoupper($row_Recordset['kodSekolah']);?>" class="btn-login-with bg2 m-b-10">
								<i class="fa fa-project-diagram"></i>
								Rekod Stok Bilik Operasi Buku Teks Sekolah
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	
	
	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>