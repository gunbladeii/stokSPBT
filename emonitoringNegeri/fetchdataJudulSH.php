<?php session_start();?>
<?php
//fetch.php
$connect = mysqli_connect("localhost", "adminspbt", "Sh@ti5620", "spbt_stok");
$id = $_GET['id'];
$output = '';
$query = "SELECT dataSHJudulPenerbit.id,dataSHJudulPenerbit.timestamp,dataSHJudulPenerbit.id_Penerbit, dataSH.namaPembekal, dataSH.negeri,dataSHJudulPenerbit.kodJudul, dataSHJudul.judul FROM 
((dataSHJudulPenerbit 
	INNER JOIN dataSHJudul ON dataSHJudulPenerbit.kodJudul = dataSHJudul.kodJudul)
	INNER JOIN dataSH ON dataSHJudulPenerbit.id_Penerbit = dataSH.id)
	WHERE dataSHJudulPenerbit.id_Penerbit = '$id'
	  ORDER BY dataSHJudulPenerbit.timestamp DESC";
$result = mysqli_query($connect, $query);
$a = 1;
if (mysqli_num_rows($result) > 0)
{
		$output = '
		<br />
		<h5 align="center">Judul yang telah didaftarkan</h5>
		<table class="table table-bordered table-responsive">
		 <tr>
		  <th width="5%"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete</button></th>
		  <th width="5%">No</th>
		  <th width="20%">Kod Judul</th>
		  <th width="50%">Nama Judul</th>
		  <th width="10%">Pembekal</th>
		  <th width="10%">Negeri</th>
		 </tr>
		';
		while($row = mysqli_fetch_array($result))
		{
		 $output .= '
		 <tr>
		  <td><input type="checkbox" class="delete_checkbox" value="'.$row["id"].'" /></td>
		  <td>'.$a++.'</td>
		  <td>'.$row["kodJudul"].'</td>
		  <td>'.$row["judul"].'</td>
		  <td>'.strtoupper($row["namaPembekal"]).'</td>
		  <td>'.$row["negeri"].'</td>
		 </tr>
		 ';
		}
		$output .= '</table>';
		echo $output;
}
else
	{
		echo '<span class="badge badge-warning">Tiada pendaftaran judul dibuat setakat ini</span>';
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
