<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

$colname_Recordset = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset = $_SESSION['user'];
}

$id = $_GET['id'];

$Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
$row_Recordset = mysqli_fetch_assoc($Recordset);
$totalRows_Recordset = mysqli_num_rows($Recordset);


date_default_timezone_set("asia/kuala_lumpur"); 
$date = date('Y-m-d'); 
$time = date('H:i:s');
$year = date('Y');

        $refIDPublisher = $row_Recordset['roleID'];
        /*insert into table login and employeeData*/
         $roleID = $_POST['roleID'];
         $refID = $_POST['refID'];
         $name = $_POST['name'];
         $username = $_POST['username'];/*emel instead*/
       /*insert into table login*/
        $password = $_POST['password'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        //$judul = $_POST['judul'];
        //$zon = $_POST['zon'];
        //$state = $_POST['state'];
        
    if (isset($_POST['submit'])) {
        $publisherSPBTFacePic = addslashes(file_get_contents($_FILES["publisherSPBTFacePic"]["tmp_name"]));
     
      $mysqli->query("INSERT INTO `login` (`roleID`, `refID`, `name`, `username`, `password`, `role`, `status`, `publisherSPBTFacePic`) VALUES ('$roleID', '$refID', '$name', '$username', '$password', '$role', '$status', '$publisherSPBTFacePic')");
      
      header("location:controlPanel.php");
    }

    $refID3 = $mysqli->query("SELECT statusBekalan.id, login.name, statusBekalan.roleID,statusBekalan.state, statusBekalan.zon, statusBekalan.totPesanan, statusBekalan.totBekalan, statusBekalan.year, statusBekalan.judul FROM `statusBekalan` INNER JOIN login ON statusBekalan.roleID = login.roleID WHERE statusBekalan.year = '$year' AND statusBekalan.id = '$id'");
    $RID = mysqli_fetch_assoc($refID3);
    $a=1;
?>

<form method="post" action="daftarPengguna.php" role="form" enctype="multipart/form-data">
                            <div>
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
                            </div>

                              <input type="hidden" name="role" value="distiSPBT"/>
                              <input type="hidden" name="status" value="active"/>
                              <input type="hidden" name="refID" value="<?php echo $LC['roleID'];?>"/>
                              <div class="modal-footer">
                                  <input type="submit" class="btn btn-primary" name="submit" value="Daftar Pengguna Baharu"/>&nbsp;
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
</form>