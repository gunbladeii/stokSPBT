<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");

?>
<?php

//multiple_update.php



if(isset($_POST['hidden_id']))
{
 $bilnaskhahpesan = $_POST['bilnaskhahpesan'];
 $bilnaskhahbekal = $_POST['bilnaskhahbekal'];
 $id = $_POST['hidden_id'];
 for($count = 0; $count < count($id); $count++)
 {
  $data = array(
   ':bilnaskhahbekal' => $bilnaskhahbekal[$count],
   ':id'   => $id[$count]
  );
  $query = "
  UPDATE dataJudulPenerbit 
  SET bilnaskhahbekal = :bilnaskhahbekal
  WHERE id = :id
  ";
  $statement = $connect->prepare($query);
  $statement->execute($data);
 }
}

?>