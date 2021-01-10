<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$id = $_GET['id'];
$kodSekolah = $_GET['kodSekolah'];
$kodSekolah2 = $_POST['kodSekolah'];
$id2 = $_POST['id'];

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

    if (isset($_POST['submit'])) {
    $mysqli->query ("DELETE FROM rekodPemantauan WHERE `id` = '$id2'");
    header("location:main3.php?kodSekolah=$kodSekolah2");
    }

    $Recordset4 = $mysqli->query("SELECT rekodPemantauan.id, rekodPemantauan.kodJudul, dataJudul.judul, rekodPemantauan.bukuLebihan FROM rekodPemantauan INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul WHERE kodSekolah = '$kodSekolah'");
	$rekodPemantauan = mysqli_fetch_assoc($Recordset4);
	$totalRows_Recordset3 = mysqli_num_rows($Recordset4);
    $a=1;
?>

                        <form method="post" action="delJudul.php" role="form" enctype="multipart/form-data">
                            <div> Anda pasti untuk hapus rekod?</div>
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="hidden" name="kodSekolah" value="<?php echo $kodSekolah;?>">
                              <div class="modal-footer">
                                  <input type="submit" class="btn btn-primary" name="submit" value="Ya"/>&nbsp;
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                              </div>
                         </form>
               

