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
$year = date('Y');

    $refID3 = $mysqli->query("SELECT * FROM `login` WHERE year = '$year'");
    $RID = mysqli_fetch_assoc($refID3);
    $a=1;
?>
<?php if (!empty($RID['role'])){?>
                <div class="table-responsive">
                  <table id="example3" class="table m-0 table-sm">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Penerbit</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Peranan</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php do {?>
                    <tr>
                      <td><?php echo $a++;?></td>
                      <td><a data-toggle="modal" data-target="#" data-whatever="<?php echo $RID['id'];?>" class="nav-link"><span class="badge badge-info"><?php echo strtoupper($RID['name']);?></span></a></td>
                      <td><?php echo $RID['username']?></td>
                      <td><?php echo $RID['password']?></td>
                      <td><?php if($RID['role'] == 'admin'){echo 'Administrator';}else if($RID['role'] == 'publisherSPBT'){echo 'Penerbit';}else if($RID['role'] == 'distiSPBT'){echo 'Pengedar';}?></td>
                      <td><span class="badge badge-warning"><?php echo strtoupper($RID['status']);?></span></td>
                    </tr>
                    <?php } while ($RID = mysqli_fetch_assoc($refID3)); ?>
                    </tbody>
                  </table>
                </div>
<?php } else {echo '<div style="padding-left: 15px"><span class="badge badge-danger">Tiada data setakat ini</span></div>';}?>

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example3").DataTable();
    $('#example4').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>