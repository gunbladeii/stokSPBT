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
$refIDPublisher = $row_Recordset['roleID'];
$station=$row_Recordset['stationCode'];
date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d');
$month = date('m');
$time = date('H:i:s');

$b=1;

$refID3 = $mysqli->query("SELECT login.name, login.role, statusBekalan.state, statusBekalan.zon, statusBekalan.judul, statusBekalan.totBekalan, statusBekalan.totPesanan, statusBekalan.date, statusBekalan.time FROM `login` INNER JOIN `statusBekalan` ON login.roleID = statusBekalan.roleID WHERE login.refID =  '$refIDPublisher' ORDER BY statusBekalan.judul ASC");
    $RID2 = mysqli_fetch_assoc($refID3);

?>

<?php if ($RID2['role'] == 'distiSPBT'){?>
                      <div class="table-responsive">
                        <table class="table m-0" id="example1">
                          <thead>
                          <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Nama Pengedar</th>
                            <th>Negeri</th>
                            <th>Zon</th>
                            <th>Pesanan</th>
                            <th>Bekal</th>
                            <th>Status</th>

                          </tr>
                          </thead>
                          <tbody>
                          <?php do {?>
                          <tr>
                            <td><?php echo $b++;?></td>
                            <td><?php echo strtoupper($RID2['judul']);?></td>
                            <td><span class="badge badge-info"><?php echo strtoupper($RID2['name'])?></span></td>
                            <td><span class="badge badge-success"><?php echo strtoupper($RID2['state']);?></span></td>
                            <td><span class="badge badge-warning"><?php echo strtoupper($RID2['zon']);?></span></td>
                            <td><?php if (!empty($RID2['totPesanan'])){echo '<span class="badge badge-success">'.number_format($RID2["totPesanan"]).'</span>';}else {echo '<span class="badge badge-danger">0</span>';}?></td>
                            <td><?php if (!empty($RID2['totBekalan'])){echo '<span class="badge badge-success">'.number_format($RID2["totBekalan"]).'</span>';}else {echo '<span class="badge badge-danger">0</span>';}?></td>
                            <td><?php if (!empty($RID2['totBekalan']) && $RID2['totBekalan'] == $RID2['totPesanan']){echo '<span class="badge badge-success">Selesai</span>';}elseif ($RID2['totBekalan'] < $RID2['totPesanan']){echo '<span class="badge badge-danger">Belum selesai</span>';}elseif ($RID2['totBekalan'] > $RID2['totPesanan']){echo '<span class="badge badge-danger">Semak semula</span>';}elseif ($RID2['totBekalan'] == 0){echo '<span class="badge badge-danger">Belum selesai</span>';}?></td>
                          </tr>
                          <?php } while ($RID2 = mysqli_fetch_assoc($refID3)); ?>
                          </tbody>
                        </table>
                      </div>
                      <?php } else {echo '<div class="badge badge-danger">No data yet</div>';}?>
