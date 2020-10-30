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

$Recordset2 = $mysqli->query("SELECT login.negeri,login.colorBar,SUM(dataJudulPenerbit.bilnaskhahpesan) AS  bilnaskhahpesan,SUM(dataJudulPenerbit.bilnaskhahbekal) AS  bilnaskhahbekal,
CASE WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) > SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'BELUM SELESAI'
WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) < SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'SEMAK SEMULA'
WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) = SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'SELESAI'
ELSE '' END AS statusbekal,
FORMAT((SUM(dataJudulPenerbit.bilnaskhahbekal)/SUM(dataJudulPenerbit.bilnaskhahpesan))*100,0) AS peratusbekal
  FROM dataJudulPenerbit INNER JOIN login ON dataJudulPenerbit.kodpembekal = login.username GROUP BY login.negeri ORDER BY login.negeri ASC");
$dataJudulPenerbit = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$Recordset3 = $mysqli->query("SELECT login.negeri,login.colorBar,SUM(dataJudulPenerbit.bilnaskhahpesan) AS  bilnaskhahpesan,SUM(dataJudulPenerbit.bilnaskhahbekal) AS  bilnaskhahbekal,
CASE WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) > SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'BELUM SELESAI'
WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) < SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'SEMAK SEMULA'
WHEN SUM(dataJudulPenerbit.bilnaskhahpesan) = SUM(dataJudulPenerbit.bilnaskhahbekal) THEN 'SELESAI'
ELSE '' END AS statusbekal,
FORMAT((SUM(dataJudulPenerbit.bilnaskhahbekal)/SUM(dataJudulPenerbit.bilnaskhahpesan))*100,0) AS peratusbekal
  FROM dataJudulPenerbit INNER JOIN login ON dataJudulPenerbit.kodpembekal = login.username GROUP BY login.negeri ORDER BY login.negeri ASC");
$dataJudulPenerbit2 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$a = 1;
?>


<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', 'Bilangan Naskhah Pesan','Bilangan Naskhah Bekal', { role: 'style' }],
          <?php do { ?>
          ['<?php echo $dataJudulPenerbit["negeri"];?>',  <?php echo $dataJudulPenerbit["bilnaskhahpesan"];?>, <?php echo $dataJudulPenerbit["bilnaskhahbekal"];?>, '<?php echo $dataJudulPenerbit["colorBar"];?>'],
          <?php } while ($dataJudulPenerbit = mysqli_fetch_assoc($Recordset2));?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options = {
        bar: {groupWidth: "85%"},
        legend: { position: "none" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("prestasi_div"));
        chart.draw(view, options);
      }
</script>

<?php if(!empty($dataJudulPenerbit2['negeri'])) { ?>
<h3 class="card-title" style="font-family: 'Roboto Condensed', sans-serif; text-align: center;">Prestasi Pembekalan Mengikut Negeri</h3>
<div id="prestasi_div" style="width: 100%;min-height: 450px;"></div>
<?php ;} else echo '<a class="btn btn-warning btn-sm active" role="button" aria-pressed="true">Tiada rekod setakat ini</a>';?>