<?php session_start();?>
<?php
    require('conn.php');

      $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
      function fill_unit_select_box($connect)
      { 
       $output = '';
       $query = "SELECT * FROM dataSHJudul ORDER BY judul ASC";
       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $output .= '<option value="'.$row["judul"].'">'.$row["judul"].'</option>';
       }
       return $output;
      }
    
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $id = $_GET['id'];
    

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE username = '$username2'");
    $dataSH = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

    <!-- Begin updateDataSH Modal -->
      <div class="modal fade" id="daftarJudulSHModal">
        <div class="modal-dialog">
          <div class="modal-content bg-light">
            <div class="modal-header">
              <h4 class="modal-title">Rekod Pemantauan Pembekalan Mengikut Judul</h4>
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
    <!-- End updateDataSH Modal -->

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
        <a href="indexNegeri/index.php" class="nav-link">Home</a>
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
                <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">MAKLUMAT PENGESANAN SH-NEGERI</h3>
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
                         
                  <div class="container">
                   <form method="post" id="insert_form">
                    <div class="table-repsonsive">
                     <span id="error"></span>
                     <table class="table table-bordered" id="item_table">
                      <tr>
                       <th>Pilih Judul</th>
                       <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
                      </tr>
                     </table>
                     <div align="center">
                      <input type="submit" name="submit" class="btn btn-info" value="Simpan Data" />
                     </div>
                    </div>
                   </form>
                  </div>
                <!-- /.table-responsive -->
                  </div>
                </div>
              </div>

                        <script>
                        $(document).ready(function(){
                         
                         $(document).on('click', '.add', function(){
                          var html = '';
                          html += '<tr>';
                          html += '<td><input type="hidden" name="id_Penerbit[]" class="form-control id_Penerbit" value="'<?php echo $dataSH['id'];?>'"><select name="judul[]" class="form-control judul"><option value="">Select Unit</option><?php echo fill_unit_select_box($connect); ?></select></td>';
                          html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
                          $('#item_table').append(html);
                         });
                         
                         $(document).on('click', '.remove', function(){
                          $(this).closest('tr').remove();
                         });
                         
                         $('#insert_form').on('submit', function(event){
                          event.preventDefault();
                          var error = '';
                          
                          
                          $('.judul').each(function(){
                           var count = 1;
                           if($(this).val() == '')
                           {
                            error += "<p>Sila masukkan maklumat judul di lajur "+count+" </p>";
                            return false;
                           }
                           count = count + 1;
                          });
                          var form_data = $(this).serialize();
                          if(error == '')
                          {
                           $.ajax({
                            url:"insertJudulSH.php",
                            method:"POST",
                            data:form_data,
                            success:function(data)
                            {
                             if(data == 'ok')
                             {
                              $('#item_table').find("tr:gt(0)").remove();
                              $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                             }
                            }
                           });
                          }
                          else
                          {
                           $('#error').html('<div class="alert alert-danger">'+error+'</div>');
                          }
                         });
                         
                        });
                        </script>

                     
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
</body>
</html>
