<?php require('conn.php'); ?>
<?php
      session_start();
      function locationHeader()
      {
          if($_SESSION['role'] == "admin")
            {
                header('Location:emonitoring/index.php');
            }
            else if($_SESSION['role'] == "stokNegeri")
            {
            header('Location:emonitoringNegeri/indexNegeri/index.php');
            }
            else if($res["role"] == "sar")
            {
            header('Location:emonitoringNegeri/epnegeri2.php');
            }
            else if($_SESSION['role'] == "bos")
            {
            header('Location:penyeliaBOSS/indexBOSS/index.php');
            }
            else if($res["role"] != "admin" || $res["role"] != "stokNegeri" ||$res["role"] != "bos")
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