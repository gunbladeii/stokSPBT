<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$kodPembekal = $_GET['kodPembekal'];
$negeri = $_GET['negeri'];

$query = "SELECT dataJudulPenerbit.bilnaskhahpesan,dataJudulPenerbit.bilnaskhahbekal,
CASE WHEN dataJudulPenerbit.bilnaskhahpesan > dataJudulPenerbit.bilnaskhahbekal THEN 'BELUM SELESAI'
WHEN dataJudulPenerbit.bilnaskhahpesan < dataJudulPenerbit.bilnaskhahbekal THEN 'SEMAK SEMULA'
WHEN dataJudulPenerbit.bilnaskhahpesan = dataJudulPenerbit.bilnaskhahbekal THEN ''
WHEN dataJudulPenerbit.bilnaskhahpesan < 0 AND dataJudulPenerbit.bilnaskhahbekal < 0 THEN ''
ELSE '' END AS statusBekal,
dataJudulPenerbit.id,dataJudulPenerbit.timestamp,dataJudulPenerbit.kodpembekal, dataSH.negeri,dataJudulPenerbit.kodjudul, dataSHJudul.judul FROM 
((dataJudulPenerbit 
	INNER JOIN dataSHJudul ON dataJudulPenerbit.kodjudul = dataSHJudul.kodJudul)
	INNER JOIN dataSH ON dataJudulPenerbit.kodpembekal = dataSH.kodPembekal)
	WHERE dataJudulPenerbit.kodPembekal = '$kodPembekal'
	  ORDER BY dataJudulPenerbit.id DESC";

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