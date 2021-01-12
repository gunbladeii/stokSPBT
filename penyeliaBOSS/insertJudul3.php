<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");

?>
<?php

//multiple_update.php



if(isset($_POST['hidden_id']))
{
 $bukurosak = $_POST['bukurosak'];
 $bukurosakmurid = $_POST['bukurosakmurid'];
 $bukulebihan = $_POST['bukulebihan'];
 $kodsekolah = $_POST['kodsekolah'];
 $namasekolah = $_POST['namasekolah'];
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':bukurosak'  => $bukurosak[$count],
   ':bukurosakmurid' => $bukurosakmurid[$count],
   ':bukulebihan' => $bukulebihan[$count],
   ':kodsekolah' => $kodsekolah[$count],
   ':namasekolah' => $namasekolah[$count],

  );
  $query = "
  INSERT INTO rekodPemantauan 
  (kodSekolah,namaSekolah,bukuRosak, bukuRosakMurid, bukuLebihan)VALUES(kodsekolah,namasekolah,bukurosak,bukurosakmurid,bukulebihan)
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>