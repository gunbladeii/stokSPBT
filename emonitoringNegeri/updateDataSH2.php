<?php session_start();?>
<?php
    require('conn.php');
    
    date_default_timezone_set("asia/kuala_lumpur"); 
    $date = date('Y-m-d');

    $colname_Recordset = "-1";
    if (isset($_SESSION['user'])) {
      $colname_Recordset = $_SESSION['user'];
    }

    $id = $_GET['id'];
    $username = $_POST['username'];
    $negeri = $_POST['negeri'];
    $tarikhBukaSH = $_POST['tarikhBukaSH'];
    $tarikhTutupSH = $_POST['tarikhTutupSH'];
    $tarikhPenilaianSH = $_POST['tarikhPenilaianSH'];
    $tarikhSSTSH = $_POST['tarikhSSTSH'];
    $namaPembekal = $_POST['namaPembekal'];
    $nilaiSH = $_POST['nilaiSH'];
    $tarikhCO = $_POST['tarikhCO'];
    $bilJudulPesan = $_POST['bilJudulPesan'];
    $bilNaskhahPesan = $_POST['bilNaskhahPesan'];
    $bilNaskhahBekal = $_POST['bilNaskhahBekal'];
    $peratusBekal = $_POST['peratusBekal'];
    $statusBekal = $_POST['statusBekal'];
    $statusTuntut = $_POST['statusTuntut'];
    $statusBayar = $_POST['statusBayar'];
    $remark = $_POST['remark'];
  

    
   if (isset($_POST['update'])) {
    $mysqli->query ("UPDATE `dataSH` SET `tarikhBukaSH` = '$tarikhBukaSH',`tarikhTutupSH` = '$tarikhTutupSH',`tarikhPenilaianSH` = '$tarikhPenilaianSH',`tarikhSSTSH` = '$tarikhSSTSH',`namaPembekal` = '$namaPembekal',`nilaiSH` = '$nilaiSH',`tarikhCO` = '$tarikhCO',`bilJudulPesan` = '$bilJudulPesan',`bilNaskhahPesan` = '$bilNaskhahPesan',`bilNaskhahBekal` = '$bilNaskhahBekal',`peratusBekal` = '$peratusBekal',`statusBekal` = '$statusBekal',`statusTuntut` = '$statusTuntut',`statusBayar` = '$statusBayar',`remark` = '$remark' WHERE `username` = '$username'");
    header("location:epnegeri2.php");
    }

    $Recordset = $mysqli->query("SELECT * FROM login WHERE username = '$colname_Recordset'");
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);

    $Recordset2 = $mysqli->query("SELECT * FROM dataSH WHERE id = '$id'");
    $dataSH = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

?>                   
                        <div class="table-responsive">
                          <form method="post" action="updateDataSH.php" role="form" enctype="multipart/form-data">
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
                                      Tarikh Buka Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhBukaSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhBukaSH'];?>" required>
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
                                      Tarikh Tutup Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhTutupSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhTutupSH'];?>" required>
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
                                      Tarikh Penilaian Sebut Harga:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhPenilaianSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhPenilaianSH'];?>" required>
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
                                      Tarikh Surat Setuju Terima:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhSSTSH" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhSSTSH'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>
                              
                                 <tr>
                                  <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN B</h4></th>
                                </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Nama Pembekal Berjaya:
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
                                      Nilai Sebut Harga (RM):
                                      <div class="input-group mb-3">
                                      <input type="number" name="nilaiSH" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['nilaiSH']);?>" required>
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
                                      Tarikh C/O Dikeluarkan:
                                      <div class="input-group mb-3">
                                      <input type="date" name="tarikhCO" class="form-control"  id="validationDefault01" value="<?php echo $dataSH['tarikhCO'];?>" required>
                                      <div class="input-group-append input-group-text">
                                          <span class="fas fa-id-card-alt"></span>
                                      </div>
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                <th colspan="3" style="text-align: center; background-color: #0d0d0d;"><h4 style="color: white">BAHAGIAN C</h4></th>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Bilangan Judul dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilJudulPesan" class="form-control"  id="validationDefault01" value="<?php echo strtoupper($dataSH['bilJudulPesan']);?>">
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
                                      Bilangan Naskhah dipesan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilNaskhahPesan" class="form-control"  id="bilNaskhahPesan" value="<?php echo strtoupper($dataSH['bilNaskhahPesan']);?>">
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
                                      Bilangan Naskhah Telah dibekal:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="number" name="bilNaskhahBekal" class="form-control"  id="bilNaskhahBekal" value="<?php echo strtoupper($dataSH['bilNaskhahBekal']);?>">
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
                                      Peratus Pembekalan:
                                      <div class="input-group mb-3">
                                      <input style="text-transform: uppercase;" type="text" name="peratusBekal" class="form-control"  id="peratusBekal" value="<?php echo strtoupper($dataSH['peratusBekal']);?>">
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
                                      Status Pembekalan:
                                      <div class="input-group mb-3">
                                               <select name="statusBekal" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusBekal'];?>" selected><?php echo strtoupper($dataSH['statusBekal']);?></option>
                                                   <option value="SELESAI">SELESAI</option>
                                                   <option value="SEDANG BEKAL">SEDANG BEKAL</option>
                                                   <option value="BELUM BEKAL">BELUM BEKAL</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Tuntutan:
                                      <div class="input-group mb-3">
                                               <select name="statusTuntut" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusTuntut'];?>" selected><?php echo strtoupper($dataSH['statusTuntut']);?></option>
                                                   <option value="TELAH TUNTUT">TELAH TUNTUT</option>
                                                   <option value="BELUM TUNTUT">BELUM TUNTUT</option>
                                                   <option value="TUNTUT SEBAHAGIAN">TUNTUT SEBAHAGIAN</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              <tr>
                                  <td>
                                   <div class="form-group">
                                      Status Pembayaran:
                                      <div class="input-group mb-3">
                                               <select name="statusBayar" class="custom-select browser-default">
                                                <option value="<?php echo $dataSH['statusBayar'];?>" selected><?php echo strtoupper($dataSH['statusBayar']);?></option>
                                                   <option value="BELUM">BELUM</option>
                                                   <option value="SELESAI">SELESAI</option>
                                               </select>
                                      </div>
                                      
                                      </div>
                                    </div>
                                </td>
                              </tr>

                              </tbody>
                             </table>
                                <input type="hidden" name="remark" value="observe">
                                <input type="hidden" name="username" value="<?php echo $dataSH['username']; ?>">
                                <input type="hidden" name="negeri" value="<?php echo $dataSH['negeri']; ?>">
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-info" name="update" value="Kemaskini rekod"/>
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