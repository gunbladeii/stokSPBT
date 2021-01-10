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
$bukuRosak = $_POST['bukuRosak'];
$bukuLebihan = $_POST['bukuLebihan'];
$bukuStok = $_POST['bukuStok'];
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
  $mysqli->query ("UPDATE `rekodPemantauan` SET bukuStok = '$bukuStok',bukuLebihan = '$bukuLebihan', bukuRosak = '$bukuRosak' WHERE `id` = '$id2'");
  header("location:main3.php?kodSekolah=$kodSekolah2");
}

$Recordset4 = $mysqli->query("SELECT dataSekolah.kategori,dataSekolah.namaSekolah,rekodPemantauan.id, rekodPemantauan.kodJudul, dataJudul.judul, rekodPemantauan.bukuLebihan, rekodPemantauan.bukuRosak 
  FROM ((rekodPemantauan 
  INNER JOIN dataJudul ON rekodPemantauan.kodJudul = dataJudul.kodJudul)
  INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah) 
  WHERE rekodPemantauan.id = '$id'");
$ReID = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset3 = mysqli_num_rows($Recordset4);
$a=1;
?>

<form method="post" action="editJudulModal.php" role="form" enctype="multipart/form-data">
 <div class="form-group"> 
  Nama Sekolah: <?php echo ($ReID['namaSekolah']);?>
</div>
<div class="form-group"> 
  Jenis Bilik Operasi: <?php echo ($ReID['kategori']);?>
</div>
<div class="form-group"> 
  Kod Judul: <?php echo ($ReID['kodJudul']);?>
</div>

<div class="form-group"> 
 Judul: <?php echo strtoupper($ReID['judul']);?>
</div>

<div class="form-group"> 
  Jumlah Naskhah (buku rosak):
  <div class="input-group mb-3">
    <input type="text" name="bukuRosak" class="form-control"  id="bukuRosak" value="<?php echo $ReID['bukuRosak'];?>" required>
    <input type="hidden" id="bukuRosak" value="3">
    <div class="input-group-append input-group-text">
      <span class="fas fa-book"></span>
    </div>
  </div>
</div>

<div class="form-group"> 
  Jumlah Naskhah (buku elok):
  <div class="input-group mb-3">
    <input type="text" name="bukuLebihan" class="form-control"  id="bukuLebihan" value="<?php echo $ReID['bukuLebihan'];?>" required>
    <input type="hidden" id="bukuWajib" value="3">
    <div class="input-group-append input-group-text">
      <span class="fas fa-book"></span>
    </div>
  </div>
</div>

<div class="form-group"> 
  Jumlah Stok (Lebihan):
  <div class="input-group mb-3">
   <input type="text" id="bukuStok" name="bukuStok" class="form-control" value="" readonly required>
   <div class="input-group-append input-group-text">
    <span class="fas fa-pen-fancy"></span>
  </div>
</div>
</div>

<input type="hidden" name="id" value="<?php echo $id;?>"/>
<input type="hidden" name="kodSekolah" value="<?php echo $kodSekolah;?>">
<div class="modal-footer">
 <input type="submit" class="btn btn-primary" name="submit" value="Simpan rekod"/>
</div>

</form>

<script>
  $(document).ready(function() {
    //this calculates values automatically 
    sum();
    $("#bukuLebihan").on("keydown keyup", function() {
      sum();
    });

    function sum() {
      var num1 = document.getElementById('bukuLebihan').value;
      var num2 = document.getElementById('bukuWajib').value;
      var result = parseInt(num1) - parseInt(num2);
      if (!isNaN(result)) 
      {
        document.getElementById('bukuStok').value = result;
      }

    }
  });
</script>


