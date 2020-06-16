<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');


$prams=["pseudo","password"];
$res=testManyParamsValidity($prams);
$pseudo=$res["pseudo"];
$password=$res["password"];
$post=true;
$pass=true;    //set to hide the password value



try{
   $reponse=$data->createUser($pseudo,$password);
   makeService($reponse,"already in data base");  //creer le Json affiche  "no post found !" en cas d'erreur

} catch (PDOException $e){
   produceError($e->getMessage());
}


?>
