<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$kodSekolahAsal = $_GET['kodSekolahAsal'];
$kodSekolahBaru = $_GET['kodSekolahBaru'];
$kodSekolahAsal2 = $_POST['kodSekolahAsal'];
$kodSekolahBaru2 = $_POST['kodSekolahBaru'];

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

    if (isset($_POST['submit'])) {
    $mysqli->query ("UPDATE rekodPemantauan SET `kodSekolah` = '$kodSekolahBaru2' WHERE `kodSekolah` = '$kodSekolahAsal2'");
    header("location:main3.php?kodSekolah=$kodSekolah2");
    }
    
?>

                        <form method="post" action="delJudul.php" enctype="multipart/form-data">
                            <div> Anda pasti untuk kemaskini rekod?</div>
                            <input type="hidden" name="kodSekolahAsal" value="<?php echo $kodSekolahAsal;?>">
                            <input type="hidden" name="kodSekolahBaru" value="<?php echo $kodSekolahBaru;?>">
                              <div class="modal-footer">
                                  <input type="submit" class="btn btn-primary" name="submit" value="Ya"/>&nbsp;
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                              </div>
                         </form>
               

