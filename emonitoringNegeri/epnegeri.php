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

$Recordset3 = $mysqli->query("SELECT login.negeri,login.colorBar,SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username WHERE dataSH.username = '$colname_Recordset' GROUP BY dataSH.negeri");
$dataSH2 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

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

<!-- Begin submitDataSH Modal -->
      <div class="modal fade" id="submitDataSHModal">
        <div class="modal-dialog">
          <div class="modal-content bg-light">
            <div class="modal-header">
              <h4 class="modal-title">Daftar Rekod Pengesanan Sebut Harga</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="dash1"></div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    <!-- End submitDataSH Modal -->

<!-- Begin updateDataSH Modal -->
      <div class="modal fade" id="updateDataSHModal">
        <div class="modal-dialog">
          <div class="modal-content bg-light">
            <div class="modal-header">
              <h4 class="modal-title">Kemaskini Rekod Daftar Sebut Harga</h4>
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
    <!-- End updateDataSH Modal -->

    <!-- Begin daftarJudulSH Modal -->
      <div class="modal fade" id="daftarJudulSHModal">
        <div class="modal-dialog">
          <div class="modal-content bg-light">
            <div class="modal-header">
              <h4 class="modal-title">Muat Naik Judul Mengikut Pembekal</h4>
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
    <!-- End daftarJudulSH Modal -->

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
        <a href="indexNegeri/index.php" class="nav-link">mySPBT</a>
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
        <a class="nav-link" data-toggle="dropdown" href="epnegeri.php">
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
    <a href="indexNegeri/index.php" class="brand-link">
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
            <a href="#" class="nav-link">
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
            <p>(*Data berikut dikemaskini sehingga <?php echo $date;?>)</p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="epnegeri.php">Halaman utama</a></li>
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
                <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">MAKLUMAT PENGESANAN SH-NEGERI</h3>
                <h2 class="card-title" style="font-size:14px;">(Dikemaskini pada <?php echo $date.' '.$time;?>)</h2>
                <?php if(!empty($dataSH)){?>
                <h2 class="card-title" style="font-size:14px;">*Gunakan <strong>Kod Pembekal</strong> untuk kegunaan semasa muat naik rekod judul pembekalan penerbit</h2>
                <?php }?>

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
                          <?php if(empty($dataSH)){?>
                            <div class="row" style="margin:0 !important;">
                                  <div class="clearfix"></div>
                                  <div class="col-md-12">
                                  <br/>
                                    <div><span class="btn btn-danger">MOHON MAKLUMKAN PEMBEKAL UNTUK BUAT PENDAFTARAN MELALUI AKSES PEMBEKAL YANG DIBEKALKAN DALAM <strong>MANUAL PENGGUNA (VERSI JPN/JAIN)</strong></span></div>
                                    </div>
                                  <br/>
                           </div>
                          <?php }?>
                          <div class="table-responsive">

                            <?php if(!empty($dataSH)){?>
                              <table id="example1" class="table m-0">
                              <thead>
                                <tr>
                                  <th colspan="7" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">REKOD SEBUT HARGA BERDAFTAR</h4></th>
                                </tr>
                              </thead>
                              <tbody>
                              
                                <tr>
                                  <th>Bil</th>
                                  <th>Nama Pembekal</th>
                                  <th>Kod Pembekal</th>
                                  <th>Nilai Sebut Harga (RM)</th>
                                  <th>Muat Naik Judul</th>
                                  <th>Pantau pembekalan</th>
                                  <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Hapus</button></th>
                                </tr>

                                <?php do {?>
                                <tr>
                                  <td><?php echo $a++;?></td>
                                  <td><a data-toggle="modal" data-target="#updateDataSHModal" data-whatever="<?php echo $dataSH['id'];?>" class="btn btn-info btn-sm active" role="button" aria-pressed="true"><?php echo strtoupper($dataSH['namaPembekal']);?></a></td>
                                  <td><a class="btn btn-danger btn-sm active" role="button" aria-pressed="true"><strong><?php echo $dataSH['kodPembekal'];?></strong></a></td>
                                  <td><?php echo 'RM'.number_format($dataSH['nilaiSH'],2);?></td>
                                  <td><a data-toggle="modal" data-target="#daftarJudulSHModal" data-whatever="<?php echo $dataSH['kodPembekal'];?>" class="btn btn-warning btn-sm active" role="button" aria-pressed="true"><i class="fas fa-sign-in-alt"></i></a></td>
                                  <td><a href="pantauBekalSHModal.php?kodPembekal=<?php echo $dataSH['kodPembekal'];?>" class="btn btn-warning btn-sm active" role="button" aria-pressed="true"><i class="fas fa-wifi"></i></a></td>
                                  <td><input type="checkbox" class="delete_checkbox" value="<?php echo $dataSH['id'];?>" /></td>
                                </tr>
                                <?php } while ($dataSH = mysqli_fetch_assoc($Recordset2));?>

                              </tbody>
                              <tfoot>
                                <tr>
                                    <td colspan="7" align="right"><a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Nilai Sebut Harga: <?php echo 'RM'.number_format($dataSH2['sumnilaiSH'],2);?></a>
                                    </td>
                                </tr>
                              </tfoot>
                             </table>

                            <?php }?>


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

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    $('#submitDataSHModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'username=' + recipient;

            $.ajax({
                type: "GET",
                url: "submitDataSH.php",
                data: dataString,
                cache: false,
                success: function (data) {
                    console.log(data);
                    modal.find('.dash1').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
    })

    $('#updateDataSHModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'id=' + recipient;

            $.ajax({
                type: "GET",
                url: "updateDataSH.php",
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

    $('#daftarJudulSHModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'kodPembekal=' + recipient; //+ '&' + 'negeri=' + recipient2 ;

            $.ajax({
                type: "GET",
                url: "daftarJudulSHModal.php",
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

    $('#pantauBekalSHModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var recipient2 = button.data('whatever2') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'kodPembekal=' + recipient ;//+ '&' + 'negeri=' + recipient2 ;

            $.ajax({
                type: "GET",
                url: "pantauBekalSHModal.php",
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

<style>
.removeRow
{
    background-color: #FF0000;
    color:#FFFFFF;
}
</style>
<script>  
$(document).ready(function(){ 

    $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
            $(this).closest('tr').addClass('removeRow');
        }
        else
        {
            $(this).closest('tr').removeClass('removeRow');
        }
    });

    $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        if(checkbox.length > 0)
        {
            var checkbox_value2 = [];
            $(checkbox).each(function(){
                checkbox_value2.push($(this).val());
            });

            $.ajax({
                url:"deleteJudulSH.php",
                method:"POST",
                data:{checkbox_value2:checkbox_value2},
                success:function()
                {
                    $('.removeRow').fadeOut(1500);
                }
            });
        }
        else
        {
            alert("Pilih salah satu rekod untuk dipadam");
        }
    });

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
