<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$Recordset = $mysqli->query("SELECT * FROM dataSekolah WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

    $refID3 = $mysqli->query("SELECT id,SUM(CASE WHEN bukuStok > 0 THEN bukuStok ELSE 0 END) AS bukuStok FROM rekodPemantauan");
    $RID2 = mysqli_fetch_assoc($refID3);
?>
<?php
if (!empty($RID2['id'])){echo $RID2['bukuStok'];}else{echo 0;}
?>

