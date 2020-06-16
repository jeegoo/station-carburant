<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');
if(isset($_SESSION['user'])){
    $pseudo=$_SESSION['user']->pseudo;
    makeService($pseudo,"");
    unset($_SESSION['user']);
    session_destroy();
}

//require('views/pageLogout.php');
?>
