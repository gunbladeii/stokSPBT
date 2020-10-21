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
    

  <?php if(empty($dataJudulPenerbit)) {?>
  <div class="container">
       <div id="message"></div>
      <div class="panel panel-default">
          <div class="panel-heading"></div>
          <div class="panel-body">
             <div class="row" id="upload_area">
              <form method="post" id="upload_form" enctype="multipart/form-data">
                <div align="center" class="col-md-12">
                  *Pilih fail dalam format .CSV sahaja. Mohon rujuk manual pengguna sistem
                </div>
                <div align="center" class="col-md-12">
                  <input type="file" name="file" id="dataJudulPenerbit" />
                </div>
                <br /><br /><br />
                <div class="col-md-12" align="center">
                  <input type="submit" name="upload_file" id="upload_file" class="btn btn-primary" value="Muat Naik" />
                </div>
              </form>
              
            </div>
            <div class="table-responsive" id="process_area">

            </div>
          </div>
        </div>
     </div>
     <?php }?>

    <div class="table-responsive">
        <div id="inserted_item_data"></div>
    </div>
    
   

<script>
$(document).ready(function(){

  $('#upload_form').on('submit', function(event){

    event.preventDefault();
    $.ajax({
      url:"uploadJudul.php",
      method:"POST",
      data:new FormData(this),
      dataType:'json',
      contentType:false,
      cache:false,
      processData:false,
      success:function(data)
      {
        if(data.error != '')
        {
          $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
        }
        else
        {
          $('#process_area').html(data.output);
          $('#upload_area').css('display', 'none');
          $('#inserted_item_data').css('display', 'none');
        }
      }
    });

  });

  var total_selection = 0;

  var namaPembekal = 0;

  var negeri = 0;

  var kodJudul = 0;

  var judul = 0;

  var column_data = [];

  $(document).on('change', '.set_column_data', function(){

    var column_name = $(this).val();

    var column_number = $(this).data('column_number');

    if(column_name in column_data)
    {
      alert('Pilihan tersebut telah dibuat di lajur '+column_name+ '');

      $(this).val('');

      return false;
    }

    if(column_name != '')
    {
      column_data[column_name] = column_number;
    }
    else
    {
      const entries = Object.entries(column_data);

      for(const [key, value] of entries)
      {
        if(value == column_number)
        {
          delete column_data[key];
        }
      }
    }

    total_selection = Object.keys(column_data).length;

    if(total_selection == 3)
    {
      $('#import').attr('disabled', false);

      namaPembekal = column_data.namaPembekal;

      negeri = column_data.negeri;

      kodJudul = column_data.kodJudul;

      judul = column_data.judul;
    }
    else
    {
      $('#import').attr('disabled', 'disabled');
    }

  });

  $(document).on('click', '#import', function(event){

    event.preventDefault();

    $.ajax({
      url:"importJudul.php",
      method:"POST",
      data:{namaPembekal:namaPembekal, negeri:negeri, kodJudul:kodJudul, judul:judul},
      beforeSend:function(){
        $('#import').attr('disabled', 'disabled');
        $('#import').text('Importing...');
      },
      success:function(data)
      {
        $('#import').attr('disabled', false);
        $('#import').text('Import');
        $('#process_area').css('display', 'none');
        $('#upload_area').css('display', 'none');
        $('#upload_form')[0].reset();
        $('#message').html("<div class='alert alert-success'>"+data+"</div>");
        fetch_item_data();
      }
    })

  });
  
function fetch_item_data()
 {
  
  $.ajax({
   url:"fetchdataJudulSH.php?namaPembekal=<?php echo $namaPembekal;?>&negeri=<?php echo $negeri;?>",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
});
</script>