<?php require('conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'admin')
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
$kodJudul = $_POST['kodJudul'];
$comment = $_POST['comment'];


$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
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

if (isset($_POST['submit'])) {
  $mysqli->query ("INSERT INTO `rekodPemantauan` (`kodSekolah`,`namaSekolah`,`kodJudul`,`bukuLebihan`) VALUES ('$kodSekolah2','$namaSekolah','$kodJudul','$bukuLebihan')");
  header("location:main3.php?kodSekolah=$kodSekolah2");
}

if (isset($_POST['submit2'])) {
  $mysqli->query ("UPDATE `dataSekolah` SET `comment` = '$comment' WHERE `kodSekolah` = '$kodSekolah2'");
  header("location:main4.php?kodSekolah=$kodSekolah2");
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
          <a href="main1.php" class="nav-link">Halaman utama</a>
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
          <a class="nav-link" data-toggle="dropdown" href="../main1.php">
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
      <a href="main1.php" class="brand-link">
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
            <a href="main1.php" class="nav-link active">
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
          <h1 class="m-0 text-dark" style="font-family: 'Fugaz One', cursive;">mySPBT 2.0 System Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main1.php">Halaman utama</a></li>
            <li class="breadcrumb-item active">mySPBT 2.0 | Pengesanan Stok</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <div class="modal-footer">
    <input class="btn btn-danger" type="button" id="btnPrint" value="PDF">
  </div>

  <section class="content" id="dvContainer">
    <div id="row">
      <div class="col-md-12">
       <!-- TABLE: list of publisherSPBT -->
       <div class="card">
        <div class="card-header border-transparent">
          <img src="logo_kpm.png" style="display: block; margin-left: auto; margin-right: auto;">
          <h2 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;text-align: center;">BORANG PEMANTAUAN PENGURUSAN MAKLUMAT STOK</h2>
          <h2 class="card-title" style="font-size:14px;text-align: center;">(Dikemaskini pada <?php echo $date.' '.$time;?>)</h2>
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
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th colspan="6" style="text-align: center; background-color: #0d0d0d;"><h5 style="color: white">Maklumat Sekolah</h5></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="6">
                   <a>Nama Sekolah: <u><?php echo $dataSekolah['namaSekolah'];?></u></a>
                 </td>
               </tr>
               <tr>
                <td colspan="6">
                  <a>Kod Sekolah: <u><?php echo $dataSekolah['kodSekolah'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Daerah: <u><?php echo $dataSekolah['daerah'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Negeri: <u><?php echo $dataSekolah['negeri'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>No. Telefon Pejabat: <u><?php echo $dataSekolah['noTelefon'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Nama Guru Penyelaras SPBT: <u><?php echo strtoupper($dataSekolah['namaPenyelaras']);?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>No. Telefon Bimbit: <u><?php echo $dataSekolah['noHP'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Tarikh Pemantauan: <u><?php echo $dataSekolah['tarikhP'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Enrolmen: <u><?php echo $dataSekolah['enrolmen'];?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Nama Pegawai Pemantau: <u><?php echo strtoupper($dataSekolah['namaPegawai1']);?></u></a>
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  <a>Jawatan: <u><?php echo strtoupper($dataSekolah['jawatan1']);?></u></a>
                </td>
              </tr>

              <tr>
                <td colspan="6">
                  Nama Pegawai Pengiring: <u><?php echo strtoupper($dataSekolah['namaPegawai2']);?></u>
                </td>
              </tr>

              <tr>
                <td colspan="6">
                  Jawatan: <u><?php echo strtoupper($dataSekolah['jawatan2']);?></u>
                </td>
              </tr>

              <tr>
                <?php if(!empty($rekodPemantauan)) {?>
                  <th colspan="6" style="text-align: center; background-color: black"><h5 style="color: white">Maklumat Pengurusan Stok Buku Teks</h5></th>
                </tr>
                <tr>
                  <th>Bil</th>
                  <th>Kod judul</th>
                  <th>Judul</th>
                  <th>Naskhah (rosak-BOSS)</th>
                  <th>Naskhah (rosak-Murid)</th>
                  <th>Naskhah (elok)</th>
                  <th>Stok (lebihan)</th>
                </tr>
                <?php do {?>
                  <tr>
                    <td><?php echo $a++;?></td>
                    <td><?php echo strtoupper($rekodPemantauan['kodJudul']);?></td>
                    <td><?php echo strtoupper($rekodPemantauan['judul']);?></td>
                    <td><?php echo $rekodPemantauan['bukuRosak'];?></td>
                    <td><?php echo $rekodPemantauan['bukuRosakMurid'];?></td>
                    <td><?php echo $rekodPemantauan['bukuLebihan'];?></td>
                    <td><?php if($rekodPemantauan['bukuStok'] > 0){echo $rekodPemantauan["bukuStok"];}else echo '<i class="fas fa-check-circle"></i>';?></td>
                  </tr>
                <?php } while ($rekodPemantauan = mysqli_fetch_assoc($Recordset4)); ?>
              <?php }?>

              <?php if(!empty($rekodPemantauan2)) {?>
                <th colspan="6" style="text-align: center; background-color: black"><h5 style="color: white">Maklumat Pengurusan Stok Buku Teks</h5></th>
              </tr>
              <tr>
                <th>Bil</th>
                <th>Kod judul</th>
                <th>Judul</th>
                <th>Bil Naskhah (Rosak)</th>
                <th>Bil Naskhah (Elok)</th>
              </tr>
              <?php do {?>
                <tr>
                  <td><?php echo $a++;?></td>
                  <td><?php echo strtoupper($rekodPemantauan2['kodJudul']);?></td>
                  <td><?php echo strtoupper($rekodPemantauan2['judul']);?></td>
                  <td><?php echo $rekodPemantauan2['bukuRosak'];?></td>
                  <td><?php echo $rekodPemantauan2['bukuLebihan'];?></td>
                </tr>
              <?php } while ($rekodPemantauan2 = mysqli_fetch_assoc($Recordset7)); ?>
            <?php }?>
            <tr>
              <th colspan="6" style="text-align: center; background-color: black"><h5 style="color: white">Ulasan Keseluruhan</h5></th>
            </tr>
            <tr>
              <td colspan="6">
                <div class="form-group">
                  Ulasan:
                  <div class="input-group mb-3">
                    <?php echo "<u>".$dataSekolah['comment']."</u>";?>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="kodSekolah" value="<?php echo $dataSekolah['kodSekolah'];?>">
      </div>


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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
  $("#btnPrint").live("click", function () {
    var divContents = $("#dvContainer").html();
    var printWindow = window.open('', '', 'height=400,width=700');
    printWindow.document.write('<html><head><title>Laporan Pemantauan Stok</title>');
    printWindow.document.write('</head>');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/fontawesome-free/css/all.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/icheck-bootstrap/icheck-bootstrap.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/jqvmap/jqvmap.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/dist/css/adminlte.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/daterangepicker/daterangepicker.css">');
    printWindow.document.write('<link rel="stylesheet" href="../adminSPBT/plugins/summernote/summernote-bs4.css">');
    printWindow.document.write('<link rel="stylesheet" href="styleSearchJudul.css">');
    printWindow.document.write('<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">');
    printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">');
    printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Anton&family=Fugaz+One&family=Titan+One&display=swap" rel="stylesheet">');
    printWindow.document.write('<body>');
    printWindow.document.write(divContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  });
</script>
</html>
