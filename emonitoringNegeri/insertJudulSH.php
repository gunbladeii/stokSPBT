<?php
//insert.php;

if(isset($_POST["kodJudul"]))
{
 $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
 $id = uniqid();
 for($count = 0; $count < count($_POST["kodJudul"]); $count++) {
  $query = "INSERT INTO dataSHJudulPenerbit 
  (id_Penerbit, kodJudul) 
  VALUES (:id_Penerbit, :kodJudul)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':id_Penerbit'  => $_POST["id_Penerbit"][$count],   
    ':kodJudul'  => $_POST["kodJudul"][$count]
   )
  );
 }
 $result = $statement->fetchAll();
 if(isset($result))
 {
  echo 'ok';
 }
}
?>