<?php require('../conn.php'); ?>
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


$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);
$d = 1;
$downloadExcell = $_SERVER['PHP_SELF'];

/*advanced*/
if (isset($_POST["stok"]))
{
  $sql = $mysqli->query("SELECT * FROM eksportExcel");          

  if (mysqli_num_rows($sql) > 0)
  {
    $output .='
    <table class="table" border="1">
    <tr>
    <th>No.</th>
    <th>Kod Sekolah</th>
    <th>Nama Sekolah</th>
    <th>Kategori</th>
    <th>Negeri</th>
    <th>Daerah</th>
    <th>No. Telefon</th>
    <th>Tarikh Lawatan</th>
    <th>Bil.Naskhah(BOSS/BOSD)</th>
    <th>Lebihan(BOSS)</th>
    </tr>   
    ';
    while($row = mysqli_fetch_assoc($sql))
    {
      $output .='
      <tr>
      <td>'.$d++.'</td>
      <td>'.$row["kodSekolah"].'</td>
      <td>'.$row["namaSekolah"].'</td>
      <td>'.$row["kategori"].'</td>
      <td>'.$row["negeri"].'</td>
      <td>'.$row["daerah"].'</td>
      <td>'.$row["noTelefon"].'</td>
      <td>'.$row["tarikhPemantauan"].'</td>
      <td>'.$row["bukuLebihan"].'</td>
      <td>'.$row["bukuStok"].'</td>
      </tr>     
      ';    
    }
    $output .='</table>';
    header("Content-Type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=dataStokMySPBT_".$date.".xls");
    echo $output;

  }
  exit;
}

$Recordset2 = $mysqli->query("SELECT DATE_FORMAT(dataSekolah.tarikhPemantauan, '%d-%m-%y') as tarikhPemantauan, dataSekolah.negeri,dataSekolah.kodSekolah, dataSekolah.namaSekolah, dataSekolah.kategori,CONCAT('RM', FORMAT(SUM(
  CASE 
  WHEN (dataJudul.harga * rekodPemantauan.bukuStok) > 0 AND dataSekolah.kategori = 'BOSS' THEN (dataJudul.harga * rekodPemantauan.bukuStok) 
  WHEN (dataJudul.harga * rekodPemantauan.bukuLebihan) > 0 AND dataSekolah.kategori = 'BOSD' THEN (dataJudul.harga * rekodPemantauan.bukuLebihan)
  ELSE 0 
  END),2)) AS harga
  FROM 
  ((rekodPemantauan
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.remark = 'observe'
  GROUP BY dataSekolah.kodSekolah");
$dataSekolah = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT * FROM dataJudul");
$dataJudul = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$Recordset4 = $mysqli->query("SELECT rekodPemantauan.kodJudul, dataJudul.judul, SUM(rekodPemantauan.bukuLebihan) AS bukuLebihan, SUM(CASE WHEN rekodPemantauan.bukuStok > 0 THEN rekodPemantauan.bukuStok ELSE 0 END) AS bukuStok FROM rekodPemantauan INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul GROUP BY kodJudul");
$rekodPemantauan = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$Recordset5 = $mysqli->query("SELECT dataSekolah.kategori,dataSekolah.negeri, rekodPemantauan.kodJudul,dataJudul.judul, SUM(rekodPemantauan.bukuLebihan) AS bukuLebihan, 
  SUM(
  CASE 
  WHEN dataSekolah.kategori = 'BOSS' AND rekodPemantauan.bukuStok > 0  THEN rekodPemantauan.bukuStok
  WHEN dataSekolah.kategori = 'BOSD' THEN 0   
  ELSE 0 END) AS bukuStok 
  FROM ((rekodPemantauan 
  INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul)
  INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah)
  GROUP BY kodJudul,kategori");
$rekodPemantauan3 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);

if (isset($_POST['submit'])) {
  $mysqli->query ("INSERT INTO `rekodPemantauan` (`kodSekolah`,`namaSekolah`,`kodJudul`,`bukuLebihan`) VALUES ('$kodSekolah2','$namaSekolah','$kodJudul','$bukuLebihan')");
  header("location:main3.php?kodSekolah=$kodSekolah2");
}

if (isset($_POST['delete'])) {
  $mysqli->query ("DELETE t1 FROM rekodPemantauan t1
    INNER  JOIN rekodPemantauan t2
    WHERE
    t1.id < t2.id AND
    t1.kodSekolah = t2.kodSekolah AND
    t1.kodJudul = t2.kodJudul");
  header("location:dashboard.php");
}

$a = 1;
$b = 1;
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
<body>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Halaman utama</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <img src="../emonitoring/img/logo MySPBTdashboard.png" style="width:15%;height:80%" class="rounded mx-auto d-block">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Status Pemantauan BOSS Seluruh Negara</h3>
        <div class="container px-5 py-5"> 
         <div class="row" id="dashboard"></div>
       </div>
       <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Status Pemantauan BOSD Seluruh Negara</h3>
       <div class="container px-5 py-5"> 
         <div class="row" id="dashboard2"></div>
       </div>
     </section>

     <section class="content">

      <nav class="navbar navbar-light bg-light">
        <div class="container-fluid justify-content-start">
          <form action="<?php echo $downloadExcell; ?>" role="form" method="POST" class="well form-horizontal" class="download" enctype="multipart/form-data">
            <button class="btn btn-outline-info me-2" type="submit" name="stok">Export Excel</button>
          </form>
        </div>
      </nav>



      <div id="row">
        <div class="col-md-12">
         <!-- TABLE: list of publisherSPBT -->
         <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Senarai sekolah selesai pemantauan</h3>
            <h2 class="card-title" style="font-size:14px;">(Kemaskini sehingga <?php echo $date.' '.$time;?>)</h2>

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
                <table id="example1" class="table m-0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kod Sekolah</th>
                      <th>Nama Sekolah</th>
                      <th>Kategori</th>
                      <th>Negeri</th>
                      <th>Tarikh Pantau</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php do {?>
                      <tr>
                        <td><?php echo $a++;?></td>
                        <td><a href="#"><span class="badge badge-info"><?php echo strtoupper($dataSekolah['kodSekolah']);?></span></a></td>
                        <td><?php echo $dataSekolah['namaSekolah'];?></td>
                        <td><?php echo $dataSekolah['kategori'];?></td>
                        <td><?php echo strtoupper($dataSekolah['negeri']);?></td>
                        <td><?php echo $dataSekolah['tarikhPemantauan'];?></td>
                      </tr>
                    <?php } while ($dataSekolah = mysqli_fetch_assoc($Recordset2)); ?>
                  </tbody>
                </table>
              </div>
              <?php ;}else {echo 'Tiada rekod sekolah dipantau setakat ini';}?>

              <!-- /.table-responsive -->
            </div>
          </div>
        </div>

        <div id="row">
          <div class="col-md-12">
           <!-- TABLE: list of publisherSPBT -->
           <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif;">Senarai judul yang dipantau</h3>
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
              <?php if($rekodPemantauan3 > 0) {?>
                <div class="table-responsive">
                  <table id="example3" class="table m-0">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kod Judul</th>
                        <th>Nama Judul</th>
                        <th>Lokasi</th>
                        <th>Bil Naskhah (BOSS/BOSD)</th>
                        <th>Lebihan (BOSS)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php do {?>
                        <tr>
                          <td><?php echo $b++;?></td>
                          <td><a href="#"><span class="badge badge-info"><?php echo strtoupper($rekodPemantauan3['kodJudul']);?></span></a></td>
                          <td><?php echo $rekodPemantauan3['judul'];?></td>
                          <td><?php echo $rekodPemantauan3['kategori'];?></td>
                          <td><?php echo $rekodPemantauan3['bukuLebihan'];?></td>
                          <td><?php if($rekodPemantauan3['bukuStok'] > 0){echo $rekodPemantauan3["bukuStok"];}else echo '<i class="fas fa-times"></i>';?></td>
                        </tr>
                      <?php } while ($rekodPemantauan3 = mysqli_fetch_assoc($Recordset5)); ?>
                    </tbody>
                  </table>
                </div>
                <?php ;}else {echo 'Tiada rekod sekolah dipantau setakat ini';}?>

                <!-- /.table-responsive -->
              </div>
            </div>
          </div>
        </section>



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
              $('#dashboard').load('dashboard_view.php')
              $('#dashboard2').load('dashboard_view2.php')
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
<script src="../emonitoring/jquery.dataTables.js"></script>
<script src="../emonitoring/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $("#example3").DataTable();
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
