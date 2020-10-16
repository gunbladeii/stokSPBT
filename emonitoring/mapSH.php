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
   google.charts.load("current", {
        "packages":["map"],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        "mapsApiKey": "AIzaSyDloX9GMN9TNA1bTknKg8fODZPeBZistSw"
      });
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Lat', 'Long', 'Negeri', 'Nilai(RM)'],
          <?php do { ?>
          [<?php echo $dataSH["latitude"];?>, <?php echo $dataSH["longitude"];?>, '<?php echo $dataSH["negeri"];?>', '<?php echo number_format($dataSH["sumnilaiSH"]);?>'],
          <?php } while ($dataSH = mysqli_fetch_assoc($Recordset2));?>
        ]);

        var options = {
          icons: {
            default: {
              normal: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Azure-icon.png',
              selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
            }
          }
        };

        var map = new google.visualization.Map(document.getElementById('mapSH_div'));
        map.draw(data, {
          showTooltip: true,
          showInfoWindow: false,
          useMapTypeControl: false
        });
      }
</script>

<?php if(!empty($dataSH2['negeri'])) { ?>
<h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif; text-align: center;">Info Sebut Harga Setiap Negeri</h3>
<div style="width: 100%;min-height: 500px;" id="mapSH_div"></div>
<?php ;} else echo '<a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Tiada rekod setakat ini</a>';?>