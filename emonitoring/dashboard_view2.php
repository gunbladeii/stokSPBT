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

    $refID = $mysqli->query("SELECT id,kategori,COUNT(remark) AS BOSDPantau FROM dataSekolah WHERE remark = 'observe' AND kategori ='BOSD'");
    $RID = mysqli_fetch_assoc($refID);

    $refID2 = $mysqli->query("SELECT rekodPemantauan.id,dataSekolah.kategori,SUM(CASE WHEN rekodPemantauan.bukuStok > 0 THEN bukuStok ELSE 0 END) AS bukuStok 
      FROM 
      rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
      WHERE dataSekolah.kategori = 'BOSD'");
    $RID2 = mysqli_fetch_assoc($refID2);

    $refID3 = $mysqli->query("SELECT rekodPemantauan.id,SUM(CASE WHEN rekodPemantauan.bukuLebihan > 0 THEN bukuLebihan ELSE 0 END) AS bukuLebihan 
      FROM 
      rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
      WHERE dataSekolah.kategori = 'BOSD'");
    $RID3 = mysqli_fetch_assoc($refID3);

    $refID4 = $mysqli->query("SELECT id,COUNT(negeri) AS belumPantau 
      FROM dataSekolah 
      WHERE remark NOT LIKE 'observe' AND kategori = 'BOSD'");
    $RID4 = mysqli_fetch_assoc($refID4);
?>
<div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID['id'])){echo $RID['BOSDPantau'];}else{echo 0;}?></h3>
                <p>BOSD dipantau</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID4['id'])){echo $RID4['belumPantau'];}else{echo 0;}?></h3>
                <p>BOSD belum dipantau</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID3['id'])){echo $RID3['bukuLebihan'];}else{echo 0;} ?></h3>
                <p>Naskhah (buku elok)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID2['id'])){echo $RID2['bukuStok'];}else{echo 0;}?></h3>
                <p>Stok (lebihan)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->