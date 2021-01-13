<?php require('conn.php'); ?>
<?php session_start();?>
<?php

date_default_timezone_set("asia/kuala_lumpur");
$date = date('d-F-Y');
$datePHP = date('Y-m-d');

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$kodSekolah = $_GET['kodSekolah'];
$jenisAliran = $_GET['jenisAliran'];
$namaSekolah = $_GET['namaSekolah'];

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);

$Recordset2 = $mysqli->query("SELECT login.username,login.nama,login.jawatan,dataSekolah.kodSekolah,dataSekolah.namaSekolah,dataSekolah.daerah,dataSekolah.negeri, dataSekolah.namaPenyelaras,dataSekolah.noTelefon, dataSekolah.noHP,dataSekolah.enrolmen, dataSekolah.comment, dataSekolah.jenisAliran
  FROM login
  INNER JOIN dataSekolah ON login.remark = dataSekolah.kodSekolah 
  WHERE login.remark = '$kodSekolah'");
$dataJudul = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$a = 1;
?>

<div class="table-responsive">  
  <form method="post" id="update_form">
    <div align="center">
      <h4 style="font-family: 'Roboto Condensed', sans-serif;">Rekod Judul bagi <?php echo strtoupper($dataJudul['namaSekolah']);?></h4>
    </div>
    <div align="center">
      <input type="submit" name="multiple_update" id="multiple_update" class="btn btn-info" value="KEMASKINI" />
    </div>
    <br />
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped">
        <thead align="center">
          <th width="5%"></th>
          <th width="10%">Kod Judul</th>
          <th width="60%">Nama Judul</th>
          <th width="10%">Harga Seunit</th>
          <th width="6%">Darjah / Ting.</th>
          <th width="6%">Buku Rosak ditangan murid</th>
          <th width="6%">Buku Rosak di BOSS/BOSD</th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </form>
</div> 
<!-- DataTables -->
<script src="jquery.dataTables.js"></script>
<script src="dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
<script>  
  $(document).ready(function(){  

    function fetch_data()
    {
      $.ajax({
        url:"insertJudul2.php?kodSekolah=<?php echo $kodSekolah;?>&jenisAliran=<?php echo $jenisAliran;?>",
        method:"POST",
        dataType:"json",
        success:function(data)
        {
          var html = '';
          for(var count = 0; count < data.length; count++)
          {
            html += '<tr align="center">';
            html += '<td><input type="checkbox" id="'+data[count].id+'" data-kodjudul="'+data[count].kodjudul+'" data-namajudul="'+data[count].namajudul+'" data-darjahtingkatan="'+data[count].darjahtingkatan+'" data-bukurosakmurid="'+data[count].bukurosakmurid+'" data-bukurosak="'+data[count].bukurosak+'" data-harga="'+data[count].harga+'" data-jumlahrosak="'+data[count].jumlahrosak+'" data-kosrosak="'+data[count].kosrosak+'" class="check_box"  /></td>';
            html += '<td align="left">'+data[count].kodjudul+'</td>';
            html += '<td align="left">'+data[count].namajudul+'</td>';
            html += '<td align="left">'+data[count].harga+'</td>';
            html += '<td align="left">'+data[count].darjahtingkatan+'</td>';
            html += '<td></td>';
            html += '<td></td></tr>';
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
        html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-kodjudul="'+$(this).data('kodjudul')+'" data-namajudul="'+$(this).data('namajudul')+'" data-darjahtingkatan="'+$(this).data('darjahtingkatan')+'" data-bukurosakmurid="'+$(this).data('bukurosakmurid')+'" data-bukurosak="'+$(this).data('bukurosak')+'" data-harga="'+$(this).data('harga')+'" data-jumlahrosak="'+$(this).data('jumlahrosak')+'" data-hargarosak="'+$(this).data('hargarosak')+'" class="check_box" checked /></td>';
        html += '<td align="left">'+$(this).data('kodjudul')+'</td>';
        html += '<td align="left">'+$(this).data('namajudul')+'</td>';
        html += '<td align="left">'+$(this).data('harga')+'</td>';
        html += '<td align="left">'+$(this).data('darjahtingkatan')+'</td>';
        html += '<td width="6%"><input type="text" name="bukurosakmurid[]" class="form-control" value="" /></td>';
        html += '<td width="6%"><input type="text" name="bukurosak[]" class="form-control" value="" /> <input type="hidden" name="hidden_id[]" value="'+$(this).attr('id')+'" /><input type="hidden" name="kodsekolah[]" value="'<?php echo $kodSekolah?>'" /><input type="hidden" name="namasekolah[]" value="'+$(this).attr('namasekolah')+'" /></td>';

      }
      else
      {
        html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-kodjudul="'+$(this).data('kodjudul')+'" data-namajudul="'+$(this).data('namajudul')+'" data-darjahtingkatan="'+$(this).data('darjahtingkatan')+'" data-bukurosakmurid="'+$(this).data('bukurosakmurid')+'" data-bukurosak="'+$(this).data('bukurosak')+'" data-jumlahrosak="'+$(this).data('jumlahrosak')+'" data-harga="'+$(this).data('harga')+'" data-harga="'+$(this).data('harga')+'" class="check_box" /></td>';
        html += '<td align="left">'+$(this).data('kodjudul')+'</td>';
        html += '<td align="left">'+$(this).data('namajudul')+'</td>';
        html += '<td align="left">'+$(this).data('harga')+'</td>';
        html += '<td align="left">'+$(this).data('darjahtingkatan')+'</td>';
        html += '<td></td>';
        html += '<td></td>';

      }
      $(this).closest('tr').html(html);
    });

    $('#update_form').on('submit', function(event){
      event.preventDefault();
      if($('.check_box:checked').length > 0)
      {
        $.ajax({
          url:"insertJudul3.php",
          method:"POST",
          data:$(this).serialize(),
          success:function()
          {
            alert('Rekod judul telah dikunci masuk');
            fetch_data();
          }
        })
      }
    });

  });  
</script>

