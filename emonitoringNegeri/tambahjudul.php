<?php
//insert.php;

if(isset($_POST["kodjudul"]))
{
 $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
 $id = uniqid();
 for($count = 0; $count < count($_POST["kodjudul"]); $count++)
 {  
  $query = "INSERT INTO dataJudulPenerbit 
  (kodjudul) 
  VALUES (:kodjudul)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
   
    ':kodjudul'  => $_POST["kodjudul"][$count]
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