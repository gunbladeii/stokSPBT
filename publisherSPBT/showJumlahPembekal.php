<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$refIDPublisher = $row_Recordset['roleID'];

    $refID3 = $mysqli->query("SELECT *, COUNT(refID) AS `jumPenerbit` FROM `login` WHERE refID = '$refIDPublisher' GROUP BY refID");
    $RID2 = mysqli_fetch_assoc($refID3);
?>

<?php if ($RID2['roleID'] != NULL || !empty($RID2['roleID'])) {echo number_format($RID2['jumPenerbit']);}else{echo '<span class="badge badge-danger">Tiada rekod</span>';}?>



