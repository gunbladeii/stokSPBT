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

    $refID = $mysqli->query("SELECT FORMAT(COUNT(kodSekolah),0) AS BOSSPantau FROM eksportExcel WHERE kategori ='BOSS'");
    $RID = mysqli_fetch_assoc($refID);

    $refID2 = $mysqli->query("SELECT rekodPemantauan.id,dataSekolah.kategori,FORMAT(SUM(CASE WHEN rekodPemantauan.bukuStok > 0 THEN bukuStok ELSE 0 END),0) AS bukuStok 
      FROM 
      rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
      WHERE dataSekolah.kategori = 'BOSS'");
    $RID2 = mysqli_fetch_assoc($refID2);

    $refID3 = $mysqli->query("SELECT rekodPemantauan.id,FORMAT(SUM(CASE WHEN rekodPemantauan.bukuLebihan > 0 THEN bukuLebihan ELSE 0 END),0) AS bukuLebihan 
      FROM 
      rekodPemantauan INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah
      WHERE dataSekolah.kategori = 'BOSS'");
    $RID3 = mysqli_fetch_assoc($refID3);

    $refID4 = $mysqli->query("SELECT id,FORMAT(COUNT(negeri),0) AS belumPantau 
      FROM dataSekolah 
      WHERE remark NOT LIKE 'observe' AND kategori = 'BOSS'");
    $RID4 = mysqli_fetch_assoc($refID4);

    $refID5 = $mysqli->query("SELECT rekodPemantauan.id,CONCAT('RM', FORMAT(SUM(CASE WHEN (dataJudul.harga * rekodPemantauan.bukuStok) > 0 THEN (dataJudul.harga * rekodPemantauan.bukuStok) ELSE 0 END),2)) AS harga 
      FROM 
      ((rekodPemantauan 
      INNER JOIN dataSekolah ON dataSekolah.kodSekolah = rekodPemantauan.kodSekolah)
      INNER JOIN dataJudul ON dataJudul.kodJudul = rekodPemantauan.kodJudul)
      WHERE dataSekolah.kategori = 'BOSS'
      GROUP BY dataSekolah.kategori");
    $RID5 = mysqli_fetch_assoc($refID5);
?>
          <div class="col mx-1">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID['BOSSPantau'])){echo $RID['BOSSPantau'];}else{echo 0;}?></h3>
                <p>BOSS dipantau</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col mx-1">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID4['id'])){echo $RID4['belumPantau'];}else{echo 0;}?></h3>
                <p>BOSS belum dipantau</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
         <div class="col mx-1">
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
           <div class="col mx-1">
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
          <div class="col mx-1">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                 <h3 style="font-family: 'Anton', sans-serif;"><?php if (!empty($RID5['id'])){echo $RID5['harga'];}else{echo 0;} ?></h3>
                <p>Kos (Lebihan di BOSS)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->