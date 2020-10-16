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


$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$Recordset2 = $mysqli->query("SELECT login.latitude,login.longitude,dataSH.namaPembekal, dataSH.negeri,login.colorBar, SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username GROUP BY dataSH.negeri ORDER BY dataSH.negeri ASC");
$dataSH = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT dataSH.negeri,login.colorBar,SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username GROUP BY dataSH.negeri ORDER BY dataSH.negeri ASC");
$dataSH2 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$a = 1;
?>


<script type="text/javascript">
   google.charts.load('current', {
       'packages': ['geochart'],
       // Note: you will need to get a mapsApiKey for your project.
       // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
       'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
     });
     google.charts.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['City',   'Nilai(RM)', 'Jumlan buku'],
        ['Jitra',      2761477,    1285],
        ['Negeri Sembilan',     1324110,    181],
        ['Kedah',    959574,     117],
        ['Johor',     907563,     130],
        ['Kelantan',   655875,     158],
        ['Malacca',     607906,     243],
        ['Penang',   380181,     140],
        ['Labuan Federal Territory',  371282,     102],
        ['Federal Territory of Kuala Lumpur', 67370,      213],
        ['Perlis',     52192,      43],
        ['Sabah',  38262,      11]
      ]);

      var options = {
        region: 'MY',
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('mapSH_div'));
      chart.draw(data, options);
    };
</script>

<?php if(!empty($dataSH2['negeri'])) { ?>
<h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif; text-align: center;">Info Sebut Harga Setiap Negeri</h3>
<div style="width: 100%;min-height: 500px;" id="mapSH_div"></div>
<?php ;} else echo '<a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Tiada rekod setakat ini</a>';?>