<?php require('conn.php'); ?>
<?php
      session_start();
      function locationHeader()
      {
          if($_SESSION['role'] == "admin")
            {
                header('Location:emonitoring/main1.php');
            }
            else if($_SESSION['role'] == "stokNegeri")
            {
            header('Location:emonitoringNegeri/indexNegeri/index.php');
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