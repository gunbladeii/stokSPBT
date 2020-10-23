<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$kodPembekal = $_GET['kodPembekal'];
$negeri = $_GET['negeri'];

$query = "SELECT * FROM dataJudulPenerbit WHERE kodpembekal = '$kodPembekal' ORDER BY id DESC";

$statement = $connect->prepare($query);

if($statement->execute())
{
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }

 echo json_encode($data);
}

?>