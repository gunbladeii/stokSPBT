<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$namaPembekal = $_GET['namaPembekal'];
$negeri = $_GET['negeri'];

$query = "SELECT * FROM dataJudulPenerbit WHERE namapembekal = '$namaPembekal' AND negeri = '$negeri' ORDER BY id DESC";

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