<?php
//insert.php;

if(isset($_POST["kodjudul"]))
{
 $connect = new PDO("mysql:host=localhost;dbname=myspbt", "adminspbt", "Sh@ti5620");
 $id = uniqid();
 for($count = 0; $count < count($_POST["kodjudul"]); $count++)
 {  
  $query = "INSERT INTO dataJudulPenerbit 
  (kodpembekal, kodjudul) 
  VALUES (:kodpembekal, :kodjudul)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
   
    ':kodjudul'  => $_POST["kodjudul"][$count],
    ':kodpembekal'  => $_POST["kodpembekal"][$count]
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