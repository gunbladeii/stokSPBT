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

$namaSekolah = $_POST['namaSekolah'];
if (isset($_POST['submit'])) {
    $mysqli->query ("SELECT * FROM dataSekolah WHERE namaSekolah LIKE '$namaSekolah'");
    header("location:searching.php?namaSekolah=$namaSekolah");
    }
$a = 1;
?>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', 'Nilai(RM)', { role: 'style' }],
          ['Sabah',  21655, '#b87333'],
          ['Sarawak',  134500, 'silver'],
          ['WP Labuan',  215000, 'gold'],
          ['WP Kuala Lumpur',  139000, '#65eb34'],
          ['Kedah',  14000, '#eb34dc'],
          ['Perlis',  219000, '#eb3493'],
          ['Pulau Pinang',  34000, '#8034eb'],
          ['Melaka',  13901, '#5c34eb'],
          ['Selangor',  145000, '#5c34eb'],
          ['Perak',  150000, '#6c6096'],
          ['Negeri Sembilan',  230000, '#609196'],
          ['Pahang',  254000, '#609692'],
          ['Kelantan',  415000, '#609689'],
          ['Terengganu',  23000, '#609676'],
          ['Johor',  111000, '#609662'],
          ['WP Putrajaya',  13126, '#ae34eb']
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options = {
        title: "Perolehan Sebut Harga setiap negeri",
        width: 1800,
        height: 600,
        bar: {groupWidth: "85%"},
        legend: { position: "none" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
        chart.draw(view, options);
      }
</script>

<div id="chart_div" style="width: 100%; height: 100%;"></div>