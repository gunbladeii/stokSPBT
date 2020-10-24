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

    $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
    function fill_unit_select_box($connect)
    { 
     $output = '';
     $query = "SELECT * FROM dataSHJudul ORDER BY judul ASC";
     $statement = $connect->prepare($query);
     $statement->execute();
     $result = $statement->fetchAll();
     foreach($result as $row)
     {
      $output .= '<option value="'.$row["kodJudul"].'">'.$row["judul"].'</option>';
     }
     return $output;
    }
    

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE kodPembekal = '$kodPembekal'");
    $dataSH = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

    $Recordset2 = $mysqli->query("SELECT * FROM dataJudulPenerbit WHERE kodPembekal = '$kodPembekal'");
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
                  *Pilih fail dalam format .CSV sahaja. Mohon rujuk manual pengguna sistem. Serta pastikan kod penerbit <strong><?php echo $kodPembekal;?></strong> disertakan dalam maklumat excel .csv
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

    <?php if(!empty($dataJudulPenerbit)) {?>
       <div class="container">
         <h4 align="center">Tambah judul jika terdapat keciciran semasa muat naik secara pukal</h4>
         <br />
         <form method="post" id="insert_form">
          <div class="table-repsonsive">
           <span id="error"></span>
           <table class="table table-bordered" id="item_table">
            <tr>
             <th>Pilih Judul</th>
             <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="badge badge-success"><i class="fas fa-plus"></i></span></button></th>
            </tr>
           </table>
           <div align="center">
            <input type="submit" name="submit" class="btn btn-info" value="Tambah judul" />
           </div>
          </div>
         </form>
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

  var kodPembekal = 0;

  var kodJudul = 0;

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

    if(total_selection == 2)
    {
      $('#import').attr('disabled', false);

      kodPembekal = column_data.kodPembekal;

      kodJudul = column_data.kodJudul;
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
      data:{kodPembekal:kodPembekal, kodJudul:kodJudul},
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

  //tambah judul begin
  $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  html += '<td><select name="kodjudul[]" class="form-control judul"><option value="">Pilih judul</option><?php echo fill_unit_select_box($connect); ?></select><input type="hidden" name="kodpembekal[]" value="<?php echo $kodPembekal; ?>"></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="badge badge-danger"><i class="fas fa-minus"></i></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });
 
 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  
  
  $('.kodjudul').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Pilih judul di lajur "+count+".Sila hapus lajur jika tidak berkaitan dan klik <strong>Tambah judul</strong></p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"tambahjudul.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Judul telah ditambah dalam senarai</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });
  //end tambah judul
  
function fetch_item_data()
 {
  
  $.ajax({
   url:"fetchdataJudulSH.php?kodPembekal=<?php echo $kodPembekal;?>",
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