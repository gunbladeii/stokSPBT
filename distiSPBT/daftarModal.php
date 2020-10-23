<?php session_start();?>
<?php
    require('conn.php');
    $id = $_GET['id'];
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');
       /*insert into table login and employeeData*/
         $roleID = $_POST['roleID'];
         $refID = $_POST['refID'];
         $name = $_POST['name'];
         $username = $_POST['username'];/*emel instead*/
       /*insert into table login*/
        $password = $_POST['password'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        
    if (isset($_POST['submit'])) {
        $publisherSPBTFacePic = addslashes(file_get_contents($_FILES["publisherSPBTFacePic"]["tmp_name"]));
        
        /*add pictue*/
        
        $mysqli->query("INSERT INTO `login` (`roleID`, `refID`, `name`, `username`, `password`, `role`, `status`, `publisherSPBTFacePic` VALUES ('$roleID', '$refID', $name', '$username', '$password', '$role', '$status', '$publisherSPBTFacePic')");
        
        header("location:indexPublisher.php");
    }
    
    $loginCall = $mysqli->query("SELECT * FROM `login` WHERE id = '$id'");
    $LC = mysqli_fetch_assoc($loginCall);
    
    
?>
  

<form method="post" action="indexPublisher.php" role="form" enctype="multipart/form-data">
        <div class="form-group">
           <label style="padding-left: 15px">User Picture:</label>
           <div class="input-group mb-3">
              <input type="file" name="publisherSPBTFacePic" id="image2" class="form-control" accept="image/*" id="validationDefault17">
              <div class="input-group-append input-group-text">
                <span class="fas fa-portrait"></span>
              </div>
          </div>
         </div>

        <div class="form-group">
          <div class="input-group mb-3">
          <input type="text" name="roleID" class="form-control" placeholder="Cadangan Role ID" id="validationDefault01" required>
          <div class="input-group-append input-group-text">
              <span class="fas fa-id-card-alt"></span>
          </div>
         </div>
        </div>
        
        <div class="form-group">
          <div class="input-group mb-3">
          <input type="text" style="text-transform: uppercase;" class="form-control" placeholder="Taip nama pengedar" name="name" id="validationDefault02" required>
          <div class="input-group-append input-group-text">
              <span class="fas fa-user"></span>
          </div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="input-group mb-3"> 
          <input type="email" name="username" class="form-control" placeholder="Masukkan cadangan username (e-mel)" id="validationDefault03" required>
          <div class="input-group-append input-group-text">
              <span class="fas fa-envelope"></span>
          </div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="input-group mb-3"> 
               <input type="password" name="password" class="form-control" placeholder="Masukkan cadangan password" id="validationDefault04" required>
               <div class="input-group-append input-group-text">
                  <span class="fas fa-lock"></span>
               </div>
          </div>
        </div>
        
        <input type="hidden" name="role" value="distiSPBT"/>
        <input type="hidden" name="status" value="active"/>
        <input type="hidden" name="refID" value="<?php echo $LC['roleID'];?>"/>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="submit" value="Daftar Pengguna Baharu"/>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
<script>  
$(document).ready(function(){  
      $('#submit').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
           
           var image_name2 = $('#image2').val();  
           if(image_name2 == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image2').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image2').val('');  
                     return false;  
                }  
           } 
           
           var image_name3 = $('#image3').val();  
           if(image_name3 == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image3').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image3').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>  
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/inputmask/jquery.inputmask.bundle.js"></script>
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
