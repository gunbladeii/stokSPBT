<?php
//insert.php;

if(isset($_POST["judul"]))
{
 $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
 $id = uniqid();
 for($count = 0; $count < count($_POST["judul"]); $count++) {
  $query = "INSERT INTO dataSHJudulPenerbit 
  (id_Penerbit, judul) 
  VALUES (:id_Penerbit, :judul)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':id_Penerbit'  => $_POST["id_Penerbit"][$count],   
    ':judul'  => $_POST["judul"][$count]
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