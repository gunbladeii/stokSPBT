<?php session_start();?>
<?php
//fetch.php
$connect = mysqli_connect("localhost", "adminspbt", "Sh@ti5620", "spbt_stok");
$id = $_GET['id'];
$output = '';
$query = "SELECT dataSHJudulPenerbit.timestamp,dataSHJudulPenerbit.id_Penerbit, dataSH.namaPembekal, dataSH.negeri,dataSHJudulPenerbit.kodJudul, dataSHJudul.judul FROM 
((dataSHJudulPenerbit 
	INNER JOIN dataSHJudul ON dataSHJudulPenerbit.kodJudul = dataSHJudul.kodJudul)
	INNER JOIN dataSH ON dataSHJudulPenerbit.id_Penerbit = dataSH.id)
	WHERE dataSHJudulPenerbit.id_Penerbit = '$id'
	  ORDER BY dataSHJudulPenerbit.timestamp DESC";
$result = mysqli_query($connect, $query);
$dataSH = mysqli_fetch_assoc($result);

$a = 1;
if (!empty($dataSH))
{
$output = '
<br />
<h5 align="center">Senarai judul bagi pembekal <strong>'.strtoupper($dataSH["namaPembekal"]).'</strong> untuk negeri <strong>'.$dataSH["negeri"].'</strong></h5>
<table class="table table-bordered table-striped">
 <tr>
  <th width="5%">No</th>
  <th width="30%">Kod Judul</th>
  <th width="50%">Nama Judul</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$a++.'</td>
  <td>'.$row["kodJudul"].'</td>
  <td>'.$row["judul"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
}else
{
	echo '<span class="badge badge-warning">Tiada rekod pendaftaran judul setakat ini</span>';
}
?>