<?php require('conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'stokNegeri')
{
      header('Location:../index.php');
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


$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE username = '$colname_Recordset'");
$dataSH = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$username = $_POST['username'];
$negeri = $_POST['negeri'];
$tarikhSHSBegin = $_POST['tarikhSHSBegin'];
$tarikhBukaSH = $_POST['tarikhBukaSH'];
$tarikhTutupSH = $_POST['tarikhTutupSH'];
$tarikhPenilaianSH = $_POST['tarikhPenilaianSH'];
$tarikhSSTSH = $_POST['tarikhSSTSH'];
$namaPembekal = $_POST['namaPembekal'];
$nilaiSH = $_POST['nilaiSH'];
$tarikhCO = $_POST['tarikhCO'];
$bilJudulPesan = $_POST['bilJudulPesan'];
$bilNaskhahPesan = $_POST['bilNaskhahPesan'];
$bilNaskhahBekal = $_POST['bilNaskhahBekal'];
$peratusBekal = $_POST['peratusBekal'];
$statusBekal = $_POST['statusBekal'];
$statusTuntut = $_POST['statusTuntut'];
$statusBayar = $_POST['statusBayar'];
$remark = $_POST['remark'];

if (isset($_POST['submit'])) {
    $mysqli->query ("INSERT INTO `dataSH` (`username`,`negeri`,`tarikhSHSBegin`,`tarikhBukaSH`,`tarikhTutupSH`, `tarikhPenilaianSH`, `tarikhSSTSH`, `namaPembekal`, `nilaiSH`, `tarikhCO`, `bilJudulPesan`, `bilNaskhahPesan`, `bilNaskhahBekal`, `peratusBekal`,`statusBekal`, `statusTuntut`, `statusBayar`, `remark`) VALUES ('$username','$negeri','$tarikhSHSBegin','$tarikhBukaSH','$tarikhTutupSH', '$tarikhPenilaianSH','$tarikhSSTSH','$namaPembekal','$nilaiSH','$tarikhCO','$bilJudulPesan','$bilNaskhahPesan','$bilNaskhahBekal','$peratusBekal','$statusBekal','$statusTuntut','$statusBayar','$remark')");
    header("location:epnegeri.php");
    }

if (isset($_POST['update'])) {
    $mysqli->query ("UPDATE `dataSH` SET `tarikhSHSBegin` = '$tarikhSHSBegin',`tarikhBukaSH` = '$tarikhBukaSH',`tarikhTutupSH` = '$tarikhTutupSH',`tarikhPenilaianSH` = '$tarikhPenilaianSH',`tarikhSSTSH` = '$tarikhSSTSH',`namaPembekal` = '$namaPembekal',`nilaiSH` = '$nilaiSH',`tarikhCO` = '$tarikhCO',`bilJudulPesan` = '$bilJudulPesan',`bilNaskhahPesan` = '$bilNaskhahPesan',`bilNaskhahBekal` = '$bilNaskhahBekal',`peratusBekal` = '$peratusBekal',`statusBekal` = '$statusBekal',`statusTuntut` = '$statusTuntut',`statusBayar` = '$statusBayar',`remark` = '$remark' WHERE `username` = '$username'");
    header("location:epnegeri.php");
    }

$a = 1;
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>mySPBT 2.0 | Dashboard SH-Negeri</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../adminSPBT/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../adminSPBT/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../adminSPBT/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../adminSPBT/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../adminSPBT/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../adminSPBT/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../adminSPBT/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../adminSPBT/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Fugaz+One&family=Titan+One&display=swap" rel="stylesheet">
  <!-- chart.js plugin -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="epnegeri.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../adminSPBT/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Ahmad Taba
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Parcel damage during delivery...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../adminSPBT/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Ali Ahmad
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Noted..ASAP</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../adminSPBT/dist/img/user6-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Mohd Abu
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Balakong Hub succesfull delivered</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <!-- Exit -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="epnegeri.php">
          <i class="far fa-times-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item dropdown-footer">Logout</a>
        </div>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="epnegeri.php" class="brand-link">
      <img src="../adminSPBT/dist/img/logo_kpm.png" alt="altus Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-dark" style="font-family: 'Fugaz One', cursive;">mySPBT 2.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo strtoupper($row_Recordset['nama']);?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="epnegeri.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                 mySPBT 2.0 Dashboard
                <!--<i class="right fas fa-angle-left"></i>-->
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             
            </ul>
          </li>
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-family: 'Fugaz One', cursive;">mySPBT 2.0 Pengesanan Sebut Harga-Negeri</h1>
            <span class="badge badge-warning"><?php echo strtoupper($row_Recordset['nama']);?></span>
            <span class="badge badge-info"><?php echo strtoupper($row_Recordset['negeri']);?></span>
            <p>(*All data shown below as of <?php echo $date;?>)</p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="epnegeri.php">Home</a></li>
              <li class="breadcrumb-item active">mySPBT 2.0 | Pengesanan SH-Negeri</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
      <section class="content">
        <div id="row">
        <div class="col-md-12">
           <!-- TABLE: list of publisherSPBT -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">BORANG MAKLUMAT PENGESANAN SH-NEGERI</h3>
                <h2 class="card-title" style="font-size:14px;">(Dikemaskini pada <?php echo $date.' '.$time;?>)</h2>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                        <?php if (!empty($dataSSH)){?>
                        <div class="table-responsive">
                          <form method="post" action="epnegeri.php" role="form" enctype="multipart/form-data">
                            <table id="example1" class="table m-0">
                              <thead>
                                <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN A</h4></th>
                                </tr>
                              </thead>
                              <tbody>
                              
                             <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Sebut Harga Bermula:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhSHSBegin" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhSHSBegin'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                                <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Buka Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhBukaSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhBukaSH'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Tutup Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhTutupSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhTutupSH'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                                <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Penilaian Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhPenilaianSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhPenilaianSH'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Surat Setuju Terima:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhSSTSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhSSTSH'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              
                                 <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN B</h4></th>
                                </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Nama Pembekal Berjaya:
                                      <div class="input-group mb-3">
                                      <input type="text" name="namaPembekal" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['namaPembekal']);?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Nilai Sebut Harga (RM):
                                      <div class="input-group mb-3">
                                      <input type="number" name="nilaiSH" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['nilaiSH']);?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh C/O Dikeluarkan:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhCO" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhCO'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN C</h4></th>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Judul dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilJudulPesan" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['bilJudulPesan']);?>">
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Naskhah dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilNaskhahPesan" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['bilNaskhahPesan']);?>">
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Naskhah Telah dibekal:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilNaskhahBekal" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['bilNaskhahBekal']);?>">
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Peratus Pembekalan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="text" name="peratusBekal" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['peratusBekal']);?>">
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Pembekalan:
                                      <div class="input-group mb-3">
                                               <select name="statusBekal" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusBekal'];?>" selected><?php echo strtoupper($dataSH['statusBekal']);?></option>
                                                   <option value="SELESAI">SELESAI</option>
                                                   <option value="SEDANG BEKAL">SEDANG BEKAL</option>
                                                   <option value="BELUM BEKAL">BELUM BEKAL</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Tuntutan:
                                      <div class="input-group mb-3">
                                               <select name="statusTuntut" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusTuntut'];?>" selected><?php echo strtoupper($dataSH['statusTuntut']);?></option>
                                                   <option value="TELAH TUNTUT">TELAH TUNTUT</option>
                                                   <option value="BELUM TUNTUT">BELUM TUNTUT</option>
                                                   <option value="TUNTUT SEBAHAGIAN">TUNTUT SEBAHAGIAN</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Pembayaran:
                                      <div class="input-group mb-3">
                                               <select name="statusBayar" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusBayar'];?>" selected><?php echo strtoupper($dataSH['statusBayar']);?></option>
                                                   <option value="BELUM">BELUM</option>
                                                   <option value="SELESAI">SELESAI</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              </tbody>
                             </table>
                                <input type="hidden" name="remark" value="observe">
                                <input type="hidden" name="username" value="<?php echo $dataSH['username']; ?>">
                                <input type="hidden" name="negeri" value="<?php echo $dataSH['negeri']; ?>">
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-info" name="update" value="Kemaskini rekod"/>
                                </div>
                            </form>
                          </div>
                          <?php }?>

                          <?php if(empty($dataSH)){?>
                          <div class="table-responsive">
                          <form method="post" action="epnegeri.php" role="form" enctype="multipart/form-data">
                            <table id="example1" class="table m-0">
                              <thead>
                                <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN A</h4></th>
                                </tr>
                              </thead>
                              <tbody>
                              
                             <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Sebut Harga Bermula:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhSHSBegin" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                                <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Buka Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhBukaSH" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Tutup Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhTutupSH" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                                <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Penilaian Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhPenilaianSH" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh Surat Setuju Terima:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhSSTSH" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              
                                 <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN B</h4></th>
                                </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Nama Pembekal Berjaya:
                                      <div class="input-group mb-3">
                                      <input type="text" name="namaPembekal" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Nilai Sebut Harga (RM):
                                      <div class="input-group mb-3">
                                      <input type="number" name="nilaiSH" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Tarikh C/O Dikeluarkan:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhCO" class="form-control"  id="validationDefault01" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN C</h4></th>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Judul dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilJudulPesan" class="form-control"  id="validationDefault01" value="">
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Naskhah dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" id="bilNaskhahPesan" name="bilNaskhahPesan" class="form-control"  value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Naskhah Telah dibekal:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" id="bilNaskhahBekal" name="bilNaskhahBekal" class="form-control"  value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      Peratus Pembekalan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="text" id="peratusBekal" name="peratusBekal" class="form-control" value="" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Pembekalan:
                                      <div class="input-group mb-3">
                                               <select name="statusBekal" class="custom-select browser-default">
                                                   <option value="SELESAI">SELESAI</option>
                                                   <option value="SEDANG BEKAL">SEDANG BEKAL</option>
                                                   <option value="BELUM BEKAL">BELUM BEKAL</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Tuntutan:
                                      <div class="input-group mb-3">
                                               <select name="statusTuntut" class="custom-select browser-default">
                                                   <option value="TELAH TUNTUT">TELAH TUNTUT</option>
                                                   <option value="BELUM TUNTUT">BELUM TUNTUT</option>
                                                   <option value="TUNTUT SEBAHAGIAN">TUNTUT SEBAHAGIAN</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Pembayaran:
                                      <div class="input-group mb-3">
                                               <select name="statusBayar" class="custom-select browser-default">
                                                   <option value="BELUM">BELUM</option>
                                                   <option value="SELESAI">SELESAI</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              </tbody>
                             </table>
                                <input type="hidden" name="remark" value="observe">
                                <input type="hidden" name="username" value="<?php echo $row_Recordset['username']; ?>">
                                <input type="hidden" name="negeri" value="<?php echo $row_Recordset['negeri']; ?>">
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Simpan rekod"/>
                                </div>
                            </form>
                          </div>
                              <script>
                                  $(document).ready(function() {
                                  //this calculates values automatically 
                                  sum();
                                  $("#bilNaskhahBekal,#bilNaskhahPesan").on("keydown keyup", function() {
                                      sum();
                                  });

                                  function sum() {
                                          var num1 = document.getElementById('bilNaskhahBekal').value;
                                          var num2 = document.getElementById('bilNaskhahPesan').value;
                                    var result1 = parseInt(num1) / parseInt(num2);
                                    var result = (parseFloat(result1) * 100).toFixed(2);
                                          if (!isNaN(result)) 
                                          {
                                      document.getElementById('peratusBekal').value = result;
                                          }
                                          
                                      }
                                  });
                             </script>
                          <?php }?>
                    
        
                <!-- /.table-responsive -->
              </div>
              </div>
              </div>

                     
 </section>
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="../adminSPBT/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../adminSPBT/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../adminSPBT/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../adminSPBT/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../adminSPBT/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../adminSPBT/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../adminSPBT/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- jQuery Knob Chart -->
<script src="../adminSPBT/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../adminSPBT/plugins/moment/moment.min.js"></script>
<script src="../adminSPBT/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../adminSPBT/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../adminSPBT/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../adminSPBT/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- FastClick -->
<script src="../adminSPBT/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../adminSPBT/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../adminSPBT/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../adminSPBT/dist/js/demo.js"></script>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    
        $('#showJudulList').load('showJudulList.php');
        $('#showUserList').load('showUserList.php'); 
			setInterval(function () {
				$('#showAttChart').load('showAttChart.php')
				$('#showTotalPenerbit').load('showTotalPenerbit.php')
				$('#showTotalJudul').load('showTotalJudul.php')
				$('#showTotalPesanan').load('showTotalPesanan.php')
				$('#showTotalPembekalan').load('showTotalPembekalan.php')
			  $('#odometer').load('../distiSPBT/liveOdometer.php')
				$('#attStat').load('../distiSPBT/attStat.php')
				$('#parcelStat').load('../distiSPBT/parcelStat.php')
			}, 5000);
		});
</script>
<!-- DataTables -->
<script src="jquery.dataTables.js"></script>
<script src="dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

</body>
</html>
