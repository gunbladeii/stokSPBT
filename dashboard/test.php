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
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-90680653-2');
  </script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Twitter -->
    <!-- <meta name="twitter:site" content="@bootstrapdash">
    <meta name="twitter:creator" content="@bootstrapdash">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->

    <!-- Facebook -->
    <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
    <meta property="og:title" content="Azia">
    <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

    <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> -->

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>mySPBT 2.0 | Dashboard</title>

    <!-- vendor css -->
    <link href="lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <!-- azia CSS -->
    <link rel="stylesheet" href="css/azia.css">

  </head>
  <body>



    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title"><em>Dashboard</em> &nbsp Pemantauan BOSD/BOSS</h2>
              <p class="az-dashboard-text">MySPBT - Stok Buku Teks KPM</p>
            </div>

          </div><!-- az-dashboard-one-title -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-7 ht-lg-100p">
              <div class="card card-dashboard-one">
                <div class="card-header">
                  <div>
                    <h6 class="card-title">Status Pemantauan BOSS Seluruh Negara</h6>
                    <p class="card-text">(Kemaskini sehingga <?php echo $date.' '.$time;?>)</p>
                  </div>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="card-body-top">
                    <div class="container px-5 py-5"> 
                     <div class="row" id="dashboard"></div>
                   </div>
                 </div><!-- card-body-top -->
               </div><!-- card-body -->
             </div><!-- card -->
           </div><!-- col -->
           <div class="col-lg-5 mg-t-20 mg-lg-t-0">
            <div class="row row-sm">
              <div class="col-sm-6">
                <div class="card card-dashboard-two">
                  <div class="card-header">
                    <h6>33.50% <i class="icon ion-md-trending-up tx-success"></i> <small>18.02%</small></h6>
                    <p>Bounce Rate</p>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="chart-wrapper">
                      <div id="flotChart1" class="flot-chart"></div>
                    </div><!-- chart-wrapper -->
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col -->
              <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                <div class="card card-dashboard-two">
                  <div class="card-header">
                    <h6>86k <i class="icon ion-md-trending-down tx-danger"></i> <small>0.86%</small></h6>
                    <p>Total Users</p>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="chart-wrapper">
                      <div id="flotChart2" class="flot-chart"></div>
                    </div><!-- chart-wrapper -->
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col -->
              <div class="col-lg-12 mg-t-20">
                <div class="card card-dashboard-three">
                  <div class="card-header">
                    <p>All Sessions</p>
                    <h6>16,869 <small class="tx-success"><i class="icon ion-md-arrow-up"></i> 2.87%</small></h6>
                    <small>The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc.</small>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="chart"><canvas id="chartBar5"></canvas></div>
                  </div>
                </div>
              </div>
            </div><!-- row -->
          </div><!--col -->
        </div><!-- row -->

        <div class="row row-sm mg-b-20">
          <div class="col-lg-4">
            <div class="card card-dashboard-pageviews">
              <div class="card-header">
                <h6 class="card-title">Page Views by Page Title</h6>
                <p class="card-text">This report is based on 100% of sessions.</p>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="az-list-item">
                  <div>
                    <h6>Admin Home</h6>
                    <span>/demo/admin/index.html</span>
                  </div>
                  <div>
                    <h6 class="tx-primary">7,755</h6>
                    <span>31.74% (-100.00%)</span>
                  </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                  <div>
                    <h6>Form Elements</h6>
                    <span>/demo/admin/forms.html</span>
                  </div>
                  <div>
                    <h6 class="tx-primary">5,215</h6>
                    <span>28.53% (-100.00%)</span>
                  </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                  <div>
                    <h6>Utilities</h6>
                    <span>/demo/admin/util.html</span>
                  </div>
                  <div>
                    <h6 class="tx-primary">4,848</h6>
                    <span>25.35% (-100.00%)</span>
                  </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                  <div>
                    <h6>Form Validation</h6>
                    <span>/demo/admin/validation.html</span>
                  </div>
                  <div>
                    <h6 class="tx-primary">3,275</h6>
                    <span>23.17% (-100.00%)</span>
                  </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                  <div>
                    <h6>Modals</h6>
                    <span>/demo/admin/modals.html</span>
                  </div>
                  <div>
                    <h6 class="tx-primary">3,003</h6>
                    <span>22.21% (-100.00%)</span>
                  </div>
                </div><!-- list-group-item -->
              </div><!-- card-body -->
            </div><!-- card -->

          </div><!-- col -->
          <div class="col-lg-8 mg-t-20 mg-lg-t-0">
            <div class="card card-dashboard-four">
              <div class="card-header">
                <h6 class="card-title">Sessions by Channel</h6>
              </div><!-- card-header -->
              <div class="card-body row">
                <div class="col-md-6 d-flex align-items-center">
                  <div class="chart"><canvas id="chartDonut"></canvas></div>
                </div><!-- col -->
                <div class="col-md-6 col-lg-5 mg-lg-l-auto mg-t-20 mg-md-t-0">
                  <div class="az-traffic-detail-item">
                    <div>
                      <span>Organic Search</span>
                      <span>1,320 <span>(25%)</span></span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-purple wd-25p" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><!-- progress -->
                  </div>
                  <div class="az-traffic-detail-item">
                    <div>
                      <span>Email</span>
                      <span>987 <span>(20%)</span></span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-primary wd-20p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><!-- progress -->
                  </div>
                  <div class="az-traffic-detail-item">
                    <div>
                      <span>Referral</span>
                      <span>2,010 <span>(30%)</span></span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-info wd-30p" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><!-- progress -->
                  </div>
                  <div class="az-traffic-detail-item">
                    <div>
                      <span>Social</span>
                      <span>654 <span>(15%)</span></span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-teal wd-15p" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><!-- progress -->
                  </div>
                  <div class="az-traffic-detail-item">
                    <div>
                      <span>Other</span>
                      <span>400 <span>(10%)</span></span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-gray-500 wd-10p" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><!-- progress -->
                  </div>
                </div><!-- col -->
              </div><!-- card-body -->
            </div><!-- card-dashboard-four -->
          </div><!-- col -->
        </div><!-- row -->

        <div class="row row-sm mg-b-20 mg-lg-b-0">
          <div class="col-lg-5 col-xl-4">
            <div class="row row-sm">
              <div class="col-md-6 col-lg-12 mg-b-20 mg-md-b-0 mg-lg-b-20">
                <div class="card card-dashboard-five">
                  <div class="card-header">
                    <h6 class="card-title">Acquisition</h6>
                    <span class="card-text">Tells you where your visitors originated from, such as search engines, social networks or website referrals.</span>
                  </div><!-- card-header -->
                  <div class="card-body row row-sm">
                    <div class="col-6 d-sm-flex align-items-center">
                      <div class="card-chart bg-primary">
                        <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 20, "height": 20 }'>6,4,7,5,7</span>
                      </div>
                      <div>
                        <label>Bounce Rate</label>
                        <h4>33.50%</h4>
                      </div>
                    </div><!-- col -->
                    <div class="col-6 d-sm-flex align-items-center">
                      <div class="card-chart bg-purple">
                        <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 21, "height": 20 }'>7,4,5,7,2</span>
                      </div>
                      <div>
                        <label>Sessions</label>
                        <h4>9,065</h4>
                      </div>
                    </div><!-- col -->
                  </div><!-- card-body -->
                </div><!-- card-dashboard-five -->
              </div><!-- col -->
              <div class="col-md-6 col-lg-12">
                <div class="card card-dashboard-five">
                  <div class="card-header">
                    <h6 class="card-title">Sessions</h6>
                    <span class="card-text"> A session is the period time a user is actively engaged with your website, app, etc.</span>
                  </div><!-- card-header -->
                  <div class="card-body row row-sm">
                    <div class="col-6 d-sm-flex align-items-center">
                      <div class="mg-b-10 mg-sm-b-0 mg-sm-r-10">
                        <span class="peity-donut" data-peity='{ "fill": ["#007bff", "#cad0e8"],  "innerRadius": 14, "radius": 20 }'>4/7</span>
                      </div>
                      <div>
                        <label>% New Sessions</label>
                        <h4>26.80%</h4>
                      </div>
                    </div><!-- col -->
                    <div class="col-6 d-sm-flex align-items-center">
                      <div class="mg-b-10 mg-sm-b-0 mg-sm-r-10">
                        <span class="peity-donut" data-peity='{ "fill": ["#00cccc", "#cad0e8"],  "innerRadius": 14, "radius": 20 }'>2/7</span>
                      </div>
                      <div>
                        <label>Pages/Session</label>
                        <h4>1,005</h4>
                      </div>
                    </div><!-- col -->
                  </div><!-- card-body -->
                </div><!-- card-dashboard-five -->
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- col-lg-3 -->
          <div class="col-lg-7 col-xl-8 mg-t-20 mg-lg-t-0">
            <div class="card card-table-one">
              <h6 class="card-title">What pages do your users visit</h6>
              <p class="az-content-text mg-b-20">Part of this date range occurs before the new users metric had been calculated, so the old users metric is displayed.</p>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="wd-5p">&nbsp;</th>
                      <th class="wd-45p">Country</th>
                      <th>Entrances</th>
                      <th>Bounce Rate</th>
                      <th>Exits</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><i class="flag-icon flag-icon-us flag-icon-squared"></i></td>
                      <td><strong>United States</strong></td>
                      <td><strong>134</strong> (1.51%)</td>
                      <td>33.58%</td>
                      <td>15.47%</td>
                    </tr>
                    <tr>
                      <td><i class="flag-icon flag-icon-gb flag-icon-squared"></i></td>
                      <td><strong>United Kingdom</strong></td>
                      <td><strong>290</strong> (3.30%)</td>
                      <td>9.22%</td>
                      <td>7.99%</td>
                    </tr>
                    <tr>
                      <td><i class="flag-icon flag-icon-in flag-icon-squared"></i></td>
                      <td><strong>India</strong></td>
                      <td><strong>250</strong> (3.00%)</td>
                      <td>20.75%</td>
                      <td>2.40%</td>
                    </tr>
                    <tr>
                      <td><i class="flag-icon flag-icon-ca flag-icon-squared"></i></td>
                      <td><strong>Canada</strong></td>
                      <td><strong>216</strong> (2.79%)</td>
                      <td>32.07%</td>
                      <td>15.09%</td>
                    </tr>
                    <tr>
                      <td><i class="flag-icon flag-icon-fr flag-icon-squared"></i></td>
                      <td><strong>France</strong></td>
                      <td><strong>216</strong> (2.79%)</td>
                      <td>32.07%</td>
                      <td>15.09%</td>
                    </tr>
                    <tr>
                      <td><i class="flag-icon flag-icon-ph flag-icon-squared"></i></td>
                      <td><strong>Philippines</strong></td>
                      <td><strong>197</strong> (2.12%)</td>
                      <td>32.07%</td>
                      <td>15.09%</td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- card -->
          </div><!-- col-lg -->

        </div><!-- row -->
      </div><!-- az-content-body -->
    </div>
  </div><!-- az-content -->

  <div class="az-footer ht-40">
    <div class="container ht-100p pd-t-0-f">
      <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
      <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
    </div><!-- container -->
  </div><!-- az-footer -->


  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/ionicons/ionicons.js"></script>
  <script src="lib/jquery.flot/jquery.flot.js"></script>
  <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
  <script src="lib/chart.js/Chart.bundle.min.js"></script>
  <script src="lib/peity/jquery.peity.min.js"></script>

  <script src="js/azia.js"></script>
  <script src="js/chart.flot.sampledata.js"></script>
  <script src="js/dashboard.sampledata.js"></script>
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  
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
  <script>
    $(function(){
      'use strict'

      var plot = $.plot('#flotChart', [{
        data: flotSampleData3,
        color: '#007bff',
        lines: {
          fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
        }
      },{
        data: flotSampleData4,
        color: '#560bd0',
        lines: {
          fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
        }
      }], {
       series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 8
      },
      yaxis: {
        show: true,
        min: 0,
        max: 100,
        ticks: [[0,''],[20,'20K'],[40,'40K'],[60,'60K'],[80,'80K']],
        tickColor: '#eee'
      },
      xaxis: {
        show: true,
        color: '#fff',
        ticks: [[25,'OCT 21'],[75,'OCT 22'],[100,'OCT 23'],[125,'OCT 24']],
      }
    });

      $.plot('#flotChart1', [{
        data: dashData2,
        color: '#00cccc'
      }], {
       series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 2,
          fill: true,
          fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] }
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 35
      },
      xaxis: {
        show: false,
        max: 50
      }
    });

      $.plot('#flotChart2', [{
        data: dashData2,
        color: '#007bff'
      }], {
       series: {
        shadowSize: 0,
        bars: {
          show: true,
          lineWidth: 0,
          fill: 1,
          barWidth: .5
        }
      },
      grid: {
        borderWidth: 0,
        labelMargin: 0
      },
      yaxis: {
        show: false,
        min: 0,
        max: 35
      },
      xaxis: {
        show: false,
        max: 20
      }
    });


        //-------------------------------------------------------------//


        // Line chart
        $('.peity-line').peity('line');

        // Bar charts
        $('.peity-bar').peity('bar');

        // Bar charts
        $('.peity-donut').peity('donut');

        var ctx5 = document.getElementById('chartBar5').getContext('2d');
        new Chart(ctx5, {
          type: 'bar',
          data: {
            labels: [0,1,2,3,4,5,6,7],
            datasets: [{
              data: [2, 4, 10, 20, 45, 40, 35, 18],
              backgroundColor: '#560bd0'
            }, {
              data: [3, 6, 15, 35, 50, 45, 35, 25],
              backgroundColor: '#cad0e8'
            }]
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              enabled: false
            },
            legend: {
              display: false,
              labels: {
                display: false
              }
            },
            scales: {
              yAxes: [{
                display: false,
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                  max: 80
                }
              }],
              xAxes: [{
                barPercentage: 0.6,
                gridLines: {
                  color: 'rgba(0,0,0,0.08)'
                },
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                  display: false
                }
              }]
            }
          }
        });

        // Donut Chart
        var datapie = {
          labels: ['Search', 'Email', 'Referral', 'Social', 'Other'],
          datasets: [{
            data: [25,20,30,15,10],
            backgroundColor: ['#6f42c1', '#007bff','#17a2b8','#00cccc','#adb2bd']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };

        // For a doughnut chart
        var ctxpie= document.getElementById('chartDonut');
        var myPieChart6 = new Chart(ctxpie, {
          type: 'doughnut',
          data: datapie,
          options: optionpie
        });

      });
    </script>
  </body>
  </html>
