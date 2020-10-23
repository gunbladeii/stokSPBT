<?php

//import.php

if(isset($_POST["kodPembekal"]))
{
 $connect = new PDO("mysql:host=localhost; dbname=spbt_stok", "adminspbt", "Sh@ti5620");

 session_start();

 $file_data = $_SESSION['file_data'];

 unset($_SESSION['file_data']);

 foreach($file_data as $row)
 {
  $data[] = '("'.$row[$_POST["kodPembekal"]].'", "'.$row[$_POST["negeri"]].'", "'.$row[$_POST["kodJudul"]].'", "'.$row[$_POST["judul"]].'")';
 }

 if(isset($data))
 {
  $query = "
  INSERT INTO dataJudulPenerbit 
  (kodPembekal, negeri, kodJudul, judul) 
  VALUES ".implode(",", $data)."
  ";

  $statement = $connect->prepare($query);

  if($statement->execute())
  {
   echo 'Data berjaya disimpan. Sila kembali ke menu utama';
  }
 }
}



?>
