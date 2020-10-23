<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

?>
<?php

//multiple_update.php



if(isset($_POST['hidden_id']))
{
 $bilnaskhahpesan = $_POST['bilnaskhahpesan'];
 $bilnaskhahbekal = $_POST['bilnaskhahbekal'];
 $statusbekal = $_POST['statusbekal'];
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':bilnaskhahpesan'  => $bilnaskhahpesan[$count],
   ':bilnaskhahbekal' => $bilnaskhahbekal[$count],
   ':statusbekal'   => $statusbekal[$count],
   ':id'   => $id[$count]
  );
  $query = "
  UPDATE dataJudulPenerbit 
  SET bilNaskhahPesan = :bilnaskhahpesan, bilnaskhahbekal = :bilnaskhahbekal, statusbekal = :statusbekal 
  WHERE id = :id
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>