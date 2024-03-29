<?php session_start();?>
<?php
//fetch.php
$connect = mysqli_connect("localhost", "adminspbt", "Sh@ti5620", "myspbt");
$kodPembekal = $_GET['kodPembekal'];
$output = '';
$query = "SELECT dataJudulPenerbit.id,dataJudulPenerbit.timestamp,dataJudulPenerbit.kodpembekal, dataJudulPenerbit.kodjudul, login.negeri,dataSHJudul.judul FROM 
(((dataJudulPenerbit 
	INNER JOIN dataSHJudul ON dataJudulPenerbit.kodjudul = dataSHJudul.kodJudul)
	INNER JOIN dataSH ON dataJudulPenerbit.kodpembekal = dataSH.kodPembekal)
	INNER JOIN login ON dataJudulPenerbit.kodpembekal = login.username)
	WHERE dataJudulPenerbit.kodPembekal = '$kodPembekal'
	  ORDER BY dataJudulPenerbit.timestamp DESC";
$result = mysqli_query($connect, $query);
$a = 1;
if (mysqli_num_rows($result) > 0)
{
		$output = '
		<br />
		<h3 class="card-title" style="font-size:14px;">*Tandakan <strong>checkbox</strong> berikut untuk menghapus rekod judul yang tidak berkaitan dan klik butang <strong>Hapus</strong> setelah selesai</h3>
		<br/>
		<h5 align="center"><strong>SENARAI JUDUL UNTUK PEMBEKALAN</strong></h5>
		<div class="table-responsive">
		<table class="table table-bordered table-sm">
		 <tr class="bg-warning">
		  <th width="5%">No</th>
		  <th width="10%">Kod Pembekal</th>
		  <th width="20%">Kod Judul</th>
		  <th width="50%">Nama Judul</th>
		  <th width="10%">Negeri</th>
		  <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></th>
		 </tr>
		';
		while($row = mysqli_fetch_array($result))
		{
		 $output .= '
		 <tr>
		  <td>'.$a++.'</td>
		  <td>'.strtoupper($row["kodpembekal"]).'</td>
		  <td>'.$row["kodjudul"].'</td>
		  <td>'.$row["judul"].'</td>
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
