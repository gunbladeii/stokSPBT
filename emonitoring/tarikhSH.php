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

$Recordset2 = $mysqli->query("SELECT dataSH.namaPembekal, dataSH.negeri,login.colorBar, DAY(dataSH.tarikhBukaSH) AS day1, MONTH(dataSH.tarikhBukaSH) AS month1, YEAR(dataSH.tarikhBukaSH) AS year1,DAY(dataSH.tarikhTutupSH) AS day2, MONTH(dataSH.tarikhTutupSH) AS month2, YEAR(dataSH.tarikhTutupSH) AS year2 FROM dataSH INNER JOIN login ON dataSH.username = login.username ORDER BY dataSH.tarikhBukaSH ASC");
$dataSH = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT dataSH.negeri,login.colorBar,SUM(dataSH.nilaiSH) AS sumnilaiSH FROM dataSH INNER JOIN login ON dataSH.username = login.username GROUP BY dataSH.negeri ORDER BY dataSH.negeri ASC");
$dataSH2 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$a = 1;
?>


<script type="text/javascript">
    google.charts.load('current', {'packages':['timeline']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Negeri');
      data.addColumn('string', 'Pembekal');
      data.addColumn('date', 'Tarikh Buka');
      data.addColumn('date', 'Tarikh Tutup');

      data.addRows([
        <?php do { ?>
        ['<?php echo $dataSH["negeri"];?>', '<?php echo strtoupper($dataSH["namaPembekal"]);?>',    new Date(<?php echo $dataSH["year1"];?>, <?php echo $dataSH["month1"];?>, <?php echo $dataSH["day1"];?>), new Date(<?php echo $dataSH["year2"];?>, <?php echo $dataSH["month2"];?>, <?php echo $dataSH["day2"];?>)],
        <?php } while ($dataSH = mysqli_fetch_assoc($Recordset2));?>
      ]);

      var options = {
        title: "Tempoh Sebut Harga Negeri",
        timeline: {
          groupByRowLabel: true
        }
      };

      var chart = new google.visualization.Timeline(document.getElementById('tarikh_div'));

      chart.draw(data, options);
    }
</script>

<?php if(!empty($dataSH2['negeri'])) { ?>
<h3 style="font-family: 'Roboto Condensed', sans-serif; text-align: center;">Tempoh Proses Sebut Harga Negeri</h3>
<div style="width: 100%;min-height: 500px;" id="tarikh_div"></div>
<?php ;} else echo '<a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Tiada rekod setakat ini</a>';?>