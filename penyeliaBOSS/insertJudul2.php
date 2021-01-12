<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$kodSekolah = $_GET['kodSekolah'];
$jenisAliran = $_GET['jenisAliran'];

$query = "SELECT dataJudul.kodJudul AS kodjudul, dataJudul.judul AS namajudul, dataJudul.jenisAliran, rekodPemantauan.bukuRosak AS bukurosak,rekodPemantauan.bukuRosakMurid AS bukurosakmurid, rekodPemantauan.bukuStok AS bukustok, rekodPemantauan.bukuLebihan AS bukulebihan, rekodPemantauan.kodSekolah FROM 
((rekodPemantauan 
	INNER JOIN dataJudul ON rekodPemantauan.jenisAliran = dataJudul.jenisAliran)
	INNER JOIN dataSekolah ON rekodPemantauan.kodSekolah = dataSekolah.kodSekolah)
	WHERE dataSekolah.jenisAliran = '$jenisAliran'
	  ORDER BY dataJudul.judul ASC";

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