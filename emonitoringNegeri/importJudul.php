<?php

//import.php

if(isset($_POST["kodpembekal"]))
{
 $connect = new PDO("mysql:host=localhost; dbname=myspbt", "adminspbt", "Sh@ti5620");

 session_start();

 $file_data = $_SESSION['file_data'];

 unset($_SESSION['file_data']);

 foreach($file_data as $row)
 {
  $data[] = '("'.$row[$_POST["kodpembekal"]].'", "'.$row[$_POST["kodjudul"]].'", "'.$row[$_POST["bilnaskhahpesan"]].'")';
 }

 if(isset($data))
 {
  $query = "
  INSERT INTO dataJudulPenerbit 
  (kodpembekal, kodjudul, bilnaskhahpesan) 
  VALUES ".implode(",", $data)."
  ";

  $statement = $connect->prepare($query);

  if($statement->execute())
  {
   echo 'Data berjaya disimpan. Sila kembali ke menu utama';
  }
  else
  {
     echo 'Sila semak semula kod pembekal dalam fail .csv';
  }
 }
}



?>
