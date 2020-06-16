<?php
     require('lib/session_init.php');
     if(! isset($_SESSION['user'])){
         require('views/pageLogin.php');
         exit();
       }
 ?>
