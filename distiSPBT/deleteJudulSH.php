<?php

//delete.php

$connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");

if(isset($_POST["checkbox_value"]))
{
 for($count = 0; $count < count($_POST["checkbox_value"]); $count++)
 {
  $query = "DELETE FROM dataJudulPenerbit WHERE id = '".$_POST['checkbox_value'][$count]."'";
  $statement = $connect->prepare($query);
  $statement->execute();
 }
}

if(isset($_POST["checkbox_value2"]))
{
 for($count = 0; $count < count($_POST["checkbox_value2"]); $count++)
 {
  $query = "DELETE FROM dataSH WHERE id = '".$_POST['checkbox_value2'][$count]."'";
  $statement = $connect->prepare($query);
  $statement->execute();
 }
}

?>