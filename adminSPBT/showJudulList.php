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

    $refID3 = $mysqli->query("SELECT login.name, statusBekalan.roleID,statusBekalan.state, statusBekalan.zon, statusBekalan.totPesanan, statusBekalan.totBekalan, statusBekalan.year, statusBekalan.judul FROM `statusBekalan` INNER JOIN login ON statusBekalan.roleID = login.roleID WHERE statusBekalan.year = '$year'");
    $RID = mysqli_fetch_assoc($refID3);
    $a=1;
?>
<?php if (!empty($RID['state'])){?>
                <div class="table-responsive">
                  <table id="example1" class="table m-0">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Judul</th>
                      <th>Negeri</th>
                      <th>Zon</th>
                      <th>Penerbit/Pengedar</th>
                      <th>Jumlah Pesanan</th>
                      <th>Jumlah Pembekalan</th>
                      <th>Tahun</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php do {?>
                    <tr>
                      <td><?php echo $a++;?></td>
                      <td><a data-toggle="modal" data-target="#" data-whatever="<?php echo $RID['id'];?>"><span class="badge badge-info"><?php echo strtoupper($RID['judul']);?></span></a></td>
                      <td><?php echo $RID['state'];?></td>
                      <td><?php echo ucwords($RID['zon']);?></td>
                      <td><?php echo strtoupper($RID['name']);?></td>
                      <td><?php echo $RID['totPesanan'];?></td>
                      <td><?php echo $RID['totBekalan'];?></td>
                      <td><?php echo $RID['year'];?></td>
                      <td><?php if($RID['totPesanan'] == $RID['totBekalan']){echo '<span class="badge badge-success">Selesai</span>';}else if($RID['totPesanan'] > $RID['totBekalan']){echo '<span class="badge badge-warning">Belum selesai</span>';}else if($RID['totPesanan'] < $RID['totBekalan']){echo '<span class="badge badge-danger">Semak semula</span>';}?></td>
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
