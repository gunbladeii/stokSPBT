<?php

//import.php

if(isset($_POST["namaPembekal"]))
{
 $connect = new PDO("mysql:host=localhost; dbname=testing7", "root", "mysql");

 session_start();

 $file_data = $_SESSION['file_data'];

 unset($_SESSION['file_data']);

 foreach($file_data as $row)
 {
  $data[] = '("'.$row[$_POST["namaPembekal"]].'", "'.$row[$_POST["negeri"]].'", "'.$row[$_POST["kodJudul"]].'")';
 }

 if(isset($data))
 {
  $query = "
  INSERT INTO csv_file 
  (namaPembekal, negeri, kodJudul) 
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
