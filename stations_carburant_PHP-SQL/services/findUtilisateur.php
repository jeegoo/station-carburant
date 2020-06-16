<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
$pass=true; //to hide the password
$res=testOneParamValidity("pseudo");
try{
   $reponse=$data->getUser($res);
   makeService($reponse,"user not found!");  //creer le Json affiche  "user not found!" en cas d'erreur
} catch (PDOException $e){
   produceError($e->getMessage());
}


?>
