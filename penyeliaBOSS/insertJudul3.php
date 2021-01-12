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
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':bukurosak'  => $bukurosak[$count],
   ':bukurosakmurid' => $bukurosakmurid[$count],
   ':bukulebihan' => $bukulebihan[$count],
  );
  $query = "
  INSERT INTO rekodPemantauan 
  (bukuRosak, bukuRosakMurid, bukuLebihan)VALUES(bukurosak,bukurosakmurid,bukulebihan)
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>