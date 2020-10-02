<?php session_start();?>
<?php
    require('conn.php');
    $id = $_GET['id'];
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

   $judul = $_POST['judul'];
   $zon = $_POST['zon'];
   $state = $_POST['state'];
   $roleID2 = $_POST['roleID'];
   $refID = $_POST['refID'];
    
   if (isset($_POST['submit2'])) {

      $mysqli->query("INSERT INTO `statusBekalan` (`roleID`, `refID`, `judul`, `state`, `zon`) VALUES ('$roleID2', '$refID', $judul', '$state', '$zon')");

      header("location:indexPublisher.php");
    } 

    $id2 = $mysqli->query("SELECT * FROM `login` WHERE id =  '$id'");
    $ReID = mysqli_fetch_assoc($id2);

    $judulCall = $mysqli->query("SELECT * FROM `judul`");
    $JC = mysqli_fetch_assoc($judulCall);

    $stateCall = $mysqli->query("SELECT * FROM `state`");
    $SC = mysqli_fetch_assoc($stateCall);

    $stateCall2 = $mysqli->query("SELECT * FROM `state` GROUP BY `zon`");
    $SC2 = mysqli_fetch_assoc($stateCall2);
?>

<!--start if employeeStatus=='temp'-->

<?php if ($ReID['role'] == 'distiSPBT'){?>
  <form method="post" action="judulModal.php" role="form" enctype="multipart/form-data">
               <div>
                <h6 class="badge badge-success"><?php echo strtoupper($ReID['name']);?></h6>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select name="judul" class="custom-select browser-default" required>
                                  <option value="">Pilih judul yang dihantar</option>
                                  <?php do{?>
                                  <option value="<?php echo $JC['name'];?>"><?php echo ucwords($JC['name']);?></option>
                                  <?php }while ($JC = mysqli_fetch_assoc($judulCall))?>
                                </select>
                                <div class="input-group-append input-group-text">
                                  <span class="fas fa-book"></span>
                               </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select name="state" class="custom-select browser-default" required>
                                  <option value="">Pilih negeri yang dihantar</option>
                                  <?php do{?>
                                  <option value="<?php echo $SC['state'];?>"><?php echo strtoupper($SC['state']);?></option>
                                  <?php }while ($SC = mysqli_fetch_assoc($stateCall))?>
                                </select>
                                <div class="input-group-append input-group-text">
                                  <span class="fas fa-book"></span>
                               </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select name="zon" class="custom-select browser-default" required>
                                  <option value="">Pilih zon yang dihantar</option>
                                  <?php do{?>
                                  <option value="<?php echo $SC2['zon'];?>"><?php echo strtoupper($SC2['zon']);?></option>
                                  <?php }while ($SC2 = mysqli_fetch_assoc($stateCall2))?>
                                </select>
                                <div class="input-group-append input-group-text">
                                  <span class="fas fa-book"></span>
                               </div>
                        </div>
                    </div>
                </div>

                  <input type="hidden" name="roleID" value="<?php echo $ReID['roleID'];?>"/>
                  <input type="hidden" name="refID" value="<?php echo $ReID['refID'];?>"/>
                  <div class="modal-footer">
                      <input type="submit" class="btn btn-primary" name="submit2" value="Daftar tugas"/>&nbsp;
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
    </form> 
<?php }?>


<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/inputmask/jquery.inputmask.bundle.js"></script>

<!--calculate total earning, deduction, grand total
<script src="../calculateTotalSalary.js"></script>-->

<script type="text/javascript">
  $(function() {
     'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
   }, false); 
      
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });  
      
      
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 10000
    });

    $('#swalDefaultSuccess').click(function() {
      Toast.fire({
        type: 'success',
        title: 'Registration Succesfull.Thank you'
      })
    });
    $('.swalDefaultInfo').click(function() {
      Toast.fire({
        type: 'info',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultError').click(function() {
      Toast.fire({
        type: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultWarning').click(function() {
      Toast.fire({
        type: 'warning',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultQuestion').click(function() {
      Toast.fire({
        type: 'question',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

    $('#toastrDefaultSuccess').click(function() {
      toastr.success('Registration Succesfull.Thank you.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
  });

</script>
