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

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

$judul = $_POST['judul'];
$totPesanan = $_POST['totPesanan'];
$totBekalan = $_POST['totBekalan'];
$id2 = $_POST['id'];

    if (isset($_POST['submit'])) {
    $mysqli->query ("UPDATE `statusBekalan` SET `judul` = '$judul', `totPesanan` = '$totPesanan', `totBekalan` = '$totBekalan' WHERE `id` = '$id2'");
    header("location:controlPanel.php");
    }

    $refID3 = $mysqli->query("SELECT statusBekalan.id, login.name, statusBekalan.roleID,statusBekalan.state, statusBekalan.zon, statusBekalan.totPesanan, statusBekalan.totBekalan, statusBekalan.year, statusBekalan.judul FROM `statusBekalan` INNER JOIN login ON statusBekalan.roleID = login.roleID WHERE statusBekalan.year = '$year' AND statusBekalan.id = '$id'");
    $RID = mysqli_fetch_assoc($refID3);
    $a=1;
?>
<?php if (!empty($RID['state'])){?>
                <div class="table-responsive">
                  <form method="post" action="updatePesananJudul2.php" role="form" enctype="multipart/form-data">
                            <div>
                              <div class="form-group">
                                <div class="input-group mb-3">
                                <input type="text" name="judul" class="form-control" placeholder="<?php echo strtoupper($RID['judul']);?>" id="validationDefault01"value="<?php echo $RID['judul'];?>" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-id-card-alt"></span>
                                </div>
                               </div>
                              </div>
                              
                              <div class="form-group">
                                <div class="input-group mb-3">
                                <input type="number" style="text-transform: uppercase;" class="form-control" placeholder="Masukkan jumlah pesanan" name="totPesanan" id="validationDefault02" value="<?php echo $RID['totPesanan'];?>" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <div class="input-group mb-3"> 
                                <input type="number" name="totBekalan" class="form-control" placeholder="Masukkan jumlah pembekalan" id="validationDefault03" value="<?php echo $RID['totBekalan'];?>" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                                </div>
                              </div>

                            </div>

                              <input type="hidden" name="id" value="<?php echo $id;?>"/>
                              <input type="hidden" name="status" value="active"/>
                              <input type="hidden" name="refID" value="<?php echo $RID['roleID'];?>"/>
                              <div class="modal-footer">
                                  <input type="submit" class="btn btn-primary" name="submit" value="Kemaskini rekod"/>&nbsp;
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                         </form>
                </div>
<?php } else {echo '<div style="padding-left: 15px"><span class="badge badge-danger">Tiada data setakat ini</span></div>';}?>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
