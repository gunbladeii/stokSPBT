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

$negeri = $row_Recordset['negeri'];

date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

    $refID3 = $mysqli->query("SELECT id,COUNT(remark) AS sekolahPantau FROM dataSekolah WHERE remark = 'observe' AND negeri = '$negeri'");
    $RID2 = mysqli_fetch_assoc($refID3);
?>
<?php
if (!empty($RID2['id'])){echo $RID2['sekolahPantau'];}else{echo 0;}
?>

