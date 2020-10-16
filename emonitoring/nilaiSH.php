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

$Recordset2 = $mysqli->query("SELECT dataSH.negeri,login.colorBar,SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username GROUP BY dataSH.negeri ORDER BY dataSH.negeri ASC");
$dataSH = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT dataSH.negeri,login.colorBar,SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username GROUP BY dataSH.negeri ORDER BY dataSH.negeri ASC");
$dataSH2 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$a = 1;
?>


<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', 'Nilai(RM)', { role: 'style' }],
          <?php do { ?>
          ['<?php echo $dataSH["negeri"];?>',  <?php echo $dataSH["sumnilaiSH"];?>, '<?php echo $dataSH["colorBar"];?>'],
          <?php } while ($dataSH = mysqli_fetch_assoc($Recordset2));?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options = {
        title: "Nilai Perolehan Sebut Harga setiap negeri",
        width: 1600,
        height: 600,
        bar: {groupWidth: "85%"},
        legend: { position: "none" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("nilai_div"));
        chart.draw(view, options);
      }
</script>

<?php if(!empty($dataSH2['negeri'])) { ?>
<div id="nilai_div" style="width: 100%; height: 100%;"></div>
<?php ;} else echo '<a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Tiada rekod setakat ini</a>';?>