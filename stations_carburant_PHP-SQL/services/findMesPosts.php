<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');

if(isset($_SESSION["user"])) {
      try{
         $user=$_SESSION["user"];
         $reponse=$data->getMesPosts($user->pseudo);
         makeService($reponse,"no post found !");  //creer le Json affiche  "no post found !" en cas d'erreur
      } catch (PDOException $e){
           produceError($e->getMessage());
      }
}


?>
