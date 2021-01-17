<?php require('conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'bos')
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

$kodSekolah = $_GET['kodSekolah'];
$kodSekolah2 = $_POST['kodSekolah'];
$namaSekolah = $_POST['namaSekolah'];
$bukuLebihan = $_POST['bukuLebihan'];
$bukuStok = $_POST['bukuStok'];
$kodJudul = $_POST['kodJudul'];
$comment = $_POST['comment'];

$judul = $_POST['judul'];
$judul2 = $_GET['judul'];
$jenisAliran = $_POST['jenisAliran'];
$jenisAliran2 = $_GET['jenisAliran'];


$Recordset = $mysqli->query("SELECT login.username,login.nama,login.jawatan,dataSekolah.kodSekolah,dataSekolah.namaSekolah,dataSekolah.daerah,dataSekolah.negeri,dataSekolah.jenisAliran
  FROM login
  INNER JOIN dataSekolah ON login.remark = dataSekolah.kodSekolah 
  WHERE login.username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$Recordset2 = $mysqli->query("SELECT *,DATE_FORMAT(tarikhPemantauan, '%d/%m/%Y') AS tarikhP FROM dataSekolah WHERE kodSekolah LIKE '$kodSekolah'");
$dataSekolah = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT * FROM dataJudul");
$dataJudul = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$Recordset4 = $mysqli->query("SELECT rekodPemantauan.id, rekodPemantauan.kodSekolah, rekodPemantauan.kodJudul, dataJudul.judul, rekodPemantauan.bukuLebihan, rekodPemantauan.bukuStok, dataSekolah.kategori,rekodPemantauan.bukuRosak,rekodPemantauan.bukuRosakMurid
  FROM ((rekodPemantauan 
  INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul)
  INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah)
  WHERE rekodPemantauan.kodSekolah = '$kodSekolah' AND dataSekolah.kategori = 'BOSS'");
$rekodPemantauan = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$Recordset7 = $mysqli->query("SELECT rekodPemantauan.id, rekodPemantauan.kodSekolah, rekodPemantauan.kodJudul, dataJudul.judul, rekodPemantauan.bukuLebihan, rekodPemantauan.bukuStok, dataSekolah.kategori,rekodPemantauan.bukuRosak
  FROM ((rekodPemantauan 
  INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul)
  INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah)
  WHERE rekodPemantauan.kodSekolah = '$kodSekolah' AND dataSekolah.kategori = 'BOSD'");
$rekodPemantauan2 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);

$Recordset5 = $mysqli->query("SELECT * FROM dataJudul GROUP BY jenisAliran");
$dataAliranSekolah = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);

$Recordset6 = $mysqli->query("SELECT * FROM dataJudul WHERE judul LIKE '%$judul2%' AND jenisAliran = '$jenisAliran2' ORDER BY judul,darjahTingkatan ASC");
$dataJudul2 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);

if (isset($_POST['submit2'])) {
  $mysqli->query ("UPDATE `dataSekolah` SET `comment` = '$comment' WHERE `kodSekolah` = '$kodSekolah2'");
  header("location:main4.php?kodSekolah=$kodSekolah2");
}

if (isset($_POST['submit3'])) {
  $mysqli->query ("SELECT * FROM dataJudul WHERE WHERE judul LIKE '%$judul%' AND jenisAliran = '$jenisAliran'");
  header("location:main3.php?kodSekolah=$kodSekolah2&judul=$judul&jenisAliran=$jenisAliran");
}

$a = 1;
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>mySPBT 2.0 | Dashboard</title>
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
  <link rel="stylesheet" href="styleSearchJudul.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Fugaz+One&family=Titan+One&display=swap" rel="stylesheet">
  <!-- chart.js plugin -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<!-- Begin salary modal -->
<div class="modal fade" id="delJudulModal">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h4 class="modal-title">Pengesahan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="dash2"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <!-- End salary modal -->
  <!-- Begin salary modal -->
  <div class="modal fade" id="editJudulModal">
    <div class="modal-dialog">
      <div class="modal-content bg-light">
        <div class="modal-header">
          <h4 class="modal-title">Kemaskini Rekod (Bilangan Stok)</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="dash4"></div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- End salary modal -->
    <!-- Begin salary modal -->
    <div class="modal fade" id="judulModal">
      <div class="modal-dialog">
        <div class="modal-content bg-light">
          <div class="modal-header">
            <h4 class="modal-title">Kemaskini bilangan Stok</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="dash3"></div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- End salary modal -->
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
                <a href="indexBOSS/index.php" class="nav-link">Halaman utama</a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link"></a>
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

              <!-- Exit -->
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="indexBOSS/index.php">
                  <i class="far fa-times-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <div class="dropdown-divider"></div>
                  <a href="../logout.php" class="dropdown-item dropdown-footer">Logout</a>
                </div>
              </li>

            </ul>
          </nav>
          <!-- /.navbar -->

          <!-- Main Sidebar Container -->
          <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="indexBOSS/index.php" class="brand-link">
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
            <a href="indexBOSS/index.php" class="nav-link active">
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
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Semakan semula
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
          <h1 class="m-0 text-dark" style="font-family: 'Fugaz One', cursive;">mySPBT 2.0 System Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="indexBOSS/index.php">Halaman utama</a></li>
            <li class="breadcrumb-item active">mySPBT 2.0 | Pengesanan Stok</li>
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
          <h2 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">BORANG PENGURUSAN MAKLUMAT STOK</h2>
          <h4 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Sila lengkapkan semua maklumat berikut sebelum membuat pengisian maklumat stok buku teks</h4>
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
          <?php if($dataSekolah > 0) {?>
            <div class="table-responsive">
             <form method="post" action="main3.php">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">MAKLUMAT SEKOLAH</h4></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      Nama Sekolah: <u><?php echo $dataSekolah['namaSekolah'];?></u>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Kod Sekolah: <u><?php echo $dataSekolah['kodSekolah'];?></u>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Kategori: <u><?php echo $dataSekolah['kategori'];?></u>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Daerah: <u><?php echo $dataSekolah['daerah'];?></u>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Negeri: <u><?php echo $dataSekolah['negeri'];?></u>
                    </td>
                  </tr>
                  <tr>
                   <td>
                    No. Telefon Pejabat: <u><?php echo $dataSekolah['noTelefon'];?></u>
                  </td>
                </tr>

                <tr>
                  <th colspan="3" style="text-align: center; background-color: black;"><h4 style="color: white">KEMASKINI MAKLUMAT STOK</h4></th>
                </tr>

                <tr>

                  <td>
                   <div class="form-group">
                    1. Taip Judul: 
                    <input type="text" name="judul" placeholder="Taip kata kunci judul untuk carian pantas.." class="form-control" >
                    2. Pilih Jenis Sekolah:
                    <div class="input-group mb-3">
                     <select name="jenisAliran" class="custom-select browser-default">
                      <option value="" selected>Jenis sekolah..</option>
                      <option value="SR">SEKOLAH RENDAH</option>
                      <option value="SM">SEKOLAH MENENGAH</option>
                      <option value="PERALIHAN">PERALIHAN</option>
                      <option value="SJKC">SJKC</option>
                      <option value="SJKT">SJKT</option>
                    </select>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="kodSekolah" value="<?php echo $dataSekolah['kodSekolah'];?>">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit3" value="Carian judul"/>
          </div>
        </form>

      </div>
      <?php ;}else {echo 'Tiada dalam rekod';}?>

      <?php if($dataJudul2 > 0) {?>
        <div class="table-responsive">
          <table id="example1" class="table table-sm">
            <thead>
              <tr>
                <th>Bil</th>
                <th>Judul</th>
                <th>Tahun/Tingkatan</th>
                <th>Jenis Sekolah</th>
              </tr>
            </thead>
            <tbody>
              <?php do {?>
                <tr>
                  <td><?php echo $a++;?></td>
                  <td><a class="badge badge-info" data-toggle="modal" data-target="#judulModal" data-whatever3="<?php echo $dataJudul2['kodJudul'];?>" data-whatever4="<?php echo $dataSekolah['kodSekolah'];?>"class="nav-link"><?php echo $dataJudul2['judul']; ?></a></td>
                  <td><?php echo $dataJudul2['darjahTingkatan']; ?></td>
                  <td><?php echo $dataJudul2['jenisAliran']; ?></td>
                </tr>
              <?php } while ($dataJudul2 = mysqli_fetch_assoc($Recordset6)); ?>
            </tbody>
          </table>
        </div>
        <?php ;} else {echo '<div class="btn btn-outline-danger btn-lg btn-block">Tiada padanan yang sesuai,Sila buat carian judul</div>';}?>

        <?php if($rekodPemantauan > 0) {?>
          <div class="table-responsive">

            <table class="table table-sm">
              <thead>
                <tr>
                  <th colspan="8" style="text-align: center; background-color: black"><h4 style="color: white">MAKLUMAT STOK BOS/BOSD</h4></th>
                </tr>
                <tr>
                  <th>Bil</th>
                  <th>Judul</th>
                  <th>Naskhah (rosak-BOSS)</th>
                  <th>Naskhah (rosak-murid)</th>
                  <th>Naskhah (elok)</th>
                  <th>Stok (lebihan)</th>
                  <th>Hapus</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php do {?>
                  <tr>
                    <td><?php echo $a++;?></td>
                    <td><?php echo strtoupper($rekodPemantauan['judul']);?></td>
                    <td><?php echo $rekodPemantauan['bukuRosak'];?></td>
                    <td><?php echo $rekodPemantauan['bukuRosakMurid'];?></td>
                    <td><?php echo $rekodPemantauan['bukuLebihan'];?></td>
                    <td><?php if($rekodPemantauan['bukuStok'] > 0){echo $rekodPemantauan["bukuStok"];}else echo '<i class="fas fa-check-circle"></i>';?></td>
                    <td><a data-toggle="modal" data-target="#delJudulModal" data-whatever="<?php echo $rekodPemantauan['id'];?>" data-whatever2="<?php echo $rekodPemantauan['kodSekolah'];?>"class="nav-link"><i class="fas fa-times"></i></a></td>
                    <td><a data-toggle="modal" data-target="#editJudulModal" data-whatever5="<?php echo $rekodPemantauan['id'];?>" data-whatever6="<?php echo $rekodPemantauan['kodSekolah'];?>"class="nav-link"><i class="fas fa-edit"></i></a></td>
                  </tr>
                <?php } while ($rekodPemantauan = mysqli_fetch_assoc($Recordset4)); ?>
                <form method="post" action="main3.php" role="form" enctype="multipart/form-data">
                  <tr>
                    <th colspan="8" style="text-align: center; background-color: black"><h4 style="color: white">REKOD PENGURUSAN</h4></th>
                  </tr>
                  <tr>
                    <td colspan="8">
                      <div class="form-group">
                        Nama Guru Penyelaras SPBT:
                        <div class="input-group mb-3">
                          <input type="text" name="namaPenyelaras" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSekolah['nama']);?>" style="text-transform: uppercase;" required>
                          <div class="input-group-append input-group-text">
                            <span class="fas fa-id-card-alt"></span>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="8">
                      <div class="form-group">
                        No. Telefon Bimbit:
                        <div class="input-group mb-3">
                          <input type="text" name="noHP" class="form-control"  id="validationDefault01" value="<?php echo $dataSekolah['noHP'];?>" required>
                          <div class="input-group-append input-group-text">
                            <span class="fas fa-id-card-alt"></span>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="8">
                      <div class="form-group">
                        Enrolmen keseluruhan murid:
                        <div class="input-group mb-3">
                          <input type="text" name="enrolmen" class="form-control"  id="validationDefault01" value="<?php echo $dataSekolah['enrolmen'];?>" required>
                          <input type="hidden" name="remark" class="form-control"  id="validationDefault01" value="observe" >
                          <input type="hidden" name="tarikhPemantauan" class="form-control"  id="validationDefault01" value="<?php echo $datePHP;?>" >
                          <div class="input-group-append input-group-text">
                            <span class="fas fa-id-card-alt"></span>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="8">
                      <div class="form-group">
                        Cadangan/Ulasan:

                        <textarea name="comment" class="form-control" id="validationDefault01"  rows="3" placeholder="<?php echo $dataSekolah['comment'];?>"></textarea>

                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <input type="hidden" name="kodSekolah" value="<?php echo $dataSekolah['kodSekolah'];?>">
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary" name="submit2" value="Simpan rekod"/>
              </div>
            </form>
          </div>
          <?php ;}?>

          <?php if($rekodPemantauan2 > 0) {?>
            <div class="table-responsive">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th colspan="6" style="text-align: center; background-color: black"><h4 style="color: white">MAKLUMAT STOK BOS/BOSD</h4></th>
                  </tr>
                  <tr>
                    <th>Bil</th>
                    <th>Judul</th>
                    <th>Bil Naskhah (Rosak)</th>
                    <th>Bil Naskhah (Elok)</th>
                    <th>Hapus</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php do {?>
                    <tr>
                      <td><?php echo $a++;?></td>
                      <td><?php echo strtoupper($rekodPemantauan2['judul']);?></td>
                      <td><?php echo $rekodPemantauan2['bukuRosak'];?></td>
                      <td><?php echo $rekodPemantauan2['bukuLebihan'];?></td>
                      <td><a data-toggle="modal" data-target="#delJudulModal" data-whatever="<?php echo $rekodPemantauan2['id'];?>" data-whatever2="<?php echo $rekodPemantauan2['kodSekolah'];?>"class="nav-link"><i class="fas fa-times"></i></a></td>
                      <td><a data-toggle="modal" data-target="#editJudulModal" data-whatever5="<?php echo $rekodPemantauan2['id'];?>" data-whatever6="<?php echo $rekodPemantauan2['kodSekolah'];?>"class="nav-link"><i class="fas fa-edit"></i></a></td>
                    </tr>
                  <?php } while ($rekodPemantauan2 = mysqli_fetch_assoc($Recordset7)); ?>
                  <form method="post" action="main3.php" role="form" enctype="multipart/form-data">
                    <tr>
                      <th colspan="6" style="text-align: center; background-color: black"><h4 style="color: white">REKOD PENGURUSAN</h4></th>
                    </tr>
                    <tr>
                      <td colspan="6">
                        <div class="form-group">
                          Nama Guru Penyelaras SPBT:
                          <div class="input-group mb-3">
                            <input type="text" name="namaPenyelaras" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($row_Recordset['nama']);?>" style="text-transform: uppercase;" required>
                            <div class="input-group-append input-group-text">
                              <span class="fas fa-id-card-alt"></span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="6">
                        <div class="form-group">
                          No. Telefon Bimbit:
                          <div class="input-group mb-3">
                            <input type="text" name="noHP" class="form-control"  id="validationDefault01" value="<?php echo $dataSekolah['noHP'];?>" required>
                            <div class="input-group-append input-group-text">
                              <span class="fas fa-id-card-alt"></span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="6">
                        <div class="form-group">
                          Enrolmen keseluruhan murid:
                          <div class="input-group mb-3">
                            <input type="text" name="enrolmen" class="form-control"  id="validationDefault01" value="<?php echo $dataSekolah['enrolmen'];?>" required>
                            <input type="hidden" name="remark" class="form-control"  id="validationDefault01" value="observe" >
                            <input type="hidden" name="tarikhPemantauan" class="form-control"  id="validationDefault01" value="<?php echo $datePHP;?>" >
                            <div class="input-group-append input-group-text">
                              <span class="fas fa-id-card-alt"></span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="6">
                        <div class="form-group">
                          Cadangan/Ulasan:

                          <textarea name="comment" class="form-control" id="validationDefault01"  rows="3" placeholder="<?php echo $dataSekolah['comment'];?>"></textarea>

                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <input type="hidden" name="kodSekolah" value="<?php echo $dataSekolah['kodSekolah'];?>">
                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" name="submit2" value="Simpan Rekod"/>
                </div>
              </form>
            </div>
            <?php ;}?>

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
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script>
    /*updatePesananJudul*/
    $('#delJudulModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          //var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'id=' + recipient + '&' + 'kodSekolah=' + recipient2;

          $.ajax({
            type: "GET",
            url: "delJudul.php",
            data: dataString,
            cache: false,
            success: function (data) {
              console.log(data);
              modal.find('.dash2').html(data);
            },
            error: function(err) {
              console.log(err);
            }
          });
        })
      </script>
      <script>
        /*updatePesananJudul*/
        $('#judulModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient3 = button.data('whatever3') // Extract info from data-* attributes
          var recipient4 = button.data('whatever4') // Extract info from data-* attributes
          //var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'kodJudul=' + recipient3 + '&' + 'kodSekolah=' + recipient4;

          $.ajax({
            type: "GET",
            url: "judulModal.php",
            data: dataString,
            cache: false,
            success: function (data) {
              console.log(data);
              modal.find('.dash3').html(data);
            },
            error: function(err) {
              console.log(err);
            }
          });
        })
      </script>
      <script>
        /*updatePesananJudul*/
        $('#editJudulModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient5 = button.data('whatever5') // Extract info from data-* attributes
          var recipient6 = button.data('whatever6') // Extract info from data-* attributes
          //var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'id=' + recipient5 + '&' + 'kodSekolah=' + recipient6;

          $.ajax({
            type: "GET",
            url: "editJudulModal.php",
            data: dataString,
            cache: false,
            success: function (data) {
              console.log(data);
              modal.find('.dash4').html(data);
            },
            error: function(err) {
              console.log(err);
            }
          });
        })
      </script>
      <script type="text/javascript">
            //jQuery extension method:
            jQuery.fn.filterByText = function(textbox) {
              return this.each(function() {
                var select = this;
                var options = [];
                $(select).find('option').each(function() {
                  options.push({
                    value: $(this).val(),
                    text: $(this).text()
                  });
                });
                $(select).data('options', options);

                $(textbox).bind('change keyup', function() {
                  var options = $(select).empty().data('options');
                  var search = $.trim($(this).val());
                  var regex = new RegExp(search, "gi");

                  $.each(options, function(i) {
                    var option = options[i];
                    if (option.text.match(regex) !== null) {
                      $(select).append(
                        $('<option>').text(option.text).val(option.value)
                        );
                    }
                  });
                });
              });
            };

    // You could use it like this:

    $(function() {
      $('select').filterByText($('#carianJudul'));
    });
  </script>
  <script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = document.getElementById("myInput2");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
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
