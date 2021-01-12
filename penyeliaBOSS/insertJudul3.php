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
 $bukustok = $_POST['bukustok'];
 $bukulebihan = $_POST['bukulebihan'];
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':bukurosak'  => $bukurosak[$count],
   ':bukurosakmurid' => $bukurosakmurid[$count],
   ':bukustok' => $bukustok[$count],
   ':bukulebihan' => $bukulebihan[$count],
  );
  $query = "
  UPDATE dataJudulPenerbit 
  SET bilNaskhahPesan = :bilnaskhahpesan, bilnaskhahbekal = :bilnaskhahbekal 
  WHERE id = :id
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>