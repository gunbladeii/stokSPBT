<?php require('conn.php'); ?>
<?php session_start();?>
<?php

date_default_timezone_set("asia/kuala_lumpur");
$date = date('d-F-Y');
$datePHP = date('Y-m-d');

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$kodSekolah = $_GET['kodSekolah'];
$jenisAliran = $_GET['jenisAliran'];

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$Recordset2 = $mysqli->query("SELECT login.username,login.nama,login.jawatan,dataSekolah.kodSekolah,dataSekolah.namaSekolah,dataSekolah.daerah,dataSekolah.negeri, dataSekolah.namaPenyelaras,dataSekolah.noTelefon, dataSekolah.noHP,dataSekolah.enrolmen, dataSekolah.comment, dataSekolah.jenisAliran
  FROM login
  INNER JOIN dataSekolah ON login.remark = dataSekolah.kodSekolah 
  WHERE login.remark = '$kodSekolah'");
$dataJudul = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

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
          <h2 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;"><?php echo strtoupper($dataJudul['namaSekolah']);?></h2>
          <h4 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Sila lengkapkan semua maklumat judul berikut</h4>
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
         <div class="table-responsive">  
          <form method="post" id="update_form">
            <div align="center">
              <input type="submit" name="multiple_update" id="multiple_update" class="btn btn-info" value="KEMASKINI" />
            </div>
            <br />
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead align="center">
                  <th width="5%"></th>
                  <th width="10%">Kod Judul</th>
                  <th width="60%">Nama Judul</th>
                  <th width="10%">Harga Seunit</th>
                  <th width="6%">Darjah / Ting.</th>
                  <th width="6%">Buku Rosak ditangan murid</th>
                  <th width="6%">Buku Rosak di BOSS/BOSD</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </form>
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

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
<script>  
  $(document).ready(function(){  

    function fetch_data()
    {
      $.ajax({
        url:"insertJudul2.php?kodSekolah=<?php echo $kodSekolah;?>&jenisAliran=<?php echo $jenisAliran;?>",
        method:"POST",
        dataType:"json",
        success:function(data)
        {
          var html = '';
          for(var count = 0; count < data.length; count++)
          {
            html += '<tr align="center">';
            html += '<td><input type="checkbox" id="'+data[count].id+'" data-kodjudul="'+data[count].kodjudul+'" data-namajudul="'+data[count].namajudul+'" data-darjahtingkatan="'+data[count].darjahtingkatan+'" data-bukurosakmurid="'+data[count].bukurosakmurid+'" data-bukurosak="'+data[count].bukurosak+'" data-harga="'+data[count].harga+'" data-jumlahrosak="'+data[count].jumlahrosak+'" data-kosrosak="'+data[count].kosrosak+'" class="check_box"  /></td>';
            html += '<td align="left">'+data[count].kodjudul+'</td>';
            html += '<td align="left">'+data[count].namajudul+'</td>';
            html += '<td align="left">'+data[count].harga+'</td>';
            html += '<td align="left">'+data[count].darjahtingkatan+'</td>';
            html += '<td></td>';
            html += '<td></td></tr>';
          }
          $('tbody').html(html);
        }
      });
    }

    fetch_data();

    $(document).on('click', '.check_box', function(){
      var html = '';
      if(this.checked)
      {
        html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-kodjudul="'+$(this).data('kodjudul')+'" data-namajudul="'+$(this).data('namajudul')+'" data-darjahtingkatan="'+$(this).data('darjahtingkatan')+'" data-bukurosakmurid="'+$(this).data('bukurosakmurid')+'" data-bukurosak="'+$(this).data('bukurosak')+'" data-harga="'+$(this).data('harga')+'" data-jumlahrosak="'+$(this).data('jumlahrosak')+'" data-hargarosak="'+$(this).data('hargarosak')+'" class="check_box" checked /></td>';
        html += '<td align="left">'+$(this).data('kodjudul')+'</td>';
        html += '<td align="left">'+$(this).data('namajudul')+'</td>';
        html += '<td align="left">'+$(this).data('harga')+'</td>';
        html += '<td align="left">'+$(this).data('darjahtingkatan')+'</td>';
        html += '<td width="6%"><input type="text" name="bukurosakmurid[]" class="form-control" value="" /></td>';
        html += '<td width="6%"><input type="text" name="bukurosak[]" class="form-control" value="" /> <input type="hidden" name="hidden_id[]" value="'+$(this).attr('id')+'" /><input type="hidden" name="kodsekolah[]" value="'+$(this).attr('kodsekolah')+'" /><input type="hidden" name="namasekolah[]" value="'+$(this).attr('namasekolah')+'" /></td>';

      }
      else
      {
        html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-kodjudul="'+$(this).data('kodjudul')+'" data-namajudul="'+$(this).data('namajudul')+'" data-darjahtingkatan="'+$(this).data('darjahtingkatan')+'" data-bukurosakmurid="'+$(this).data('bukurosakmurid')+'" data-bukurosak="'+$(this).data('bukurosak')+'" data-jumlahrosak="'+$(this).data('jumlahrosak')+'" data-harga="'+$(this).data('harga')+'" data-harga="'+$(this).data('harga')+'" class="check_box" /></td>';
        html += '<td align="left">'+$(this).data('kodjudul')+'</td>';
        html += '<td align="left">'+$(this).data('namajudul')+'</td>';
        html += '<td align="left">'+$(this).data('harga')+'</td>';
        html += '<td align="left">'+$(this).data('darjahtingkatan')+'</td>';
        html += '<td></td>';
        html += '<td></td>';

      }
      $(this).closest('tr').html(html);
    });

    $('#update_form').on('submit', function(event){
      event.preventDefault();
      if($('.check_box:checked').length > 0)
      {
        $.ajax({
          url:"insertJudul3.php",
          method:"POST",
          data:$(this).serialize(),
          success:function()
          {
            alert('Rekod judul telah dikunci masuk');
            fetch_data();
          }
        })
      }
    });

  });  
</script>
</body>
</html>
