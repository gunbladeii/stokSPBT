<?php require('../conn.php'); ?>
<?php

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

$refID = $mysqli->query("SELECT FORMAT(COUNT(kodSekolah),0) AS BOSDPantau FROM eksportExcel WHERE kategori ='BOSD'");
$RID = mysqli_fetch_assoc($refID);

$refID2 = $mysqli->query("SELECT rekodPemantauan.id,dataSekolah.kategori,FORMAT(SUM(CASE WHEN rekodPemantauan.bukuStok > 0 THEN bukuStok ELSE 0 END),0) AS bukuStok 
  FROM 
  rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
  WHERE dataSekolah.kategori = 'BOSD'");
$RID2 = mysqli_fetch_assoc($refID2);

$refID3 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(CASE WHEN rekodPemantauan.bukuLebihan > 0 THEN bukuLebihan ELSE 0 END),0) AS bukuLebihan 
  FROM 
  rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
  WHERE dataSekolah.kategori = 'BOSD'");
$RID3 = mysqli_fetch_assoc($refID3);

$refID4 = $mysqli->query("SELECT id,FORMAT(COUNT(negeri),0) AS belumPantau 
  FROM dataSekolah 
  WHERE remark NOT LIKE 'observe' AND kategori = 'BOSD'");
$RID4 = mysqli_fetch_assoc($refID4);

$refID5 = $mysqli->query("SELECT rekodPemantauan.id,CONCAT('RM', FORMAT(SUM(CASE WHEN (dataJudul.harga * rekodPemantauan.bukuLebihan) > 0 THEN (dataJudul.harga * rekodPemantauan.bukuLebihan) ELSE 0 END),2)) AS harga 
  FROM 
  ((rekodPemantauan 
  INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
  INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
  WHERE dataSekolah.kategori = 'BOSD'
  GROUP BY dataSekolah.kategori");
$RID5 = mysqli_fetch_assoc($refID5);
?>
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID['BOSDPantau'])){echo $RID['BOSDPantau'];}else{echo 0;}?></h3>
      <p>BOSD dipantau</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID4['id'])){echo $RID4['belumPantau'];}else{echo 0;}?></h3>
      <p>BOSD belum dipantau</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col mx-1">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID3['id'])){echo $RID3['bukuLebihan'];}else{echo 0;} ?></h3>
      <p>Bil. Naskhah di BOSD</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
