<?php require('conn.php'); ?>
<?php
session_start();
if ($_SESSION['role'] != 'admin')
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

$refID = $mysqli->query("SELECT FORMAT(COUNT(dataSekolah.remark),0) AS totalObserve 
FROM dataSekolah INNER JOIN rekodPemantauan 
ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
WHERE dataSekolah.remark = 'observe' AND rekodPemantauan.bukuRosak > 0");
$RID = mysqli_fetch_assoc($refID);

$refID4 = $mysqli->query("SELECT FORMAT(COUNT(dataSekolah.remark),0) AS totalkeyin 
FROM dataSekolah INNER JOIN rekodPemantauan 
ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
WHERE dataSekolah.remark = 'observe' AND rekodPemantauan.bukuRosak > 0");
$RID4 = mysqli_fetch_assoc($refID4);

$refID3 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(rekodPemantauan.bukuRosak),0) AS totalBukuRosak, CONCAT('RM', FORMAT(SUM(dataJudul.harga),0)) AS hargaBOSS
  FROM ((rekodPemantauan 
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.kategori = 'BOSS' AND rekodPemantauan.bukuRosak > 0");
$RID3 = mysqli_fetch_assoc($refID3);

$refID4 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(rekodPemantauan.bukuRosak),0) AS totalBukuRosak, CONCAT('RM', FORMAT(SUM(dataJudul.harga),0)) AS hargaBOSD
  FROM ((rekodPemantauan 
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.kategori = 'BOSD' AND rekodPemantauan.bukuRosak > 0");
$RID4 = mysqli_fetch_assoc($refID4);

$refID5 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(rekodPemantauan.bukuRosak),0) AS totalBukuRosak, CONCAT('RM', FORMAT(SUM(dataJudul.harga),0)) AS hargaRosak
  FROM ((rekodPemantauan 
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.kategori = 'BOSS' AND rekodPemantauan.bukuRosakMurid > 0");
$RID5 = mysqli_fetch_assoc($refID5);

$refID6 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(rekodPemantauan.bukuRosak),0) AS totalBukuRosak, CONCAT('RM', FORMAT(SUM(dataJudul.harga),0)) AS hargaTotalRosak
  FROM ((rekodPemantauan 
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.remark = 'observe' AND rekodPemantauan.bukuRosak > 0");
$RID6 = mysqli_fetch_assoc($refID6);


?>
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID['totalObserve'])){echo $RID['totalObserve'];}else{echo 0;}?></h3>
      <p>Bilangan Sekolah terlibat banjir</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">More info</a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID4['totalkeyin'])){echo $RID4['totalkeyin'];}else{echo 0;}?></h3>
      <p>Bil. Sekolah kunci masuk sistem</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">More info</a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID3['totalBukuRosak'])){echo $RID3['totalBukuRosak'];}else{echo 0;} ?></h3>
      <p>Bil. Buku Rosak(BOSS)</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">Kos: <?php if (!empty($RID3['hargaBOSS'])){echo $RID3['hargaBOSS'];}else{echo 0;} ?></a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-secondary">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID4['totalBukuRosak'])){echo $RID4['totalBukuRosak'];}else{echo 0;} ?></h3>
      <p>Bil. Buku Rosak(BOSD)</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">Kos: <?php if (!empty($RID4['hargaBOSS'])){echo $RID4['hargaBOSD'];}else{echo 0;} ?></a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-danger">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID5['totalBukuRosak'])){echo $RID5['totalBukuRosak'];}else{echo 0;} ?></h3>
      <p>Bil. Buku Rosak di tangan murid</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">Kos: <?php if (!empty($RID5['hargaRosak'])){echo $RID5['hargaRosak'];}else{echo 0;} ?></a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-primary">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID6['totalBukuRosak'])){echo $RID6['totalBukuRosak'];}else{echo 0;} ?></h3>
      <p>Jumlah besar buku rosak</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">Kos: <?php if (!empty($RID6['hargaRosak'])){echo $RID6['hargaTotalRosak'];}else{echo 0;} ?></a>
  </div>
</div>
<!-- ./col -->