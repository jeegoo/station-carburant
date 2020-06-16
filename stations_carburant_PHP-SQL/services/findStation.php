<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');

$res=testOneParamValidity("id");
try{
   $reponse=$data->getStation($res);
   makeService($reponse,"station not found!");  //creer le Json affiche  "station not found!" en cas d'erreur
} catch (PDOException $e){
   produceError($e->getMessage());
}


?>
