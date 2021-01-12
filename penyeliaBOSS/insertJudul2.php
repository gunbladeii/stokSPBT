<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$kodSekolah = $_GET['kodSekolah'];
$jenisAliran = $_GET['jenisAliran'];

$query = "SELECT dataJudul.kodJudul, dataJudul.judul, dataJudul.jenisAliran, rekodPemantauan.bukuRosak,rekodPemantauan.bukuRosakMurid, rekodPemantauan.bukuStok, rekodPemantauan.bukuLebihan, rekodPemantauan.kodSekolah FROM 
((rekodPemantauan 
	INNER JOIN dataJudul ON rekodPemantauan.jenisAliran = dataJudul.jenisAliran)
	INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah)
	WHERE dataSekolah. = '$kodPembekal'
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