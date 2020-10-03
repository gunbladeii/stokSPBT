<?php require('conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'stokNegeri')
{
      header('Location:../index.php');
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$negeri = $row_Recordset['negeri'];

date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

    $refID3 = $mysqli->query("SELECT id,COUNT(kodSekolah) AS belumPantau FROM dataSekolah WHERE remark NOT LIKE 'observe' AND negeri = '$negeri'");
    $RID2 = mysqli_fetch_assoc($refID3);
?>
<?php
if (!empty($RID2['id'])){echo $RID2['belumPantau'];}else{echo 0;}
?>

