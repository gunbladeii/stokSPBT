<?php session_start();?>
<?php
//fetch.php
$connect = mysqli_connect("localhost", "adminspbt", "Sh@ti5620", "spbt_stok");
$namaPembekal = $_GET['namaPembekal'];
$negeri = $_GET['negeri'];
$output = '';
$query = "SELECT dataJudulPenerbit.id,dataJudulPenerbit.timestamp,dataJudulPenerbit.namaPembekal, dataJudulPenerbit.negeri,dataJudulPenerbit.kodJudul, dataSHJudul.judul FROM 
(dataJudulPenerbit 
	INNER JOIN dataSHJudul ON dataJudulPenerbit.kodJudul = dataSHJudul.kodJudul)
	WHERE dataJudulPenerbit.namaPembekal = '$namaPembekal' AND dataJudulPenerbit.negeri = '$negeri'
	  ORDER BY dataJudulPenerbit.timestamp DESC";
$result = mysqli_query($connect, $query);
$a = 1;
if (mysqli_num_rows($result) > 0)
{
		$output = '
		<br />
		<h5 align="center">Judul yang telah didaftarkan</h5>
		<div class="table-responsive">
		<table class="table table-bordered table-sm">
		 <tr class="bg-warning">
		  <th width="5%">No</th>
		  <th width="20%">Kod Judul</th>
		  <th width="50%">Nama Judul</th>
		  <th width="10%">Pembekal</th>
		  <th width="10%">Negeri</th>
		  <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></th>
		 </tr>
		';
		while($row = mysqli_fetch_array($result))
		{
		 $output .= '
		 <tr>
		  <td>'.$a++.'</td>
		  <td>'.$row["kodJudul"].'</td>
		  <td>'.$row["judul"].'</td>
		  <td>'.strtoupper($row["namaPembekal"]).'</td>
		  <td>'.$row["negeri"].'</td>
		  <td align="center"><input type="checkbox" class="delete_checkbox" value="'.$row["id"].'" /></td>
		 </tr>
		 ';
		}
		$output .= '</table>';
		$output .= '</div>';
		echo $output;
}
else
	{
		echo '<div align="center"><span class="badge badge-warning">Tiada pendaftaran judul dibuat setakat ini</span></div>';
	}
?>
<style>
.removeRow
{
    background-color: #FF0000;
    color:#FFFFFF;
}
</style>
<script>  
$(document).ready(function(){ 

    $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
            $(this).closest('tr').addClass('removeRow');
        }
        else
        {
            $(this).closest('tr').removeClass('removeRow');
        }
    });

    $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        if(checkbox.length > 0)
        {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });

            $.ajax({
                url:"deleteJudulSH.php",
                method:"POST",
                data:{checkbox_value:checkbox_value},
                success:function()
                {
                    $('.removeRow').fadeOut(1500);
                }
            });
        }
        else
        {
            alert("Pilih salah satu rekod untuk dipadam");
        }
    });

});  
</script>
