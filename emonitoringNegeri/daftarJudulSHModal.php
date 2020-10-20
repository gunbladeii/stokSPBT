<?php session_start();?>
<?php
      require('conn.php');
      $connect = new PDO("mysql:host=localhost;dbname=spbt_stok", "adminspbt", "Sh@ti5620");
      function fill_unit_select_box($connect)
      { 
       $output = '';
       $query = "SELECT * FROM dataSHJudul ORDER BY kodJudul ASC";
       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $output .= '<option value="'.$row["kodJudul"].'">'.$row["judul"].'</option>';
       }
       return $output;
      }
    
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $id = $_GET['id'];
    

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE username = '$username2'");
    $dataSH = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

?>        

   <h3 align="center" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">Arahan: Klik butang <span class="badge badge-success"><i class="fas fa-plus-square"></i></span> untuk simpan judul secara pukal dan klik "Daftar Rekod" setelah selesai </h3>
   <form method="post" id="insert_form">
    <div class="table-repsonsive">
     <span id="error"></span>
     <table class="table table-bordered table-sm" id="item_table">
      <tr>
       <th width="80%">Pilih Judul</th>
       <th width="20%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="badge badge-success"><i class="fas fa-plus-square"></i></span></button></th>
      </tr>
     </table>
     </div>
     <div align="center">
      <input type="submit" name="submit" class="btn btn-info" value="Daftar Rekod" />
     </div>
     </form>
      <br />
        <div class="table-responsive">
        <div id="inserted_item_data"></div>
        </div>
    
   

 <script>
$(document).ready(function(){
 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  html += '<td><input type="hidden" name="id_Penerbit[]" class="form-control id_Penerbit" value="<?php echo $id; ?>" /><select name="kodJudul[]" class="form-control kodJudul"><option value="">Pilih Judul</option><?php echo fill_unit_select_box($connect); ?></select></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="badge badge-danger"><i class="fas fa-minus-square"></i></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });
 
 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  
  
  $('.kodJudul').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at row "+count+" </p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"insertJudulSH.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
      fetch_item_data();
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });
 function fetch_item_data()
 {
  
  $.ajax({
   url:"fetchdataJudulSH.php?id=<?php echo $id; ?>",
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