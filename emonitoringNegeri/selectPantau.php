<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$namaPembekal = $_GET['namaPembekal'];
$negeri = $_GET['negeri'];

$query = "SELECT dataJudulPenerbit.id,dataJudulPenerbit.timestamp,dataJudulPenerbit.namapembekal, dataJudulPenerbit.negeri,dataJudulPenerbit.kodjudul,dataJudulPenerbit.bilnaskhahpesan, dataJudulPenerbit.bilnaskhahbekal, dataJudulPenerbit.statusbekal,dataSHJudul.judul FROM 
(dataJudulPenerbit 
	INNER JOIN dataSHJudul ON dataJudulPenerbit.kodjudul = dataSHJudul.kodJudul)
	WHERE dataJudulPenerbit.namapembekal = '$namaPembekal' AND dataJudulPenerbit.negeri = '$negeri'
	  ORDER BY dataJudulPenerbit.id DESC

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