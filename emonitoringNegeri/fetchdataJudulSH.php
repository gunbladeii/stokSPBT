<?php
//fetch.php
$connect = mysqli_connect("localhost", "adminspbt", "Sh@ti5620", "spbt_stok");
$output = '';
$query = "SELECT dataSHJudulPenerbit.kodJudul, dataSHJudul.judul FROM dataSHJudulPenerbit INNER JOIN dataSHJudul ON dataSHJudulPenerbit.kodJudul = dataSHJudul.kodJudul ORDER BY dataSHJudulPenerbit.kodJudul ASC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<h3 align="center">Judul</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="5%">id</th>
  <th width="30%">Kod Judul</th>
  <th width="65%">Nama Judul</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["id"].'</td>
  <td>'.$row["kodJudul"].'</td>
  <td>'.$row["namaJudul"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>