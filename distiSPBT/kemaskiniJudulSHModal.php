<?php session_start();?>
<?php
      require('conn.php');
        
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $kodPembekal = $_GET['kodPembekal'];
    

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT dataJudulPenerbit.id,dataJudulPenerbit.timestamp, dataJudulPenerbit.kodJudul, dataSHJudul.judul, dataSH.namaPembekal FROM 
    ((dataJudulPenerbit 
    INNER JOIN dataSH ON dataJudulPenerbit.kodPembekal = dataSH.kodPembekal)
    INNER JOIN dataSHJudul ON dataJudulPenerbit.kodJudul = dataSHJudul.kodJudul)
    WHERE dataJudulPenerbit.kodpembekal = '$kodPembekal'
      ORDER BY dataJudulPenerbit.timestamp DESC");
    $dataJudulPenerbit = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$b = 1;
?>
    

  <?php if(!empty($dataJudulPenerbit)) {?>
  <div class="container">  
                            <div class="table-responsive">  
                          <form method="post" id="update_form">
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th width="5%">Bil</th>
                                <th width="35%">Pembekal</th>
                                <th width="60%">Nama Judul</th>
                                <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Hapus</button></th>
                            </thead>
                            <?php do {?>
                                <tr>
                                  <td><?php echo $b++;?></td>
                                  <td><?php echo strtoupper($dataJudulPenerbit['namaPembekal']);?></td>
                                  <td><?php echo $dataJudulPenerbit['judul'];?></td>
                                  <td><input type="checkbox" class="delete_checkbox" value="<?php echo $dataJudulPenerbit['id'];?>" /></td>
                                </tr>
                                <?php } while ($dataJudulPenerbit = mysqli_fetch_assoc($Recordset2));?>
                            <tbody></tbody>
                        </table>
                    </div>
                </form>
   </div>  
  <?php }?>

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
            var checkbox_value2 = [];
            $(checkbox).each(function(){
                checkbox_value2.push($(this).val());
            });

            $.ajax({
                url:"deleteJudulSH.php",
                method:"POST",
                data:{checkbox_value2:checkbox_value2},
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