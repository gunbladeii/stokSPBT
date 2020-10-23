<?php session_start();?>
<?php
    require('conn.php');
    
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $username2 = $_GET['username'];
    $username = $_POST['username'];
    $kodPembekal = $_POST['kodPembekal'];
    $namaPembekal = $_POST['namaPembekal'];
    $alamat = $_POST['alamat'];
    $noTelefon = $_POST['noTelefon'];
  

    
   if (isset($_POST['submit'])) {
    $mysqli->query ("INSERT INTO `dataSH` (`username`,`kodPembekal`, `namaPembekal`, `alamat`,`noTelefon`) VALUES ('$username', '$kodPembekal', '$namaPembekal', '$alamat', '$noTelefon')");
    header("location:epnegeri.php");
    }

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE kodPembekal = '$username2'");
    $dataSH = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

?>                   
                         <div class="table-responsive">
                          <form method="post" action="submitDataSH.php" role="form" enctype="multipart/form-data">
                            <table id="example1" class="table m-0">
                              <thead>
                                <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN A</h4></th>
                                </tr>
                              </thead>
                              <tbody>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Nama Pembekal:
                                      <div class="input-group mb-3">
                                      <input type="text" style="text-transform: uppercase" name="namaPembekal" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['namaPembekal']);?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                               <tr>
                                  <td>
                                   <div class="form-group">
                                      No. Telefon:
                                      <div class="input-group mb-3">
                                      <input type="text" style="text-transform: uppercase" name="noTelefon" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['noTelefon'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Alamat Pejabat:
                                      <div class="input-group mb-3">
                                      <input type="text" style="text-transform: uppercase" name="alamat" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['alamat'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              </tbody>
                             </table>
                                <input type="hidden" name="kodPembekal" value="<?php echo $row_Recordset['username'];?>">
                                <input type="hidden" name="username" value="<?php echo $row_Recordset['id_pegawai'];?>">
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Simpan rekod"/>
                                </div>
                            </form>
                          </div>
                                <script>
                                  $(document).ready(function() {
                                  //this calculates values automatically 
                                  sum();
                                  $("#bilNaskhahBekal,#bilNaskhahPesan").on("keydown keyup", function() {
                                      sum();
                                  });

                                  function sum() {
                                          var num1 = document.getElementById('bilNaskhahBekal').value;
                                          var num2 = document.getElementById('bilNaskhahPesan').value;
                                    var result1 = parseInt(num1) / parseInt(num2);
                                    var result = (parseFloat(result1) * 100).toFixed(2);
                                          if (!isNaN(result)) 
                                          {
                                      document.getElementById('peratusBekal').value = result;
                                          }
                                          
                                      }
                                  });
                             </script>
                            </form>
                          </div>