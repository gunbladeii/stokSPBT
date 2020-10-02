<?php require('adminSPBT/conn.php'); ?>
<?php
      session_start();
      function locationHeader()
      {
          if($_SESSION['role'] == "admin")
            {
                header('Location:adminSPBT/index.php');
            }
            else if($_SESSION['role'] == "publisherSPBT")
            {
            header('Location:publisherSPBT/indexPublisher.php');
            }
            else if($_SESSION['role'] == "distiSPBT")
            {
            header('Location:distiSPBT/index.php');
            }
            else
            {
            session_destroy();   
            }
      }
      
      locationHeader();
?>