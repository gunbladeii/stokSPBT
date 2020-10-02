<?php require('conn.php'); ?>
<?php
      session_start();
      function locationHeader()
      {
          if($_SESSION['role'] == "admin")
            {
                header('Location:main1.php');
            }
            else if($_SESSION['role'] == "publisherSPBT")
            {
            header('Location:index.php');
            }
            else if($_SESSION['role'] == "distiSPBT")
            {
            header('Location:index.php');
            }
            else if($res["role"] != "admin" || $res["role"] != "distiSPBT" ||$res["role"] != "publisherSPBT")
            {
            header('Location:index.php?message=fail');
            }
            else
            {
            session_destroy();   
            }
      }
      
      locationHeader();
?>