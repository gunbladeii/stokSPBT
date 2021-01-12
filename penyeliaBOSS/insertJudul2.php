<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");

?>
<?php

//select.php

$kodSekolah = $_GET['kodSekolah'];
$jenisAliran = $_GET['jenisAliran'];

$query = "SELECT id,darjahTingkatan AS darjahtingkatan, kodJudul AS kodjudul, judul AS namajudul, jenisAliran, CONCAT('RM', harga) AS harga
	FROM dataJudul
	WHERE jenisAliran = '$jenisAliran'
	ORDER BY darjahTingkatan ASC";

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