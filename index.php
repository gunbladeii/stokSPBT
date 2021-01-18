<?php require('conn.php'); ?>
<?php

session_start();

$user = $_POST["username"];
$pass = $_POST["password"];

$login = $mysqli->query("SELECT * FROM login WHERE username = '$user' AND password='$pass'");
$res = mysqli_fetch_assoc($login);

if ($_SESSION['user'] || $_COOKIE["user"])
{
 header("Location:autologin.php");
 exit;
}
/*autologin end*/ 
if(isset($_POST["submit"]))
{

  if($res)
  {
    if(!empty($_POST["remember"]))
    {
      setcookie ("user", $user, time() + (86400 * 30 * 30), "/");
      setcookie ("pass", $pass, time() + (86400 * 30 * 30), "/");
    }
    else
    {
      if(isset($_COOKIE["user"]))
      {
        setcookie ("user", "");
      }
      if(isset($_COOKIE["pass"]))
      {
        setcookie ("pass", "");
      }
    }
  }
  else
  {
    $msg = "Invalid Username or Password";
  }

  if($res["role"] == "admin")
  {
    $_SESSION['user'] = $res['username'];
    $_SESSION['role'] = $res["role"];
    $_SESSION['password'] = $res["password"];
    header('Location:emonitoring/index.php');
  }
  else if($res["role"] == "stokNegeri")
  {
    $_SESSION['user'] = $res['username'];
    $_SESSION['role'] = $res["role"];
    $_SESSION['password'] = $res["password"];
    header('Location:emonitoringNegeri/indexNegeri/index.php');
  }
  else if($res["role"] == "sar")
  {
    $_SESSION['user'] = $res['username'];
    $_SESSION['role'] = $res["role"];
    $_SESSION['password'] = $res["password"];
    header('Location:emonitoringNegeri/epnegeri2.php');
  }
  else if($res["role"] == "bos")
  {
    $_SESSION['user'] = $res['username'];
    $_SESSION['role'] = $res["role"];
    $_SESSION['password'] = $res["password"];
    header('Location:penyeliaBOSS/indexBOSS/index.php');
  }
  else if($res["role"] != "admin" || $res["role"] != "stokNegeri" ||$res["role"] != "bos")
  {
    header('Location:index.php?message=fail');
  }

}

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>mySPBT2.0 | Log in</title>
  <link rel="icon" href="../img/favicon_myspbt.png" type="image/png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="adminSPBT/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="adminSPBT/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">

  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid justify-content-start" style="text-align: center">
      <a class="btn btn-outline-info me-2" href="dashboard/dashboard_main.php" name="stok">Paparan <em>Dashboard</em></a>
    </div>
  </nav>

  <div class="login-box shadow p-3 mb-5 bg-white rounded">
    <div class="login-logo">
      <a href="../../index.php"><img src="emonitoring/img/myspbt_logo.png" class="elevation-3" style="width:60%;opacity: .8"></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          <div class="alert alert-warning success-block">
            <ul>
              <li>Pengurusan Sebut Harga</li>
              <li>Pengurusan Stok</li>
            </ul>
          </div>
        </p>

        <form role="form" method="POST" class="login-form" name="prosesLogin">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="<?php if(isset($_COOKIE["user"])) {echo $_COOKIE["user"];} ?>">
            <div class="input-group-append input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php if(isset($_COOKIE["pass"])) {echo $_COOKIE["pass"];}?>"/>
            <div class="input-group-append input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["user"])) { ?> checked <?php }?>/>
                <label for="remember">
                  Remember Me
                </label>
              </div>
              <div class="col-8" style="text-align:center"><?php if(isset($msg)) {echo '<span class="badge badge-danger">'.$msg.'</span>';} ?></div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" name="submit" class="btn btn-primary btn-block btn-flat" value="Log In">
            </div>
            <!-- /.col -->
          </div>
        </form>
      <!--
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="adminSPBT/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="adminSPBT/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
