<?php session_start();?>
<?php
      require('conn.php');
        
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $namaPembekal = $_GET['namaPembekal'];
    $negeri = $_GET['negeri'];
    

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataJudulPenerbit WHERE namaPembekal = '$namaPembekal' AND negeri = '$negeri'");
    $dataJudulPenerbit = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

?>
<div class="container">  
   <div class="table-responsive">  
    <form method="post" id="update_form">
                    <div align="center">
                        <input type="submit" name="multiple_update" id="multiple_update" class="btn btn-info" value="Multiple Update" />
                    </div>
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th width="5%"></th>
                                <th width="20%">Pembekal</th>
                                <th width="30%">Nama Judul</th>
                                <th width="15%">Bil. Pesanan</th>
                                <th width="20%">Bil. Dibekal</th>
                                <th width="10%">Status Bekal</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </form>
   </div>  
  </div>

  <script>  
$(document).ready(function(){  
    
    function fetch_data()
    {
        $.ajax({
            url:"selectPantau.php?namaPembekal=<?php echo $namaPembekal;?>&negeri=<?php echo $negeri;?>",
            method:"POST",
            dataType:"json",
            success:function(data)
            {
                var html = '';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<tr>';
                    html += '<td><input type="checkbox" id="'+data[count].id+'" data-namapembekal="'+data[count].namapembekal+'" data-judul="'+data[count].judul+'" data-bilnaskhahpesan="'+data[count].bilnaskhahpesan+'" data-bilnaskhahbekal="'+data[count].bilnaskhahbekal+'" data-statusbekal="'+data[count].statusbekal+'" class="check_box"  /></td>';
                    html += '<td>'+data[count].namapembekal+'</td>';
                    html += '<td>'+data[count].judul+'</td>';
                    html += '<td>'+data[count].bilnaskhahpesan+'</td>';
                    html += '<td>'+data[count].bilnaskhahbekal+'</td>';
                    html += '<td>'+data[count].statusbekal+'</td></tr>';
                }
                $('tbody').html(html);
            }
        });
    }

    fetch_data();

    $(document).on('click', '.check_box', function(){
        var html = '';
        if(this.checked)
        {
            html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-namapembekal="'+$(this).data('namapembekal')+'" data-judul="'+$(this).data('judul')+'" data-bilnaskhahpesan="'+$(this).data('bilnaskhahpesan')+'" data-bilnaskhahbekal="'+$(this).data('bilnaskhahbekal')+'" data-statusbekal="'+$(this).data('statusbekal')+'" class="check_box" checked /></td>';
            html += '<td><input type="text" name="namapembekal[]" class="form-control" value="'+$(this).data("namapembekal")+'" /></td>';
            html += '<td><input type="text" name="judul[]" class="form-control" value="'+$(this).data("judul")+'" /></td>';
            html += '<td><input type="text" name="bilnaskhahpesan[]" class="form-control" value="'+$(this).data("bilnaskhahpesan")+'" /></td>';
             html += '<td><input type="text" name="bilnaskhahbekal[]" class="form-control" value="'+$(this).data("bilnaskhahbekal")+'" /></td>';
            html += '<td><select name="statusbekal[]" id="statusbekal_'+$(this).attr('id')+'" class="form-control"><option value="Belum Bekal">Belum Bekal</option><option value="Sedang Bekal">Sedang Bekal</option><option value="Selesai">Selesai</option></select><input type="hidden" name="hidden_id[]" value="'+$(this).attr('id')+'" /></td>';
        }
        else
        {
            html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-namapembekal="'+$(this).data('namapembekal')+'" data-judul="'+$(this).data('judul')+'" data-bilnaskhahpesan="'+$(this).data('bilnaskhahpesan')+'" data-bilnaskhahbekal="'+$(this).data('bilnaskhahbekal')+'" data-statusbekal="'+$(this).data('statusbekal')+'" class="check_box" /></td>';
            html += '<td>'+$(this).data('namapembekal')+'</td>';
            html += '<td>'+$(this).data('judul')+'</td>';
            html += '<td>'+$(this).data('bilnaskhahpesan')+'</td>';
            html += '<td>'+$(this).data('bilnaskhahbekal')+'</td>';
            html += '<td>'+$(this).data('statusbekal')+'</td>';            
        }
        $(this).closest('tr').html(html);
        $('#statusbekal_'+$(this).attr('id')+'').val($(this).data('statusbekal'));
    });

    $('#update_form').on('submit', function(event){
        event.preventDefault();
        if($('.check_box:checked').length > 0)
        {
            $.ajax({
                url:"updatePantau.php",
                method:"POST",
                data:$(this).serialize(),
                success:function()
                {
                    alert('Data telah dikemaskini');
                    fetch_data();
                }
            })
        }
    });

});  
</script>